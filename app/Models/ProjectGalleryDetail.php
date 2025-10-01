<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectGalleryDetail extends Model
{
    use HasFactory;

    protected $table = 'project_gallery_details';
    protected $primaryKey = 'id_gallery_detail';
    public $timestamps = false; // karena created_at & updated_at diatur manual lewat DB

    protected $fillable = [
        'id_project_gallery',
        'id_language',
        'name',
        'created_at',
        'updated_at',
    ];

    // Relasi ke tabel facilitys
    public function project_gallery()
    {
        return $this->belongsTo(ProjectGallery::class, 'id_project_gallery', 'id_project_gallery');
    }

    // Relasi ke tabel languages
    public function language()
    {
        return $this->belongsTo(Language::class, 'id_language', 'id_language');
    }
}
