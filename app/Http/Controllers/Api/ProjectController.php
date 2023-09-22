<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if($this->USE_REDMINE_REST_APIS) {
            return getRequestHelper($this->REDMINE_BASE_URL, 'projects.json', request('query'), 'projects');
        } else {
            $projects = Project::all();
            return response()->json($projects);
        }
        // if($this->USE_REDMINE_REST_APIS) {
        //     $client = new \GuzzleHttp\Client();
        //     $url = $this->REDMINE_BASE_URL."/projects.json";
        //     $response = Http::get($url)['projects'];
        //     return response()->json([
        //         'status' => true,
        //         'projects' => $response
        //     ]);
        // } else {

        // }
    }
}
