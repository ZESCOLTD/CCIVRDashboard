<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CallDetailsRecordModel;
use App\Models\CDR\CallDetailsRecordModel as CDRCallDetailsRecordModel;
use Illuminate\Support\Facades\DB;

class FetchCdrTotalUnique extends Command
{
    /**
     * The signature for the command.
     */
    protected $signature = 'stats:cdr-total
                            {--start_date= : YYYY-MM-DD}
                            {--end_date= : YYYY-MM-DD}';

    /**
     * The description shown in php artisan list.
     */
    protected $description = 'Get the grand total of unique customers (src) from CDR for a period';

    public function handle()
    {
        $startDate = $this->option('start_date') ?: now()->startOfMonth()->format('Y-m-d');
        $endDate = $this->option('end_date') ?: now()->format('Y-m-d');
        // 2. Define Extension Filter (As used in your Dashboard logic)
        $dstExtensions = ['cc-3', 'cc-7', 'cc-13', 'cc-15', 'cc-20', 'cc-6', 'cc-18', 'cc-4', 'cc-14', 'cc-8', 'cc-9', 'cc-10', 'cc-11', 'cc-12', 'cc-16', 'cc-17'];

        $this->info("Calculating CDR Stats from $startDate to $endDate...");
        $startTime = microtime(true);

        try {
            // We fetch both counts in one query for maximum efficiency
            $stats = CDRCallDetailsRecordModel::query()
                ->toBase()
                ->whereIn('dst', $dstExtensions)
                ->whereBetween('calldate', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                ->selectRaw('COUNT(*) as total_calls, COUNT(DISTINCT src) as unique_callers')
                ->first();

            $executionTime = round(microtime(true) - $startTime, 2);

            $this->newLine();
            $this->table(
                ['Reporting Period', 'Total Calls', 'Unique Callers', 'Calls Per User'],
                [
                    [
                        "$startDate to $endDate",
                        number_format($stats->total_calls),
                        number_format($stats->unique_callers),
                        $stats->unique_callers > 0 ? round($stats->total_calls / $stats->unique_callers, 2) : 0
                    ]
                ]
            );
            $this->comment("Process took {$executionTime} seconds.");

        } catch (\Exception $e) {
            $this->error("Error: " . $e->getMessage());
            return 1;
        }

        return 0;
    }

}