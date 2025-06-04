<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\SaveApiToFileJob;

class SaveApiFilesCommand extends Command
{
    protected $signature = 'api:save-files';

    protected $description = 'Save product, price, and stock API data using queue jobs';

    public function handle()
    {
        $apiUrls = [
            'product' => 'http://www.giftsksa.com/products/all/7efedcf0d9bc4cd1b51d971f2cb4cd46',
            'price'   => 'http://www.giftsksa.com/products/price/7efedcf0d9bc4cd1b51d971f2cb4cd46',
            'stock'   => 'http://www.giftsksa.com/products/stock/7efedcf0d9bc4cd1b51d971f2cb4cd46',
        ];

        foreach ($apiUrls as $type => $url) {
            SaveApiToFileJob::dispatch($type, $url, true);
        }

        $this->info('🚀 تم إرسال العمليات إلى الـ Queue بنجاح');
    }
}
