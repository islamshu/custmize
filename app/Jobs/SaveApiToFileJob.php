<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
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

            // التحقق من الصلاحيات أولاً
            if (!$this->checkPermissions()) {
                return;
            }

            $response = Http::timeout(60)->get($this->url);

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

            if (!file_exists(base_path($fullPath))) {
                mkdir(base_path($fullPath), 0755, true);
                Log::info("📁 تم إنشاء المجلد: {$fullPath}");
            }

            $tempFilePath = "{$directory}/{$this->type}_api_temp.json";
            $finalFilePath = "{$directory}/{$this->type}_api.json";

            file_put_contents(base_path("uploads/{$tempFilePath}"), $content);
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

    protected function checkPermissions(): bool
    {
        $path = base_path('uploads/api_dumps');
        
        // إنشاء المجلد إذا لم يكن موجوداً
        if (!file_exists($path)) {
            if (!mkdir($path, 0755, true)) {
                Log::error("فشل في إنشاء المجلد: {$path}");
                return false;
            }
            Log::info("تم إنشاء المجلد: {$path}");
        }
        
        // التحقق من إمكانية الكتابة
        if (!is_writable($path)) {
            Log::error("المجلد غير قابل للكتابة: {$path}");
            return false;
        }
        
        return true;
    }

    protected function replaceFile(string $tempPath, string $finalPath): void
    {
        try {
            $fullTempPath = base_path("uploads/{$tempPath}");
            $fullFinalPath = base_path("uploads/{$finalPath}");

            if (file_exists($fullFinalPath)) {
                unlink($fullFinalPath);
                Log::info("🗑️ تم حذف الملف القديم: uploads/{$finalPath}");
            }

            if (!file_exists($fullTempPath)) {
                Log::error("الملف المؤقت غير موجود: uploads/{$tempPath}");
                return;
            }

            rename($fullTempPath, $fullFinalPath);
            
            if (file_exists($fullFinalPath)) {
                chmod($fullFinalPath, 0644);
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
            $fullPath = base_path("uploads/{$tempPath}");
            
            if (!file_exists($fullPath)) {
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
            
            $this->sendTelegram("✅ تم استبدال جميع الملفات المؤقتة بنجاح");
            Log::info("🎉 تم استبدال جميع الملفات المؤقتة بنجاح");
        } else {
            $this->sendTelegram("⚠️ لم يتم استبدال الملفات، بعض الملفات المؤقتة غير جاهزة");
            Log::warning("⚠️ لم يتم استبدال الملفات، بعض الملفات المؤقتة غير جاهزة");
        }
    }

    protected function validateFileContent(string $filePath): bool
    {
        $fullPath = base_path("uploads/{$filePath}");
        
        if (!file_exists($fullPath)) {
            Log::error("الملف غير موجود للتحقق: uploads/{$filePath}");
            return false;
        }

        $content = file_get_contents($fullPath);
        
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

    protected function sendTelegram(string $message): void
    {
        // يمكنك استبدال هذا بتنفيذك الخاص لإرسال الرسائل عبر التليجرام
        Log::info("إرسال رسالة تليجرام: {$message}");
    }
}