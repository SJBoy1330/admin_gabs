<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectDetail extends Model
{
    protected $primaryKey = 'id_project_detail';
    public $timestamps = true;

    protected $fillable = [
        'id_project',
        'id_language',
        'specification',
    ];

    protected $casts = [
        'specification' => 'string',
    ];

    // RELASI
    public function project()
    {
        return $this->belongsTo(Project::class, 'id_project', 'id_project');
    }

    public function language()
    {
        return $this->belongsTo(Language::class, 'id_language', 'id_language');
    }
}
