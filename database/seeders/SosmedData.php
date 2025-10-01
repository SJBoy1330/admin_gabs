<?php 
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sosmed;
use App\Models\SosmedSetting;
use Illuminate\Support\Facades\Hash;

class SosmedData extends Seeder
{
    public function run()
    {
        Sosmed::insert([
            [
                'icon' => 'fa-brands fa-facebook',
                'name' => 'facebook'
            ],
            [
                'icon' => 'fa-brands fa-x-twitter',
                'name' => 'twitter'
            ],
             [
                'icon' => 'fa-brands fa-instagram',
                'name' => 'instagram'
            ],
             [
                'icon' => 'fa-brands fa-youtube',
                'name' => 'youtube'
            ],
        ]);

        for ($i=1; $i <=4 ; $i++) { 
            SosmedSetting::insert([
                [
                    'id_setting' => 1,
                    'id_sosmed' => $i,
                    'url' => '#'
                ]
            ]);
        }
        
    }
}
