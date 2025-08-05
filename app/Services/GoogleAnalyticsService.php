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
        $client->setAuthConfig(storage_path('app/analytics/service-account.json'));
        $client->addScope('https://www.googleapis.com/auth/analytics.readonly');

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


    public function getTotalUsersByDateRange($propertyId, string $startDate, string $endDate): int
{
    $request = new \Google\Service\AnalyticsData\RunReportRequest([
        'metrics' => [
            ['name' => 'totalUsers'],
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


}
