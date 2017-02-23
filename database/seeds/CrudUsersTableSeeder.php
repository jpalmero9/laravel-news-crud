<?php

use Illuminate\Database\Seeder;

use App\User;

/**
 * Class UsersTableSeeder
 */
class CrudUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 50)->create();
    }
}
