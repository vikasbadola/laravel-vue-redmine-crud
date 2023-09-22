<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TaskController extends Controller
{
    public function index() {
        $client = new \GuzzleHttp\Client([
            'headers' => [ 'Content-Type' => 'application/json' ]
        ]);
        $headers = [
        'SR-API-TOKEN' => '4968811a2a3c558a012c4dcda5fea599cbf10df1a99973bd6518070a31eccf13'
        ];
        $body = [
            "issue"=> [
                "project_id"=> 1,
                "subject"=> "Example two",
                "priority_id"=> 1,
                "status"=> "new"
            ]
        ];
        $url = "http://redmine:3000/issues.json?key=0c257d4f7896ed923b88d2352588c41facfbb190";
   
    //$data['name'] = "LaravelCode";
    $request = $client->post($url, ['json' => $body]);
    //＄request = ＄client->post(＄url,  ['body'=>$body]);
    //＄response = ＄request->send();
    //$response = $request->send();
  
    dd($request);
// $request = new Request('POST', 'http://admin.sr.appdr.com/ajax/sr/createIssue.do', $headers, $body);
// $res = $client->sendAsync($request)->wait();
// echo $res->getBody();
    }
}
