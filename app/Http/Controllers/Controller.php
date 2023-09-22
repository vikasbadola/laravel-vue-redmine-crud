<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $REDMINE_BASE_URL;
    public $REDMINE_API_KEY;
    public $USE_REDMINE_REST_APIS;

    public function __construct()
    {
        $this->REDMINE_BASE_URL = config('redmine.redmine_server.base_url');
        $this->REDMINE_API_KEY = config('redmine.redmine_server.api_key');
        $this->USE_REDMINE_REST_APIS = config('redmine.redmine_server.use_redmine');
    }
}
