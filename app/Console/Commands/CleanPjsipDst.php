<?php

namespace App\Console\Commands;

use App\Models\Live\Recordings;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CleanPjsipDst extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clean-pjsip-dst';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Removes "PJSIP/" prefix from the dst column in the recordings table.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting to clean the dst column...');

        // Option 1: Using Eloquent (might be slower for large datasets)
        $recordings = Recordings::where('dst', 'like', 'PJSIP/%')->get();

        foreach ($recordings as $recording) {
            $recording->dst = substr($recording->dst, strlen('PJSIP/'));
            $recording->save();
        }

        // Option 2: Using a direct database query (faster for large datasets)
        // DB::table('recordings')
        //     ->where('dst', 'like', 'PJSIP/%')
        //     ->update(['dst' => DB::raw("SUBSTR(dst, LENGTH('PJSIP/') + 1)")]);

        $this->info('Finished cleaning the dst column.');
    }
}