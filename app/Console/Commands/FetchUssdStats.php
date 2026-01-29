<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

class FetchUssdStats extends Command
{
    /**
     * The name and signature of the console command.
     * Use --start_date and --end_date for ranges.
     * If end_date is omitted, it fetches for a single day.
     * php artisan stats:fetch-ussd --start_date=2024-01-01 --end_date=2024-01-31
     */
    protected $signature = 'stats:fetch-ussd
                            {--start_date= : The start date (YYYY-MM-DD)}
                            {--end_date= : The end date (YYYY-MM-DD)}
                            {--model=App\Models\UssdSession : The full class name of the model}';

    /**
     * The console command description.
     */
    protected $description = 'Memory-efficient session stats using index-optimized date ranges';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $modelClass = $this->option('model');

        // Default to today if no start_date provided
        $startDate = $this->option('start_date') ?: now()->format('Y-m-d');
        // Default to start_date if no end_date provided (single day search)
        $endDate = $this->option('end_date') ?: $startDate;

        if (!$this->isValidDate($startDate) || !$this->isValidDate($endDate)) {
            $this->error("Invalid date format. Please use YYYY-MM-DD.");
            return 1;
        }

        try {
            $this->info("Fetching stats from {$startDate} to {$endDate}...");
            $startTime = microtime(true);

            $stats = $this->getStatsForRange($modelClass, $startDate, $endDate);

            $executionTime = round(microtime(true) - $startTime, 4);

            if ($stats->isEmpty()) {
                $this->warn("No data found for the selected range.");
                return 0;
            }

            // Prepare table data
            $rows = $stats->map(fn($item) => [
                ucfirst($item->network),
                number_format($item->sessions)
            ])->toArray();

            // Add a Total row for convenience
            $totalSessions = $stats->sum('sessions');
            $rows[] = ['<fg=green;options=bold>TOTAL</>', '<fg=green;options=bold>' . number_format($totalSessions) . '</>'];

            $this->table(['Network', 'Sessions'], $rows);
            $this->comment("Efficiency: Processed in {$executionTime}s using toBase() hydration.");

        } catch (\Exception $e) {
            $this->error("Error: " . $e->getMessage());
            return 1;
        }

        return 0;
    }

    /**
     * Highly efficient query using raw aggregation and index-friendly range scans.
     */
    private function getStatsForRange(string $modelClass, string $start, string $end): Collection
    {
        if (!class_exists($modelClass) || !is_subclass_of($modelClass, Model::class)) {
            throw new InvalidArgumentException("{$modelClass} is not a valid Eloquent model.");
        }

        // Precise bounds for the datetime column to ensure index usage
        $startBound = $start . ' 00:00:00';
        $endBound   = $end . ' 23:59:59';

        return $modelClass::query()
            ->toBase() // Crucial: Saves memory by avoiding Model object creation
            ->selectRaw('network, COUNT(*) as sessions')
            ->whereBetween('created_at', [$startBound, $endBound]) // Faster than whereDate
            ->groupBy('network')
            ->get();
    }

    /**
     * Simple date validation helper
     */
    private function isValidDate($date)
    {
        return preg_match('/^\d{4}-\d{2}-\d{2}$/', $date);
    }
}