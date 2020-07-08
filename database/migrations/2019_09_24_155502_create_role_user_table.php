<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoleUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_user', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->bigInteger('role_id')->unsigned()->nullable();
			$table->foreign('role_id', 'fk_rol_rol')->references('id')->on('roles')->onDelete('cascade');
			$table->bigInteger('user_id')->unsigned()->nullable();
			$table->foreign('user_id', 'fk_rol_u')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_user');
    }
}
