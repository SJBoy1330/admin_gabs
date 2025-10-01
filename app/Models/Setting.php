<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $table = 'settings'; // Nama tabel di database
    protected $primaryKey = 'id_setting'; // Primary key

    protected $fillable = [
        'logo','logo_white','image_about', 'icon','icon_white','meta_title','meta_keyword', 'meta_description', 'meta_author','meta_address','lat','lng' // Sesuaikan dengan kolom yang ada di tabel settings
    ];
}
