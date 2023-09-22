<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

class IssueControllerTest extends TestCase
{
    /**
     * Test get endpoint.
     *
     * @return void
     */
    public function testIndexReturnsDataInValidFormat() {
        $this->json('get', 'api/issues')
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure($this->assertJsonStructure());
    }

    /**
     * Test post endpoint.
     *
     * @return void
     */
    public function testStoreReturnsDataInValidFormat() {
        $issueData = [
            "project"=> 1,
            "subject"=> "Test Subjet",
            "description"=> "description",
            "priority"=> 1,
        ];
    
        $this->json('POST', 'api/issues', $issueData)
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure($this->assertJsonStructure());
    }


    function assertJsonStructure() {
        return $assertJsonStructure = [
            'current_page',
            'data' => [
                [
                    "id",
                    "project" => [
                        "id",
                        "name"
                    ],
                    "status" => [
                        "id",
                        "name",
                        "is_closed"
                    ],
                    "priority" => [
                        "id",
                        "name"
                    ],
                    "subject",
                    "description",
                ]
            ]
        ];
    }
}
