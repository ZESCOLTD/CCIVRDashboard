<?php

namespace App\Console\Commands;

use App\Mail\DailyStatisticsMail;
use App\Models\UssdSession;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use QuickChart;

class TEST extends Command
{
//     /**
//      * The name and signature of the console command.
//      *
//      * @var string
//      */
//     protected $signature = 'statistics:daily';

//     /**
//      * The console command description.
//      *
//      * @var string
//      */
//     protected $description = 'Command description';

//     /**
//      * Create a new command instance.
//      *
//      * @return void
//      */
//     public function __construct()
//     {
//         parent::__construct();
//     }

//     /**
//      * Execute the console command.
//      *
//      * @return int
//      */
//     public function handle()
//     {
// //        $stats_by_sessions = $this->stats_by_network();

//         $stats_by_menu = $this->stats_by_menu();

//         $stats_by_complaint = $this->stats_by_complaint();

//         Mail::to([
//             'jloongo@zesco.co.zm',
//             'cnsabika@zesco.co.zm',
//             'nlisita@zesco.co.zm',
//             'csikazwe@zesco.co.zm',
//             'isd@zesco.co.zm',
//             'bkbanda@zesco.co.zm',
//             'CHKaunda@zesco.co.zm',
//             'ccmoonde@zesco.co.zm',
//             'msibalwa@zesco.co.zm',
//             'MNNdhlovu@zesco.co.zm',
//             'LKampengele@zesco.co.zm',
//             'Elijahnyambe@zesco.co.zm',
//             'ict_clt@zesco.co.zm',
//             'malindig@zesco.co.zm',
//             'ckarimamusama@zesco.co.zm',
//             'CCQAssurance@zesco.co.zm'
//         ])->send(new DailyStatisticsMail(compact( 'stats_by_menu','stats_by_complaint')));

//     }

//     private function stats_by_network()
//     {
//         $sessions = UssdSession:: selectRaw("network, to_char(created_at,'Dy') as day,to_char(created_at,'d') as num, COUNT(*) as count")
//             ->whereRaw("to_char(created_at,'IW-YYYY') = to_char(SYSDATE,'IW-YYYY')")
//             ->groupByRaw("network, to_char(created_at,'Dy'),to_char(created_at,'d')")
//             ->orderByRaw("to_char(created_at,'d') ASC")
//             ->get()
//             ->groupBy('network');

//         $chart = [];

//         $chart['type'] = 'bar';
//         $chart['data']['labels'] = ['Mon', 'Tue', 'Wed', 'Thurs', 'Fri', 'Sat', 'Sun'];
//         $dataset = [];

//         foreach ($sessions as $key => $session) {

//             $color = UssdSession::colors()->all()[$key];
//             $dataset[] = [
//                 'label' => $key,
//                 'data' => $session->pluck('count')->all(),
//                 'backgroundColor' => $color

//             ];

//         }

//         $chart['data']['datasets'] = $dataset;
// //        dd(json_encode($chart));
// //        dd($chart);

//         $qc = new QuickChart(array(
//             'width' => 600,
//             'height' => 300,
//         ));

//         $qc->host = '10.1.101.130:3400';
//         $qc->protocol = 'http';
//         $qc->setConfig(json_encode($chart));
//         $qc->backgroundColor = 'white';
//         return $qc->getUrl();
//     }

//     private function stats_by_menu()
//     {
//         $sessions_cumulative = UssdSession::selectRaw('CAST(MENU AS INT) as MENU, COUNT(network) as cumulative')
//             ->groupByRaw('CAST(MENU AS INT)')
//             ->orderBy('cumulative', 'DESC')
//             ->get();

//         $sessions_daily = UssdSession::selectRaw('CAST(MENU AS INT) as MENU, COUNT(network) as daily')
//             ->whereDate('created_at', now()->subDay())
//             ->groupByRaw('CAST(MENU AS INT)')
//             ->orderBy('daily', 'DESC')
//             ->get();

//         $sessions_weekly = UssdSession::selectRaw('CAST(MENU AS INT) as MENU, COUNT(network) as weekly')
//             ->whereRaw("to_char(created_at,'IW-YYYY') = to_char(SYSDATE,'IW-YYYY')")
//             ->groupByRaw('CAST(MENU AS INT)')
//             ->orderBy('weekly', 'DESC')
//             ->get();

//         $sessions_monthly = UssdSession::selectRaw('CAST(MENU AS INT) as MENU, COUNT(network) as monthly')
//             ->whereRaw("to_char(created_at,'mm-YYYY') = to_char(SYSDATE,'mm-YYYY')")
//             ->groupByRaw('CAST(MENU AS INT)')
//             ->orderBy('monthly', 'DESC')
//             ->get();

// //        dd($sessions_monthly);

//         return collect($sessions_cumulative->map(function ($session) use ($sessions_monthly, $sessions_daily, $sessions_weekly) {
//           return [
//               'menu' => $session->menu->description,
//               'cumulative' => $session->cumulative,
//               'weekly' => $sessions_weekly->where('menu',$session->menu)->first()->weekly ?? 0,
//               'daily' => $sessions_daily->where('menu',$session->menu)->first()->daily ?? 0,
//               'monthly' => $sessions_monthly->where('menu',$session->menu)->first()->monthly  ?? 0,
//           ];
//         }));
//     }

//     private function stats_by_complaint()
//     {
//         $complaints_daily =  collect(DB::table('M_APPS_COMPLAINTS')->selectRaw('SYSTEM_ID, COUNT(*) as count')
//             ->whereDate('F_ACTUAL', now()->subDay())
//             ->groupBy('SYSTEM_ID')
//             ->orderBy('count','DESC')->get());

//         $complaints_weekly =  collect(DB::table('M_APPS_COMPLAINTS')->selectRaw('SYSTEM_ID, COUNT(*) as count')
//             ->whereRaw("to_char(F_ACTUAL,'IW-YYYY') = to_char(SYSDATE,'IW-YYYY')")
//             ->groupBy('SYSTEM_ID')
//             ->orderBy('count','DESC')->get());

//         $complaints_monthly =  collect(DB::table('M_APPS_COMPLAINTS')->selectRaw('SYSTEM_ID, COUNT(*) as count')
//             ->whereRaw("to_char(F_ACTUAL,'mm-YYYY') = to_char(SYSDATE,'mm-YYYY')")
//             ->groupBy('SYSTEM_ID')
//             ->orderBy('count','DESC')->get());

//         $complaints_all = collect(DB::table('M_APPS_COMPLAINTS')->selectRaw('SYSTEM_ID, COUNT(*) as count')
//             ->groupBy('SYSTEM_ID')
//             ->orderBy('count','DESC')->get());

// //        dd($complaints_all->pluck('system_id'));

//           $all = collect($complaints_all->map(function ($complaint) use ($complaints_daily, $complaints_weekly, $complaints_monthly) {
//         return [
//             'system_id' => $complaint->system_id,
//             'weekly' => $complaints_weekly->where('system_id',$complaint->system_id)->first()->count ?? 0,
//             'daily' => $complaints_daily->where('system_id',$complaint->system_id)->first()->count  ?? 0,
//             'monthly' => $complaints_monthly->where('system_id',$complaint->system_id)->first()->count  ?? 0,
//             'cumulative' => $complaint->count,

//         ];
//     }));
// //          dd($all);
//         return $all;
//     }





//     <!-- Google tag (gtag.js) -->
// <script async src="https://www.googletagmanager.com/gtag/js?id=G-F62MYGXDSQ"></script>
// <script>
//     window.dataLayer = window.dataLayer || [];
//     function gtag() {
//         dataLayer.push(arguments);
//     }
//     gtag('js', new Date());
//     gtag('config', 'G-F62MYGXDSQ');


// </script>




}
