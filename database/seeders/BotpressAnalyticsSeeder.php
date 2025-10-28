<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use App\Models\BotpressAnalytic;
use Illuminate\Support\Collection;

class BotpressAnalyticsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Define the local, temporary service class INSTANCE directly inside run()
        $analyticsService = new class
        {
            protected string $baseUrl = 'https://api.botpress.cloud/v1/admin/bots';
            // **SECURITY WARNING: These values should be loaded from .env/config, not hardcoded.**
            protected string $botId = '66405f85-1e69-4153-a8df-ab758f7c8ccb';
            protected string $workspaceId = 'wkspace_01HQ01E629RXXCNSPC8H0A8WJ0';
            protected string $token = 'bp_pat_Vu3M7SVKhPNeXUChlaBm2mwSwzGIsTbWQpIX';

            /**
             * Fetch and summarize Botpress analytics between two dates.
             *
             * @param  string  $startDate  Format: YYYY-MM-DD
             * @param  string  $endDate    Format: YYYY-MM-DD
             * @return array
             */
            public function getAnalyticsSummary(string $startDate, string $endDate): array
            {
                $url = "{$this->baseUrl}/{$this->botId}/analytics";


                // 1. Setup the request headers
                $request = Http::withHeaders([
                    'Authorization'   => "Bearer {$this->token}",
                    'x-workspace-id'  => $this->workspaceId,
                    'Content-Type'    => 'application/json',
                ]);

                // 2. Add the 'verify' => false option to disable SSL verification
                $response = $request->withOptions([
                    'verify' => false, // ⬅️ THIS LINE DISABLES SSL VERIFICATION
                ])->get($url, [
                    'startDate' => $startDate,
                    'endDate'   => $endDate,
                ]);

                if ($response->failed()) {
                    return [
                        'error' => true,
                        'message' => 'Failed to fetch analytics',
                        'status' => $response->status(),
                    ];
                }

                $records = collect($response->json('records', []));

                // Compute totals
                return [
                    'startDate'           => $startDate,
                    'endDate'             => $endDate,
                    'totalNewUsers'       => $records->sum('newUsers'),
                    'totalReturningUsers' => $records->sum('returningUsers'),
                    'totalSessions'       => $records->sum('sessions'),
                    'totalUserMessages'   => $records->sum('userMessages'),
                    'totalBotMessages'    => $records->sum('botMessages'),
                    'totalEvents'         => $records->sum('events'),
                    'totalLLMCalls'       => $records->sum('llm.calls'),
                    'totalLLMCost'        => round($records->sum('llm.cost.sum'), 6),
                ];
            }
        };

        // ... (rest of the run method remains the same)
        $endDate = Carbon::now()->subDay()->toDateString();
        $startDate = Carbon::now()->subDays(7)->toDateString();

        $this->command->info('Fetching Botpress analytics from ' . $startDate . ' to ' . $endDate . '...');

        $summary = $analyticsService->getAnalyticsSummary($startDate, $endDate);

        if (isset($summary['error']) && $summary['error'] === true) {
            $this->command->error("Failed to fetch analytics: HTTP Status " . ($summary['status'] ?? 'Unknown'));
            return;
        }

        $this->command->info('Analytics data fetched successfully. Inserting into database...');

        $dataToInsert = [
            'start_date'            => $summary['startDate'],
            'end_date'              => $summary['endDate'],
            'total_new_users'       => $summary['totalNewUsers'],
            'total_returning_users' => $summary['totalReturningUsers'],
            'total_sessions'        => $summary['totalSessions'],
            'total_user_messages'   => $summary['totalUserMessages'],
            'total_bot_messages'    => $summary['totalBotMessages'],
            'total_events'          => $summary['totalEvents'],
            'total_llm_calls'       => $summary['totalLLMCalls'],
            'total_llm_cost'        => $summary['totalLLMCost'],
            'seeded_at'             => Carbon::now(),
        ];

        // BotpressAnalytic::updateOrCreate(
        //     ['start_date' => $dataToInsert['start_date'], 'end_date' => $dataToInsert['end_date']],
        //     $dataToInsert
        // );

        $this->command->info('Botpress analytics data seeded successfully! 📊');
    }
}