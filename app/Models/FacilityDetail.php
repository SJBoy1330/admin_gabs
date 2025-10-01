<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacilityDetail extends Model
{
    use HasFactory;

    protected $table = 'facility_details';
    protected $primaryKey = 'id_facility_detail';
    public $timestamps = false; // karena created_at & updated_at diatur manual lewat DB

    protected $fillable = [
        'id_facility',
        'id_language',
        'name',
        'created_at',
        'updated_at',
    ];

    // Relasi ke tabel facilitys
    public function facility()
    {
        return $this->belongsTo(Facility::class, 'id_facility', 'id_facility');
    }

    // Relasi ke tabel languages
    public function language()
    {
        return $this->belongsTo(Language::class, 'id_language', 'id_language');
    }
}
