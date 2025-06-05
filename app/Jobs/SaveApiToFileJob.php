<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SaveApiToFileJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $url;
    protected string $type;
    protected bool $isBatch;

    public function __construct(string $type, string $url, bool $isBatch = false)
    {
        $this->type = $type;
        $this->url = $url;
        $this->isBatch = $isBatch;
    }

    public function handle(): void
    {
        try {
            Log::info("بدء معالجة طلب API لنوع: {$this->type} من URL: {$this->url}");

            $response = Http::timeout(30)->get($this->url);

            if (!$response->successful()) {
                Log::error("❌ فشل في جلب البيانات من {$this->url} مع كود الحالة: " . $response->status() . " | المحتوى: " . $response->body());
                return;
            }

            $content = $response->body();

            if (empty($content)) {
                Log::warning("⚠️ محتوى الـ API فارغ لنوع: {$this->type}!");
                return;
            }

            if (!$this->isValidJson($content)) {
                Log::error("❌ محتوى JSON غير صالح لنوع: {$this->type}");
                return;
            }

            $directory = 'api_dumps';
            $fullPath = "uploads/{$directory}";

            if (!Storage::disk('local')->exists($directory)) {
                Storage::disk('local')->makeDirectory($directory);
                Log::info("📁 تم إنشاء المجلد: {$fullPath}");
            }

            $tempFilePath = "{$directory}/{$this->type}_api_temp.json";
            $finalFilePath = "{$directory}/{$this->type}_api.json";

            Storage::disk('local')->put($tempFilePath, $content);
            Log::info("✅ تم حفظ الملف المؤقت لنوع {$this->type} في: {$fullPath}/{$this->type}_api_temp.json");

            if (!$this->isBatch) {
                $this->replaceFile($tempFilePath, $finalFilePath);
                return;
            }

            $this->checkAllTempFilesReady();

        } catch (\Exception $e) {
            Log::error("❌ خطأ أثناء جلب أو حفظ بيانات {$this->type}: " . $e->getMessage() . " في ملف: " . $e->getFile() . " على السطر: " . $e->getLine());
        }
    }

    protected function replaceFile(string $tempPath, string $finalPath): void
    {
        try {
            if (Storage::disk('local')->exists($finalPath)) {
                Storage::disk('local')->delete($finalPath);
                Log::info("🗑️ تم حذف الملف القديم: uploads/{$finalPath}");
            }

            if (!Storage::disk('local')->exists($tempPath)) {
                Log::error("الملف المؤقت غير موجود: uploads/{$tempPath}");
                return;
            }

            Storage::disk('local')->move($tempPath, $finalPath);
            
            if (Storage::disk('local')->exists($finalPath)) {
                $this->setFilePermissions($finalPath);
                Log::info("🔄 تم تحويل الملف بنجاح إلى: uploads/{$finalPath}");
                
                if (!$this->validateFileContent($finalPath)) {
                    Log::error("الملف النهائي غير صالح: uploads/{$finalPath}");
                }
            } else {
                Log::error("❌ فشل نقل الملف من uploads/{$tempPath} إلى uploads/{$finalPath}");
            }
        } catch (\Exception $e) {
            Log::error("❌ استثناء أثناء استبدال الملف: " . $e->getMessage());
        }
    }

    protected function checkAllTempFilesReady(): void
    {
        $types = ['product', 'price', 'stock'];
        $allReady = true;

        foreach ($types as $type) {
            $tempPath = "api_dumps/{$type}_api_temp.json";
            if (!Storage::disk('local')->exists($tempPath)) {
                Log::warning("الملف المؤقت غير جاهز لنوع: {$type}");
                $allReady = false;
                break;
            }
        }

        if ($allReady) {
            Log::info("🔍 جميع الملفات المؤقتة جاهزة، بدء عملية الاستبدال");

            foreach ($types as $type) {
                $tempPath = "api_dumps/{$type}_api_temp.json";
                $finalPath = "api_dumps/{$type}_api.json";
                $this->replaceFile($tempPath, $finalPath);
            }

            Log::info("🎉 تم استبدال جميع الملفات المؤقتة بنجاح");
        } else {
            Log::warning("⚠️ لم يتم استبدال الملفات، بعض الملفات المؤقتة غير جاهزة");
        }
    }

    protected function validateFileContent(string $filePath): bool
    {
        if (!Storage::disk('local')->exists($filePath)) {
            Log::error("الملف غير موجود للتحقق: uploads/{$filePath}");
            return false;
        }

        $content = Storage::disk('local')->get($filePath);
        
        if (empty($content)) {
            Log::error("الملف فارغ: uploads/{$filePath}");
            return false;
        }
        
        if (!$this->isValidJson($content)) {
            Log::error("محتوى JSON غير صالح في: uploads/{$filePath}");
            return false;
        }
        
        return true;
    }

    protected function isValidJson(string $string): bool
    {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    protected function setFilePermissions(string $filePath): void
    {
        try {
            $fullPath = Storage::disk('local')->path($filePath);
            chmod($fullPath, 0644);
            Log::info("تم تعيين صلاحيات الملف 644 لـ: uploads/{$filePath}");
        } catch (\Exception $e) {
            Log::error("❌ فشل في تعيين صلاحيات الملف: " . $e->getMessage());
        }
    }
}