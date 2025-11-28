<?php

namespace App\Console\Commands;

use App\Models\Live\StasisCDR as LiveStasisCDR;
use App\Models\Live\StasisStartEvent;
use Illuminate\Console\Command;

class RecordingFileNameBackfill extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cdr:backfill-recordings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fills in the missing recording file name on existing StasisCDR entries using the callee StasisStartEvent data.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Starting recording file name backfill process...');

        // 1. Identify records to backfill: answered calls that are missing the file_name.
        $callsToUpdate = LiveStasisCDR::query()
            ->where('is_answered', true)
            ->where(function ($query) {
                // Look for records where file_name is explicitly null OR an empty string
                $query->whereNull('file_name')
                      ->orWhere('file_name', '');
            })
            // Only consider records that actually have a callee to look up the recording file name
            ->whereNotNull('callee_channel_id')
            ->get();

        $totalRecords = $callsToUpdate->count();
        $this->info("Found {$totalRecords} answered CDR records missing the recording file name.");

        if ($totalRecords === 0) {
            $this->comment('No records require file name backfill. Exiting.');
            return 0;
        }

        $progressBar = $this->output->createProgressBar($totalRecords);
        $progressBar->start();
        $updatedCount = 0;

        // 2. Iterate and process each record
        foreach ($callsToUpdate as $cdr) {
            // A. Find the callee's StasisStartEvent using the stored channel ID
            $calleeStartEvent = StasisStartEvent::where('channel_id', $cdr->callee_channel_id)->first();

            if ($calleeStartEvent) {
                // B. Use the accessor in the StasisStartEvent model to get the file name
                // This assumes the accessor is correctly defined as getRecordingFileNameAttribute()
                $recordingFileName = $calleeStartEvent->recording_file_name;

                if ($recordingFileName) {
                    // C. Update the StasisCDR record
                    $cdr->file_name = $recordingFileName;
                    $cdr->save();
                    $updatedCount++;
                }
            }
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine();
        $this->info("Backfill complete. Successfully updated {$updatedCount} CDR records.");

        return 0;
    }
}