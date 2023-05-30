<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 11; $i++) {
            $new_user = new User();
            $new_user->name = 'user';
            $new_user->surname = "$i";
            $new_user->email = 'example' . $i . '@mail.com';
            $new_user->password = bcrypt('prova1234');
            $new_user->save();
        }
    }
}
