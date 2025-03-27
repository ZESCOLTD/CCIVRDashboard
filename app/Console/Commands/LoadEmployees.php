<?php

namespace App\Console\Commands;

use App\Models\PhrisUserDetails;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class LoadEmployees extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'load:employees';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        PhrisUserDetails::where('con_st_code', 'ACT')
            ->where(function ($query) {
                $query->where('contract_type', 'FIXED CONTRACT')
                    ->where('con_per_no', 'like', 'C7%');
            })->orWhere(function ($query) {
                $query->where('contract_type', 'PERMANENT CONTRACT')
                    ->where('con_per_no', '>=', 70000);
            })
            ->whereIn('grade', ['ML0','ML1','ML2','ML3', 'ML4', 'ML5'])
            ->orderBy('con_per_no')
            ->chunk(100, function ($rows) {

                foreach ($rows as $row) {

                    $data = $row->toArray();
                    $data['man_no'] = $row->con_per_no;
                    $data['email'] = str_replace("payroll-reports@zesco.co.zm", null, trim(strtolower($row->staff_email))) ?? null;

                    User::updateOrCreate(
                        [
                            'man_no' => $row->con_per_no,
                        ],
                        $data
                    );

                }

            });
        return 0;
    }
}
