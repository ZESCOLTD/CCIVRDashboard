<?php

namespace App\Console\Commands;

use App\Models\Live\Recordings;
use Illuminate\Console\Command;

class DeleteEmptyDstRecordings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-empty-dst';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes recordings where the dst column is exactly "empty".';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting to delete recordings with empty dst...');

        $deletedCount = Recordings::where('dst', 'empty')->delete();

        $this->info("Deleted {$deletedCount} records where dst was 'empty'.");

        $this->info('Finished deleting empty dst recordings.');
    }
}