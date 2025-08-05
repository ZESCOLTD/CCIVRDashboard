<?php

namespace App\Http\Controllers;

use App\Services\GoogleAnalyticsService;
use Illuminate\Http\JsonResponse;

class AnalyticsController extends Controller
{
    public function index(GoogleAnalyticsService $analytics): JsonResponse
    {
        $propertyId = env('GA4_PROPERTY_ID'); // set in .env
        $report = $analytics->getTotalUsers($propertyId);

        return response()->json($report);
    }

    // For yesterday
    public function getTotalUsersByDateRange(GoogleAnalyticsService $analytics, string $startDate, string $endDate): JsonResponse
    {
        $propertyId = env('GA4_PROPERTY_ID'); // set in .env
        $totalUsers = $analytics->getTotalUsersByDateRange($propertyId, $startDate, $endDate);

        return response()->json(['total_users' => $totalUsers]);
    }
    
    // For last 30 days
    public function getTotalUsersLast30Days(GoogleAnalyticsService $analytics): JsonResponse
    {
        $propertyId = env('GA4_PROPERTY_ID'); // set in .env
        $totalUsers = $analytics->getTotalUsers($propertyId);

        return response()->json(['total_users' => $totalUsers]);
    }
    // For all time
    public function getTotalUsersAllTime(GoogleAnalyticsService $analytics): JsonResponse
    {
        $propertyId = env('GA4_PROPERTY_ID'); // set in .env
        $totalUsers = $analytics->getTotalUsers($propertyId);

        return response()->json(['total_users' => $totalUsers]);
    }


}
