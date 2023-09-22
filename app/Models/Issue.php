<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Issue extends Model
{
    use HasFactory;
    public $fillable = ['subject', 'description', 'project_id', 'priority_id', 'status_id', 'tracker_id'];

    /**
     * Get the priority details.
     */
    public function priority()
    {
        return $this->belongsTo(Priority::class, 'priority_id', 'id');
    }

    /**
     * Get the status details.
     */
    public function status()
    {
        return $this->belongsTo(IssueStatus::class, 'status_id', 'id');
    }

    /**
     * Get the project details.
     */
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }
}


