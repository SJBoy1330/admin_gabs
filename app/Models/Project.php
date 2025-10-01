<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $primaryKey = 'id_project';
    public $timestamps = true; // karena ada created_at & updated_at
    
    protected $fillable = [
        'image',
        'id_type',
        'id_unit',
        'name',
        'id_location',
        'price',
        'stock',
        'address',
        'lat',
        'lng',
        'status',
        'reason',
        'blocked_date',
        'blocked_by',
        'created_by',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'blocked_date' => 'datetime',
    ];

    // RELASI
    public function type()
    {
        return $this->belongsTo(Type::class, 'id_type', 'id_type');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'id_unit', 'id_unit');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'id_location', 'id_location');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id_user');
    }

    public function blocker()
    {
        return $this->belongsTo(User::class, 'blocked_by', 'id_user');
    }

    public function details()
    {
        return $this->hasMany(ProjectDetail::class, 'id_project', 'id_project');
    }

    public function facilities()
    {
        return $this->hasMany(ProjectFacility::class, 'id_project', 'id_project');
    }
    public function galleries()
    {
        return $this->hasMany(ProjectGallery::class, 'id_project', 'id_project');
    }
}
