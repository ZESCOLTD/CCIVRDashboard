<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;

class FetchUniqueUsers extends Command
{
    protected $signature = 'stats:unique
                            {--start_date= : YYYY-MM-DD}
                            {--end_date= : YYYY-MM-DD}
                            {--model=App\Models\UssdSession}';

    protected $description = 'Count unique MSISDNs per network for growth analysis';

    public function handle()
    {
        $modelClass = $this->option('model');
        $startDate = $this->option('start_date') ?: now()->format('Y-m-d');
        $endDate = $this->option('end_date') ?: $startDate;

        try {
            $this->info("Calculating unique users from {$startDate} to {$endDate}...");

            $startBound = $startDate . ' 00:00:00';
            $endBound   = $endDate . ' 23:59:59';

            // We use DISTINCT to count unique phone numbers only
            $stats = $modelClass::query()
                ->toBase()
                ->selectRaw('network, COUNT(DISTINCT msisdn) as unique_users')
                ->whereBetween('created_at', [$startBound, $endBound])
                ->groupBy('network')
                ->get();

            if ($stats->isEmpty()) {
                $this->warn("No data found.");
                return 0;
            }

            $rows = $stats->map(fn($item) => [
                ucfirst($item->network),
                number_format($item->unique_users)
            ])->toArray();

            // Total unique across all networks
            $totalUnique = $stats->sum('unique_users');
            $rows[] = ['TOTAL UNIQUE', number_format($totalUnique)];

            $this->table(['Network', 'Unique Users (MSISDNs)'], $rows);

        } catch (\Exception $e) {
            $this->error("Error: " . $e->getMessage());
        }
    }
}