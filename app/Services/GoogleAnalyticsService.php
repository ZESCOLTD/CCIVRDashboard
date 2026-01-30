<?php

namespace App\Services;

use Google\Client;
use Google\Service\AnalyticsData;

class GoogleAnalyticsService
{
    protected $analytics;

    public function __construct()
    {
        $client = new Client();
        // $client->setAuthConfig(base_path('app/analytics/ivr-webstats-9e2a472951cd.json'));
        $client->setAuthConfig(base_path(config('services.google_analytics')));
        $client->addScope('https://www.googleapis.com/auth/analytics.readonly');
        // Disable SSL verification (temporary)
        $client->setHttpClient(new \GuzzleHttp\Client([
            'verify' => false,
        ]));
        $this->analytics = new AnalyticsData($client);
    }

    /**
     * Fetch total users over the last 30 days.
     */
    public function getTotalUsers($propertyId)
    {
        $request = new \Google\Service\AnalyticsData\RunReportRequest([
            'dimensions' => [
                ['name' => 'date'],
            ],
            'metrics' => [
                ['name' => 'totalUsers'],
            ],
            'dateRanges' => [
                ['startDate' => '30daysAgo', 'endDate' => 'today'],
            ],
        ]);

        return $this->analytics->properties->runReport("properties/{$propertyId}", $request);
    }


    public function getTotalUsersByDateRange($propertyId, string $startDate, string $endDate, $metricValue): int
    {
        $request = new \Google\Service\AnalyticsData\RunReportRequest([
            'metrics' => [
                [
                    'name' => $metricValue,
                ],
            ],
            'dateRanges' => [
                ['startDate' => $startDate, 'endDate' => $endDate],
            ],
        ]);

        $response = $this->analytics->properties->runReport("properties/{$propertyId}", $request);

        $totalUsers = 0;

        if (!empty($response->getRows())) {
            $row = $response->getRows()[0];
            $metricValues = $row->getMetricValues();

            if (!empty($metricValues)) {
                $totalUsers = (int) $metricValues[0]->getValue();
            }
        }

        return $totalUsers;
    }


    /**
     * Get GA4 event count
     *
     * @param string $propertyId GA4 property ID (numeric, not G-XXXX)
     * @param string $eventName Event name to fetch
     * @param string $startDate '7daysAgo', '30daysAgo', or 'YYYY-MM-DD'
     * @param string $endDate 'today' or 'YYYY-MM-DD'
     * @return int
     */
    public function getEventCount(string $propertyId, string $eventName, string $startDate = '7daysAgo', string $endDate = 'today'): int
    {
        $request = new \Google\Service\AnalyticsData\RunReportRequest([
            'dimensions' => [['name' => 'eventName']],
            'metrics' => [['name' => 'eventCount']],
            'dateRanges' => [['startDate' => $startDate, 'endDate' => $endDate]],
            'dimensionFilter' => [
                'filter' => [
                    'fieldName' => 'eventName',
                    'stringFilter' => [
                        'value' => $eventName,
                        'matchType' => 'EXACT'
                    ]
                ]
            ]
        ]);

        $response = $this->analytics->properties->runReport("properties/$propertyId", $request);

        $rows = $response->getRows();

        return $rows ? (int)$rows[0]->getMetricValues()[0]->getValue() : 0;
    }
}
