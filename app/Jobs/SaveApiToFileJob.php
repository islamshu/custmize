<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
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
            $response = file_get_contents($this->url);

            if (empty($response)) {
                Log::warning("⚠️ محتوى الـ API فارغ لنوع: {$this->type}!");
                return;
            }

            // تحديد المسارات المطلقة في مجلد root/api_dumps
            $directory = base_path('api_dumps');
            $tempFilePath = $directory . '/' . $this->type . '_api_temp.json';
            $finalFilePath = $directory . '/' . $this->type . '_api.json';

            // تأكد من وجود مجلد api_dumps
            if (!is_dir($directory)) {
                mkdir($directory, 0755, true);
                Log::info("📁 تم إنشاء المجلد api_dumps في root");
            }

            // حفظ الملف المؤقت
            file_put_contents($tempFilePath, $response);
            Log::info("✅ تم حفظ الملف المؤقت لنوع {$this->type} في: $tempFilePath");

            if (!$this->isBatch) {
                $this->replaceFile($tempFilePath, $finalFilePath);
                return;
            }

            $this->checkAllTempFilesReady($directory);

        } catch (\Exception $e) {
            Log::error("❌ خطأ أثناء جلب أو حفظ بيانات {$this->type}: " . $e->getMessage());
        }
    }

    protected function replaceFile(string $tempPath, string $finalPath): void
    {
        // حذف الملف النهائي إذا وُجد
        if (file_exists($finalPath)) {
            unlink($finalPath);
            Log::info("🗑️ تم حذف الملف القديم: $finalPath");
        }

        // إعادة تسمية الملف المؤقت إلى النهائي
        rename($tempPath, $finalPath);
        Log::info("🔄 تم تحويل الملف من $tempPath إلى $finalPath");
    }

    protected function checkAllTempFilesReady(string $directory): void
    {
        $types = ['product', 'price', 'stock'];
        $allReady = true;

        foreach ($types as $type) {
            $tempPath = $directory . '/' . $type . '_api_temp.json';
            if (!file_exists($tempPath)) {
                $allReady = false;
                break;
            }
        }

        if ($allReady) {
            Log::info("🔍 جميع الملفات المؤقتة جاهزة، بدء عملية الاستبدال");

            foreach ($types as $type) {
                $tempPath = $directory . '/' . $type . '_api_temp.json';
                $finalPath = $directory . '/' . $type . '_api.json';
                $this->replaceFile($tempPath, $finalPath);
            }

            Log::info("🎉 تم استبدال جميع الملفات المؤقتة بنجاح");
        }
    }
}
