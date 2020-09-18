<?php

use Illuminate\Database\Migrations\Migration;

class PopulateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('users')->insert([
            'email' => 'admin@admin.com',
            'name' => 'admin',
            'password' => Hash::make(12345678),
            'right' => 1,
        ]);

        DB::table('users')->insert([
            'email' => 'user@gmail.com',
            'name' => 'user',
            'password' => Hash::make(12345678),
            'right' => 0,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
