<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Issue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class IssueController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if($this->USE_REDMINE_REST_APIS) {
            return getRequestHelper($this->REDMINE_BASE_URL, 'issues.json', request('query'), 'issues');
        } else {
            $issues = Issue::
            query()
            ->when(strtoupper(request('query')), function ($query, $searchQuery) {
                $query->where(DB::raw('UPPER(subject)'), 'like', "%{$searchQuery}%")
                ->orwhere(DB::raw('UPPER(description)'), 'like', "%{$searchQuery}%");
            })
            ->with('priority')->with('status')->with('project')
            ->latest()
            ->paginate(paginationLimit());
            return response()->json($issues);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($this->USE_REDMINE_REST_APIS) {
            $requestBody = [
                "issue"=> [
                    "project_id"=> $request->project,
                    "subject"=> $request->subject,
                    "description"=> $request->description,
                    "priority_id"=> $request->priority,
                ]
            ];
            postRequestHelper($this->REDMINE_BASE_URL, 'issues.json', $requestBody, $this->REDMINE_API_KEY);
            return $this->index();
        } else {
            $request->merge(['tracker_id' => 1]);
            $request->merge(['project_id' => $request->project]);
            $request->merge(['priority_id' => $request->priority]);
            $request->merge(['status_id' => 1]);
            $input = $request->all();

            $product = Issue::create($input);
            return $this->index();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $issue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $issue)
    {
        if($this->USE_REDMINE_REST_APIS) {
            $requestBody = [
                "issue"=> [
                    "project_id"=> $request->project,
                    "subject"=> $request->subject,
                    "description"=> $request->description,
                    "priority_id"=> $request->priority,
                ]
            ];
            putRequestHelper($this->REDMINE_BASE_URL, $issue.'.json', $requestBody, $this->REDMINE_API_KEY);
            return $this->index();
        } else {
            $issueDetails = [
                'project_id' => $request->project,
                'priority_id' => $request->priority,
                'description' => $request->description,
                'subject' => $request->subject,
            ];
            Issue::where('id',$issue)->update($issueDetails);
            return $this->index();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $issue
     * @return \Illuminate\Http\Response
     */
    public function destroy($issue)
    {
        if($this->USE_REDMINE_REST_APIS) {
            deleteRequestHelper($this->REDMINE_BASE_URL, $issue.'.json', $this->REDMINE_API_KEY);
            return $this->index();
        } else {
            Issue::where('id',$issue)->delete();
            return $this->index();
        }
    }
}
