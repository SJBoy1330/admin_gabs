<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectFacility extends Model
{
    protected $primaryKey = 'id_project_facility';
    public $timestamps = true;

    protected $fillable = [
        'id_project',
        'id_facility',
        'description',
    ];

    // RELASI
    public function project()
    {
        return $this->belongsTo(Project::class, 'id_project', 'id_project');
    }

    public function facility()
    {
        return $this->belongsTo(Facility::class, 'id_facility', 'id_facility');
    }
}
