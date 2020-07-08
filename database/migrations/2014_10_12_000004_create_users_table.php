<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->unique()->nullable();
            $table->string('phone')->nullable();
            $table->string('designation')->nullable();
            $table->string('identification_number')->nullable();
            $table->string('member_number')->nullable();
            $table->string('personal_number')->unique()->nullable();
            $table->string('payroll_number')->nullable();
            $table->string('kra_pin')->unique()->nullable();
            $table->string('ministry')->nullable();
            $table->string('county')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->enum('active', [1,0])->nullable();
            $table->string('password');

            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
