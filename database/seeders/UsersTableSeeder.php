<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $nbrUsers = (int)$this->command->ask("How many of user you want generate ?",10);

        $users = \App\Models\User::factory($nbrUsers)->create();
    }
}
