<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

class FetchUserStats extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'stats:fetch-users
                            {--start_date= : The start date (YYYY-MM-DD)}
                            {--end_date= : The end date (YYYY-MM-DD)}
                            {--limit=50 : Number of top users to display}
                            {--model=App\Models\UssdSession : The full class name of the model}';

    /**
     * The console command description.
     */
    protected $description = 'Group sessions by MSISDN to find most active users efficiently';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $modelClass = $this->option('model');
        $startDate = $this->option('start_date') ?: now()->format('Y-m-d');
        $endDate = $this->option('end_date') ?: $startDate;
        $limit = (int) $this->option('limit');

        if (!$this->isValidDate($startDate) || !$this->isValidDate($endDate)) {
            $this->error("Invalid date format. Please use YYYY-MM-DD.");
            return 1;
        }

        try {
            $this->info("Analyzing top {$limit} users from {$startDate} to {$endDate}...");
            $startTime = microtime(true);

            // Boundaries for index-friendly range scan
            $startBound = $startDate . ' 00:00:00';
            $endBound   = $endDate . ' 23:59:59';

            /** @var \Illuminate\Database\Query\Builder $query */
            $stats = $modelClass::query()
                ->toBase() // Crucial: Prevents loading heavy Eloquent objects into memory
                ->selectRaw('msisdn, network, COUNT(*) as sessions_count')
                ->whereBetween('created_at', [$startBound, $endBound])
                ->groupBy('msisdn', 'network')
                ->orderByDesc('sessions_count')
                ->limit($limit)
                ->get();

            $executionTime = round(microtime(true) - $startTime, 4);

            if ($stats->isEmpty()) {
                $this->warn("No activity found for this period.");
                return 0;
            }

            $headers = ['MSISDN', 'Network', 'Total Sessions'];
            $data = $stats->map(fn($item) => [
                $item->msisdn,
                ucfirst($item->network),
                number_format($item->sessions_count)
            ])->toArray();

            $this->table($headers, $data);
            $this->comment("Report generated in {$executionTime}s.");

        } catch (\Exception $e) {
            $this->error("Error: " . $e->getMessage());
            return 1;
        }

        return 0;
    }

    /**
     * Simple date validation helper
     */
    private function isValidDate($date)
    {
        return preg_match('/^\d{4}-\d{2}-\d{2}$/', $date);
    }
}