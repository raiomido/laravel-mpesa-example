<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permission_role', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->bigInteger('permission_id')->unsigned()->nullable();
			$table->foreign('permission_id', 'fk_perm_role')->references('id')->on('permissions')->onDelete('cascade');
			$table->bigInteger('role_id')->unsigned()->nullable();
			$table->foreign('role_id', 'fk_role_perm')->references('id')->on('roles')->onDelete('cascade');
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
        Schema::dropIfExists('permission_role');
    }
}
