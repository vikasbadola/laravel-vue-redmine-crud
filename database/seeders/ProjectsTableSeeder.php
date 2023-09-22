<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Project;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $projects = [
            [
                'name' => 'Project 1'
            ],
            [
                'name' => 'Project 2'
            ],
            [
                'name' => 'Project 3'
            ],
            [
                'name' => 'Project 4'
            ],
            [
                'name' => 'Project 5'
            ]
        ];
        Project::insert($projects);
    }
}
