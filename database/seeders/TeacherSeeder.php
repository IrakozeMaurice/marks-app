<?php

namespace Database\Seeders;

use App\Models\TeacherUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // //create teacher user
        // TeacherUser::insert([
        //     [
        //         'names' => 'moe',
        //         'email' => 'moe@gmail.com',
        //         'password' => Hash::make('aa'),
        //     ]
        // ]);
    }
}
