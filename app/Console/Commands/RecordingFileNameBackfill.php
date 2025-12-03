<?php

namespace App\Console\Commands;

use App\Models\Live\StasisCDR as LiveStasisCDR;
use App\Models\Live\StasisStartEvent;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;

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
    protected $description = 'Fills in the missing recording file name on existing StasisCDR entries using the callee StasisStartEvent data, leveraging bulk optimization.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Starting recording file name backfill process...');
        $chunkSize = 1000;
        $updatedCount = 0;

        // 1. Define the base query for records to backfill: answered calls missing the file_name.
        $baseQuery = LiveStasisCDR::query()
            ->where('is_answered', true)
            ->whereNotNull('callee_channel_id') // Records must have an associated callee channel
            ->where(function (Builder $query) {
                // Criteria for records that are missing the file name:

                // 1. Standard missing values (NULL, empty string, or text placeholders)
                $query->whereNull('file_name')
                      ->orWhere('file_name', '')
                      ->orWhere('file_name', 'N/A');

                // 2. Placeholder UUIDs: Where file_name is still storing the callee_channel_id.
                // This targets corrupted data where the channel ID was incorrectly saved as the file name.
                $query->orWhereRaw('file_name = callee_channel_id');
            })
            // Must order by ID for chunkById
            ->orderBy('id');

        $totalRecords = $baseQuery->count();
        $this->info("Found {$totalRecords} answered CDR records missing the recording file name.");

        if ($totalRecords === 0) {
            $this->comment('No records require file name backfill. Exiting.');
            return 0;
        }

        $progressBar = $this->output->createProgressBar($totalRecords);
        $progressBar->start();

        // 2. Process records in chunks (MEMORY OPTIMIZATION)
        $baseQuery->chunkById($chunkSize, function ($callsToUpdateChunk) use (&$progressBar, &$updatedCount) {

            // Collect all callee channel IDs from the current chunk
            $calleeChannelIdsToProcess = $callsToUpdateChunk->pluck('callee_channel_id')->filter()->toArray();

            if (empty($calleeChannelIdsToProcess)) {
                $progressBar->advance($callsToUpdateChunk->count());
                return;
            }

            // OPTIMIZATION: Bulk fetch all required Callee Start Events for the current chunk
            $calleeStartEvents = StasisStartEvent::whereIn('channel_id', $calleeChannelIdsToProcess)
                ->get()
                // Key the collection by channel_id for fast in-memory lookup
                ->keyBy('channel_id');

            // 3. Iterate and process each record in the chunk
            foreach ($callsToUpdateChunk as $cdr) {
                $calleeChannelId = $cdr->callee_channel_id;

                // In-memory lookup: Find the corresponding callee event
                $calleeStartEvent = $calleeStartEvents->get($calleeChannelId);

                if ($calleeStartEvent) {
                    // Use the accessor to get the file name (assuming it's defined in StasisStartEvent model)
                    $recordingFileName = $calleeStartEvent->recording_file_name;

                    // Ensure the retrieved file name is valid
                    if ($recordingFileName && $recordingFileName !== 'N/A') {
                        // Update the StasisCDR record and save
                        $cdr->file_name = $recordingFileName;
                        $cdr->save();
                        $updatedCount++;
                    }
                }
                $progressBar->advance();
            }
        }); // End of chunkById

        $progressBar->finish();
        $this->newLine();
        $this->info("Backfill complete. Successfully updated {$updatedCount} CDR records.");

        return 0;
    }
}