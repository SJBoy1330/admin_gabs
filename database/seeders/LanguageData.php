<?php 
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Language;
use Illuminate\Support\Facades\Hash;

class LanguageData extends Seeder
{
    public function run()
    {
        Language::insert([
            [
                'code' => 'EN',
                'name' => 'English',
                'default' => 'Y'
            ],
            [
                'code' => 'ID',
                'name' => 'Indonesia',
                'default' => 'N'
            ]
        ]);
    }
}
