<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

function getTotalCount($apiBaseUrl, $endPoint, $filterQuery, $type)
{
    $url = $apiBaseUrl. '/' .$endPoint. '?limit='. 1;
    $client = new \GuzzleHttp\Client();
    return Http::get($url)['total_count'];
}

function getRequestHelper($apiBaseUrl, $endPoint, $filterQuery, $type)
{
    $url = $apiBaseUrl. '/' .$endPoint;
    $client = new \GuzzleHttp\Client();
    $data = Http::get($url)[$type];
    if (!empty($filterQuery))
    {
        $data = filterIssues($data, $filterQuery);
    }
    
    if($type === 'issues') {
        $data = paginatorHelper($data);
    }
    
    return response()->json($data);
}

function postRequestHelper($apiBaseUrl, $endPoint, $requestBody, $redmineApiKey)
{
    $url = $apiBaseUrl. '/' .$endPoint. '?key='. $redmineApiKey;
    $client = requestHeaders();
    $request = $client->post($url, ['json' => $requestBody]);
}

function putRequestHelper($apiBaseUrl, $endPoint, $requestBody, $redmineApiKey)
{
    $url = $apiBaseUrl. '/issues'. '/' .$endPoint. '?key='. $redmineApiKey;
    $client = requestHeaders();
    $request = $client->put($url, ['json' => $requestBody]);
}

function deleteRequestHelper($apiBaseUrl, $endPoint, $redmineApiKey)
{
    $url = $apiBaseUrl. '/issues'. '/' .$endPoint. '?key='. $redmineApiKey;
    $client = requestHeaders();
    $request = $client->delete($url);
}

function filterIssues($data, $filterQuery)
{
    $newFilteredData = [];
    foreach($data as $filterData)
    {
        if(strpos(strtoupper($filterData['subject']), strtoupper($filterQuery)) !== false
        || strpos(strtoupper($filterData['description']), strtoupper($filterQuery)) !== false
        || strpos($filterData['id'], $filterQuery) !== false
        || strpos(strtoupper($filterData['priority']['name']), strtoupper($filterQuery)) !== false
        || strpos(strtoupper($filterData['status']['name']), strtoupper($filterQuery)) !== false
        ){
            $newFilteredData[] = $filterData;
        }
    }
    return $newFilteredData;
}

function paginatorHelper($data)
{
    $currentPage = LengthAwarePaginator::resolveCurrentPage();
    $perPage = paginationLimit();
    $currentItems = array_slice($data, $perPage * ($currentPage - 1), $perPage);
    $paginator = new LengthAwarePaginator($currentItems, count($data), $perPage, $currentPage);
    return $paginator = new LengthAwarePaginator($currentItems, count($data), $perPage, $currentPage);
}

function paginationLimit()
{
    return 10;
}

function requestHeaders()
{
    return $client = new \GuzzleHttp\Client([
        'headers' => [ 'Content-Type' => 'application/json' ]
    ]);
}


