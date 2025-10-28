<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use App\Models\BotpressAnalytic;
use App\Models\OtherChannel;
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
        $baseUrl = config('services.botpress.base_url', 'https://api.botpress.cloud/v1/admin/bots');
        $botId = config('services.botpress.bot_id', '66405f85-1e69-4153-a8df-ab758f7c8ccb'); // Placeholder
        $workspaceId = config('services.botpress.workspace_id', 'wkspace_01HQ01E629RXXCNSPC8H0A8WJ0'); // Placeholder
         $token = config('services.botpress.token', 'bp_pat_Tf3JubvbnDYuge9zSQzBGP6RtKedgLnxJ0po'); // Placeholder

       if (!$token || !$botId || !$workspaceId) {
           $this->command->error('BotPress API credentials are missing.');
           return 1;
       }

       // Dates for yesterday and the day before yesterday
    //    $yesterday = Carbon::yesterday()->subDay(1)->format('Y-m-d');
    //    $yesterday1 = Carbon::yesterday()->subDay(2)->format('Y-m-d');

    //    $dayBefore = Carbon::yesterday()->subDay(2)->format('Y-m-d');
    //    $dayBefore1 = Carbon::yesterday()->subDay(3)->format('Y-m-d');

       // Dates for yesterday and the day before yesterday
       $yesterday = Carbon::yesterday()->subDay(2)->format('Y-m-d');
       $yesterday1 = Carbon::yesterday()->subDay(3)->format('Y-m-d');

       $dayBefore = Carbon::yesterday()->subDay(3)->format('Y-m-d');
       $dayBefore1 = Carbon::yesterday()->subDay(4)->format('Y-m-d');


       // dd($yesterday, $yesterday1, $dayBefore, $dayBefore1);


       $datesToFetch = [
           'yesterday' => $yesterday,
           'day_before' => $dayBefore,
       ];

       foreach ($datesToFetch as $label => $date) {
           $this->command->newLine();
           $this->command->info("Fetching totals for {$label} ({$date})...");

           if( $label == 'yesterday'){
               $startDate = $yesterday1;
           }
           if( $label == 'day_before'){
               $startDate = $dayBefore1;
           }

           // Botpress analytics endpoint
           $url = "{$baseUrl}/{$botId}/analytics";

           try {
               $response = Http::withHeaders([
                   'Authorization'  => "Bearer {$token}",
                   'x-workspace-id' => $workspaceId,
                   'Content-Type'   => 'application/json',
               ])->withOptions(['verify' => false])
                 ->get($url, [
                     'startDate' => $startDate,
                     'endDate'   => $date,
                 ]);

               if ($response->failed()) {
                   $this->command->error("API call failed for {$date} (Status: {$response->status()})");
                   $this->command->line('Response Body: ' . $response->body());
                   continue;
               }

               $data = $response->json();

               $records = collect($data['records'] ?? []);

               // dd([
               //     'startDate'           => $startDate,
               //     'endDate'             => $date,
               //     'totalNewUsers'       => $records->sum('newUsers'),
               //     'totalReturningUsers' => $records->sum('returningUsers'),
               //     'totalSessions'       => $records->sum('sessions'),
               //     'totalUserMessages'   => $records->sum('userMessages'),
               //     'totalBotMessages'    => $records->sum('botMessages'),
               //     'totalEvents'         => $records->sum('events'),
               //     'totalLLMCalls'       => $records->sum('llm.calls'),
               //     'totalLLMCost'        => round($records->sum('llm.cost.sum'), 6),
               // ] );


               if ($records->isEmpty()) {
                   $this->command->comment("No analytics found for {$date}");
                   continue;
               }

                 // Deduce and define variables needed for DB insertion and output
                 $totalBotMessages = $records->sum('botMessages');
                 $totalSessions = $records->sum('sessions');
                 $totalUserMessages = $records->sum('userMessages');


               // --- START UPDATE OR CREATE LOGIC ---
            //    OtherChannel::updateOrCreate(
            //        // 1. Search Criteria (Key that makes the record unique)
            //        [
            //            'channel_name' => 'chatbot',
            //            'channel_date' => $date,
            //        ],
            //        // 2. Values to Update/Create
            //        [
            //            'total'   => $totalBotMessages,
            //            'details' => $data, // Model cast handles JSON encoding/decoding
            //        ]
            //    );
               // --- END UPDATE OR CREATE LOGIC ---


               $this->command->info("Inserted totals for {$date}: Sessions {$totalSessions}, Users {$totalUserMessages}, Bots {$totalBotMessages}");

           } catch (\Throwable $e) {
               $this->command->error("Error fetching {$date}: " . $e->getMessage());
               continue;
           }
       }

       $this->command->newLine();
       $this->command->info('✅ Daily totals successfully updated for yesterday and the day before yesterday.');

        $this->command->info('Botpress analytics data seeded successfully! 📊');
    }
}