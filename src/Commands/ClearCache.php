<?php

namespace SaaSykit\OpenGraphy\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ClearCache extends Command
{
    public $signature = 'open-graphy:clear';

    public $description = 'Clears generated open graph images';

    public function handle(): int
    {
        $this->info('Clearing cached open graphy images...');

        $storageDisk = Storage::disk(config('open-graph-image.storage.disk'));

        $storageDisk->deleteDirectory(config('open-graph-image.storage.path'));

        $this->comment('All done');

        return self::SUCCESS;
    }
}
