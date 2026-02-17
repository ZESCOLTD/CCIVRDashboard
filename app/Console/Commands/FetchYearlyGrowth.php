<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

class FetchYearlyGrowth extends Command
{
    /**
     * The signature now accepts dynamic date ranges.
     */
    protected $signature = 'stats:growth
                            {--start_date= : The start date (YYYY-MM-DD)}
                            {--end_date= : The end date (YYYY-MM-DD)}
                            {--model=App\Models\UssdSession : The full class name of the model}';

    protected $description = 'Dynamic Year-over-Year growth analysis for sessions and unique users';

    public function handle()
    {
        $modelClass = $this->option('model');

        // Default to your 6-year window if no dates are provided
        $startDate = $this->option('start_date') ?: '2020-02-01';
        $endDate   = $this->option('end_date') ?: '2026-01-31';

        $this->info("Analyzing growth from {$startDate} to {$endDate}...");

        $startBound = $startDate . ' 00:00:00';
        $endBound   = $endDate . ' 23:59:59';

        try {

            $stats = $modelClass::query()
                ->toBase()
                ->selectRaw("
                    EXTRACT(YEAR FROM created_at) as year,
                    COUNT(*) as total_sessions,
                    COUNT(DISTINCT msisdn) as unique_users
                ")
                ->whereBetween('created_at', [$startBound, $endBound])
                ->groupByRaw("EXTRACT(YEAR FROM created_at)") // Oracle requires repeating the expression
                ->orderByRaw("EXTRACT(YEAR FROM created_at) ASC")
                ->get();

            if ($stats->isEmpty()) {
                $this->warn("No data found for the selected range.");
                return 0;
            }

            $this->renderTable($stats);

        } catch (\Exception $e) {
            $this->error("Error: " . $e->getMessage());
        }

        return 0;
    }

    private function renderTable(Collection $stats)
    {
        $rows = [];
        $lastSessions = 0;

        foreach ($stats as $item) {
            // Calculate Growth % compared to the previous year in the collection
            $growth = ($lastSessions > 0)
                ? (($item->total_sessions - $lastSessions) / $lastSessions) * 100
                : 0;

            $rows[] = [
                $item->year,
                number_format($item->total_sessions),
                number_format($item->unique_users),
                ($lastSessions > 0) ? number_format($growth, 1) . '%' : 'New Period'
            ];

            $lastSessions = $item->total_sessions;
        }

        $this->table(['Year', 'Sessions', 'Unique Users', 'Growth (%)'], $rows);
    }
}