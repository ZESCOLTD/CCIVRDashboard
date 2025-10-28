<?php
namespace App\Services;


use Illuminate\Support\Facades\Http;

use Illuminate\Support\Collection;



class BotpressAnalyticsService

{

    protected string $baseUrl = 'https://api.botpress.cloud/v1/admin/bots';

    protected string $botId = '66405f85-1e69-4153-a8df-ab758f7c8ccb';

    protected string $workspaceId = 'wkspace_01HQ01E629RXXCNSPC8H0A8WJ0';

    protected string $token = 'bp_pat_Vu3M7SVKhPNeXUChlaBm2mwSwvGIsTbWQpIX';



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



        $response = Http::withHeaders([

            'Authorization'   => "Bearer {$this->token}",

            'x-workspace-id'  => $this->workspaceId,

            'Content-Type'    => 'application/json',

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

            'startDate'        => $startDate,

            'endDate'          => $endDate,

            'totalNewUsers'    => $records->sum('newUsers'),

            'totalReturningUsers' => $records->sum('returningUsers'),

            'totalSessions'    => $records->sum('sessions'),

            'totalUserMessages'=> $records->sum('userMessages'),

            'totalBotMessages' => $records->sum('botMessages'),

            'totalEvents'      => $records->sum('events'),

            'totalLLMCalls'    => $records->sum('llm.calls'),

            'totalLLMCost'     => round($records->sum('llm.cost.sum'), 6),

        ];

    }

}





