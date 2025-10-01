<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectGallery extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'project_galleries';

    // Primary Key
    protected $primaryKey = 'id_project_gallery';

    // Karena PK bukan UUID, tetap auto increment
    public $incrementing = true;

    // Tipe PK
    protected $keyType = 'int';

    // Kalau kamu pakai timestamp custom, set ini ke false
    public $timestamps = false;

    // Kolom yang bisa diisi mass-assignment
    protected $fillable = [
        'id_project',
        'image',
        'created_at',
        'updated_at'
    ];

    /**
     * Relasi ke Project
     */
    public function project()
    {
        return $this->belongsTo(Project::class, 'id_project', 'id_project');
    }

     public function details()
    {
        return $this->hasMany(ProjectGalleryDetail::class, 'id_project_gallery', 'id_project_gallery');
    }
}

