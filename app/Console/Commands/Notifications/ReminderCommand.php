<?php

namespace App\Console\Commands\Notifications;

use App\Mail\ActingMail;
use App\Models\AppraisalHeader;
use App\Models\User;
use App\ReminderMail;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ReminderCommand extends Command
{
    protected $signature = 'reminder:send';

    protected $description = 'Command description';

    public function handle()
    {

        $recipients = config('mail-groups.Staff-Movement-Group');

        $this->sendEmailNotification(1);
        $this->sendEmailNotification( 7);
        $this->sendEmailNotification( 15);
        $this->sendEmailNotification( 30);

    }

    public function sendEmailNotification($days)
    {
//        foreach ($this->getExpectedDate($days) as $key => $item) {

        AppraisalHeader::orderBy('id')->chunk(100, function ($users) use ($days) {
            foreach ($users as $item) {

                Log::info('Reminders!' . now()->toDateString() . " " . $item->appraiser_man_no . " " . $item->appraiser_name );

                $days_word = $days > 1 ? $days . ' days' : $days . ' day';
                $endDate = !is_null($item->end_date) ? date("d M Y", strtotime($item->end_date)) : " ";

                $details = [
                    'url' => config('app.url'),
                    'subject' => config('mail-subjects.Due-Acting'),
                    'body' => "<p>This is an automated reminder to let you know that an appraisal of the employee with the following details will be due in <strong>$days_word</strong></p>
                            <ul>
                                <li><strong>Man No:</strong> $item->appraisee_man_no</li>
                                <li><strong>Name:</strong> $item->appraisee_name </li>
                                <li><strong>Location:</strong> $item->appraisee_location </li>
                                <li><strong>Functional Section:</strong> $item->appraisee_functional_section </li>
                                <li><strong>Position:</strong> $item->appraisee_position </li>
                                <li><strong>Grade:</strong> $item->appraisee_grade </li>
                            </ul>
                          ",
                ];

                try {
                    retry(2, function () use ($item, $details) {
                        Mail::
//                        to($item->appraiser_email)
                            bcc([
                                'ccmoonde@zesco.co.zm'
                            ])
                            ->send(new ReminderMail($details));
                    }, 60000

                    );
                } catch (\Exception $e) {
                }

            }//end of loop
        });

//        }
    }

    public function getExpectedDate($days)
    {
        //days before
        return AppraisalHeader::
        whereDate('from', '=', Carbon::now()->addDays($days))
//            ->onlyApproved()
            ->get();
    }
}
