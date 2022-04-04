<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('country_code')->nullable()->after('name');
            $table->string('phone_number')->nullable()->unique()->after('country_code');
            $table->enum('status',['active','inactive','pending','blocked'])->default('pending');
            $table->enum('gender',['Male','Female','Other'])->nullable()->after('email');
            $table->string('dob')->after('gender');
            $table->string('profile_image')->nullable()->after('id');
            $table->string('user_type');
            $table->tinyInteger('role_as')->default('0');
            //$table->string('speciality')->after('dob');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
