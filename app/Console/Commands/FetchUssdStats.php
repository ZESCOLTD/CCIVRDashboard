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
     * php artisan stats:fetch-ussd --date=2024-01-15
     */
    protected $signature = 'stats:fetch-ussd
                            {--model=App\Models\UssdSession : The full class name of the model}
                            {--date= : The date to fetch stats for (YYYY-MM-DD)}';

    /**
     * The console command description.
     */
    protected $description = 'Efficiently fetch session statistics grouped by network using index-optimized queries';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $modelClass = $this->option('model');
        $date = $this->option('date') ?: now()->format('Y-m-d');

        // Basic date format validation
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            $this->error("Invalid date format. Please use YYYY-MM-DD.");
            return 1;
        }

        try {
            $this->info("Querying data for {$date}...");
            $startTime = microtime(true);

            $stats = $this->getStatsForDate($modelClass, $date);

            $executionTime = round(microtime(true) - $startTime, 2);

            if ($stats->isEmpty()) {
                $this->warn("No records found for {$date}.");
                return 0;
            }

            $this->table(
                ['Network', 'Total Sessions'],
                $stats->map(fn($item) => [$item->network, number_format($item->sessions)])->toArray()
            );

            $this->comment("Query completed in {$executionTime}s using memory-efficient hydration.");

        } catch (\Exception $e) {
            $this->error("Error: " . $e->getMessage());
            return 1;
        }

        return 0;
    }

    /**
     * Optimized query logic
     */
    private function getStatsForDate(string $modelClass, string $date): Collection
    {
        if (!class_exists($modelClass) || !is_subclass_of($modelClass, Model::class)) {
            throw new InvalidArgumentException("{$modelClass} is not a valid Eloquent model.");
        }

        // Using whereBetween instead of whereDate to allow the DB to use indexes efficiently
        $start = $date . ' 00:00:00';
        $end   = $date . ' 23:59:59';

        return $modelClass::query()
            ->toBase() // Crucial: Prevents memory exhaustion by not creating Model objects
            ->selectRaw('network, COUNT(*) as sessions')
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('network')
            ->get()
            ->keyBy('network');
    }
}