<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SessionStatsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 👇 Use the omni_channel connection
        $connection = 'omni_channel';

        $this->command->info("🔍 Fetching session stats from [$connection] Oracle database...");

        $results = DB::connection($connection)->select("
            SELECT
                network,
                TO_CHAR(created_at, 'YYYY-MM') AS month,
                COUNT(*) AS sessions
            FROM
                ussd_sessions
            WHERE
                TO_CHAR(created_at, 'YYYY') = '2025'
            GROUP BY
                network,
                TO_CHAR(created_at, 'YYYY-MM')
            ORDER BY
                month
        ");

        if (empty($results)) {
            $this->command->warn('⚠️ No session data found for 2025.');
            return;
        }

        $this->command->info("✅ Found " . count($results) . " rows:\n");

        // Print results as a pretty table
        $this->command->table(
            ['Network', 'Month', 'Sessions'],
            array_map(fn($r) => [
                $r->network,
                $r->month,
                $r->sessions,
            ], $results)
        );
    }
}
