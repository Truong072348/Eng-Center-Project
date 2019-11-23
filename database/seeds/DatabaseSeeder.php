<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        DB::table('account')->insert([
        	'account_id'=>'account04',
        	'username'=>'admin',
        	'password'=>'admin',
        	'date'=>'20191212',
        	'money'=>'0',
        	'type_id'=>'type01'
        ]);
    }
}
