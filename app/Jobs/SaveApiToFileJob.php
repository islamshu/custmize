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
            $response = Http::get($this->url);

            if (!$response->successful()) {
                Log::error("❌ فشل في جلب البيانات من {$this->url} مع كود الحالة: " . $response->status());
                return;
            }

            $content = $response->body();

            if (empty($content)) {
                Log::warning("⚠️ محتوى الـ API فارغ لنوع: {$this->type}!");
                return;
            }

            // تأكد من وجود مجلد api_dumps داخل storage/app
            $directory = 'api_dumps';
            if (!Storage::disk('local')->exists($directory)) {
                Storage::disk('local')->makeDirectory($directory);
            }

            $tempFilePath = $directory . '/' . $this->type . '_api_temp.json';
            $finalFilePath = $directory . '/' . $this->type . '_api.json';

            Storage::disk('local')->put($tempFilePath, $content);
            Log::info("✅ تم حفظ الملف المؤقت لنوع {$this->type} في: $tempFilePath");

            if (!$this->isBatch) {
                $this->replaceFile($tempFilePath, $finalFilePath);
                return;
            }

            $this->checkAllTempFilesReady();

        } catch (\Exception $e) {
            Log::error("❌ خطأ أثناء جلب أو حفظ بيانات {$this->type}: " . $e->getMessage());
        }
    }

    protected function replaceFile(string $tempPath, string $finalPath): void
    {
        if (Storage::disk('local')->exists($finalPath)) {
            Storage::disk('local')->delete($finalPath);
            Log::info("🗑️ تم حذف الملف القديم: $finalPath");
        }

        Storage::disk('local')->move($tempPath, $finalPath);
        Log::info("🔄 تم تحويل الملف من $tempPath إلى $finalPath");
    }

    protected function checkAllTempFilesReady(): void
    {
        $types = ['product', 'price', 'stock'];
        $allReady = true;

        foreach ($types as $type) {
            $tempPath = 'api_dumps/' . $type . '_api_temp.json';
            if (!Storage::disk('local')->exists($tempPath)) {
                $allReady = false;
                break;
            }
        }

        if ($allReady) {
            Log::info("🔍 جميع الملفات المؤقتة جاهزة، بدء عملية الاستبدال");

            foreach ($types as $type) {
                $tempPath = 'api_dumps/' . $type . '_api_temp.json';
                $finalPath = 'api_dumps/' . $type . '_api.json';
                $this->replaceFile($tempPath, $finalPath);
            }

            Log::info("🎉 تم استبدال جميع الملفات المؤقتة بنجاح");
        }
    }
}
