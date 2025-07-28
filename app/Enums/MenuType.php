<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class MenuType extends Enum
{
    const ReportFault =   1;
    const TrackFault =   2;
    const PrepaidToken = 3;
    const Simulator = 4;
    const TrackApplication = 5;
    const PostPaidBills = 6;
    const GetApp = 7;
    const TalkToAgent = 8;
    const SmsAlert = 9;

    const LoadManagement = 10;

    const Undefined = 0;
}
