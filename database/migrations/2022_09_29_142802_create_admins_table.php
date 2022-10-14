<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('profile_photo_path', 2048)->nullable();
            $table->string('email');
            $table->dateTime('email_verified_at')->nullable();
            $table->longText('phone')->nullable();
            $table->dateTime('phone_verified_at')->nullable();

            $table->string('country_code')->nullable();
            $table->string('country_calling_code')->nullable();

            $table->longText('first_name')->nullable();
            $table->longText('last_name')->nullable();
            $table->longText('middle_name')->nullable();
            $table->longText('full_name')->nullable();

            $table->longText('last_login_agent')->nullable();
            $table->dateTime('last_login_at', 6)->nullable();
            $table->longText('last_login_ip')->nullable();

            $table->longText('password')->nullable();

            $table->string('name');

            $table->dateTime('created_at', 6);
            $table->dateTime('updated_at', 6);

            $table->index('email');
            $table->unique('email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_users');
    }
}
