<?php

namespace App\Http\Controllers;

use App\Models\AppraisalStatus;
use App\Models\Employee;
use App\Models\PhrisUserDetails;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getManNumbers(Request $request)
    {
        $search = strtolower($request->search);
        $page = (int)$request->page;

        $resultCount = 25;

        $offset = ($page - 1) * $resultCount;

        if ($search == '') {
            $dataset = PhrisUserDetails::
            where('con_st_code', 'ACT')
                ->where(function ($query) {
                    $query->where(function ($query) {
                        $query->where('contract_type', 'FIXED CONTRACT')
                            ->where('con_per_no', 'like', 'C7%');
                    })->orWhere(function ($query) {
                        $query->where('contract_type', 'PERMANENT CONTRACT')
                            ->where('con_per_no', '>=', 70000);
                    });
                })
                ->orderby('con_per_no', 'desc')
                ->skip($offset)
                ->take($resultCount)
                ->get();

            $count = PhrisUserDetails::count();
        } else {
            $dataset = PhrisUserDetails::
//            select('con_per_no', 'name')
            where('con_st_code', 'ACT')
                ->where(function ($query) {
                    $query->where(function ($query) {
                        $query->where('contract_type', 'FIXED CONTRACT')
                            ->where('con_per_no', 'like', 'C7%');
                    })->orWhere(function ($query) {
                        $query->where('contract_type', 'PERMANENT CONTRACT')
                            ->where('con_per_no', '>=', 70000);
                    });
                })
                ->where(function ($query) use ($search) {
                    $query->whereRaw("LOWER(con_per_no) LIKE LOWER('%{$search}%')")
                        ->orWhereRaw("LOWER(name) LIKE LOWER('{$search}%')");
                })
                ->orderby('con_per_no', 'asc')
                ->skip($offset)
                ->take($resultCount)
                ->get();

            $count = $dataset->count();
        }


        $endCount = $offset + $resultCount;
        $morePages = $count > $endCount;


        $results = [];
        foreach ($dataset as $item) {
            $results[] = [
                "id" => $item->con_per_no,
                "text" => $item->con_per_no . ":" . " " . $item->name
            ];
        }


        $response = [
            "results" => $results,
            "pagination" => ["more" => $morePages]
        ];

        return response()->json($response);
    }

    public function getManNumber(Request $request)
    {

        $dataset = PhrisUserDetails::
        select('con_per_no', 'name')
            //->whereRaw("LOWER(con_per_no) LIKE '%{$search}%'")
            ->where('con_per_no', $request->con_per_no)
            ->first();


        $results = [
            "id" => $dataset->con_per_no,
            "text" => $dataset->con_per_no . ":" . " " . $dataset->name
        ];

        return response()->json($results);
    }
}
