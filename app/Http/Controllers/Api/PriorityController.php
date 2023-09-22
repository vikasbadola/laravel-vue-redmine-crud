<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Priority;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PriorityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if($this->USE_REDMINE_REST_APIS) {
            return getRequestHelper(
                $this->REDMINE_BASE_URL,
                'enumerations/issue_priorities.json',
                request('query'),
                'issue_priorities'
            );
        } else {
            $priorities = Priority::all();
            return response()->json($priorities);
        }
    }

}
