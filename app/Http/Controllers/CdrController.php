<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CDR\CallDetailsRecordModel;

class CdrController extends Controller
{
    //
    public function saveCdr(Request $request)
    {

        //dd("dst",$request->dst);
        //$token = Str::random(60);

        $record = CallDetailsRecordModel::create(
            [
                'accountcode' => $request->accountcode,
                'src' => $request->src,
                'dst' => $request->dst,
                'dcontext' => $request->dcontext,
                'clid' => $request->clid,
                'channel' => $request->channel,
                'dstchannel' => $request->dstchannel,
                'lastapp' => $request->lastapp,
                'lastdata' => $request->lastdata,
                'calldate' => $request->calldate,
                'answerdate' => $request->answerdate,
                'hangupdate' => $request->hangupdate,
                'duration' => $request->duration,
                'billsec' => $request->billsec,
                'disposition' => $request->disposition,
                'amaflags' => $request->amaflags,
                'uniqueid' => $request->uniqueid,
                'userfield' => $request->userfield
            ]
        );

        //        $request->user()->forceFill([
        //          'api_token' => hash('sha256', $token),
        //      ])->save();

        return ['cdr' => $record];
    }
}
