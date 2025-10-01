<?php 
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AccountData extends Seeder
{
    public function run()
    {
        User::insert([
            [
                'name' => 'Saka Devs',
                'role' => 1,
                'email' => 'saka_devs@gmail.com',
                'password' => Hash::make('Aa_1234%'),
            ]
        ]);
    }
}
