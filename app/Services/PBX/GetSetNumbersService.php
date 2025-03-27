<?php


namespace App\Services\PBX;

use App\Models\Live\CCAgent;
use Illuminate\Support\Facades\Auth;

class GetSetNumbersService
{
    /**
     * get currently logged in user
     *
     **/
    public static function getSetNumbers()
    {

        $agents = CCAgent::get() ;

        foreach( $agents as  $agent ){
           $set_number = self::scriptToGetSetNumber(  $agent->endpoint  );

           ///save the set number
           $agent ->set_number =    $set_number  ;
           $agent ->save() ;

        }
    }

    public static function scriptToGetSetNumber($agent_number){

        $set_number = 1 ;

        //logiv

        return $set_number ;
    }

}


