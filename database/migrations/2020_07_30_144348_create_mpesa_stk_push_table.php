<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMpesaStkPushTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mpesa_stk_push', function (Blueprint $table) {
            $table->id();
            $table->string('business_short_code')->nullable();
            $table->string('password')->nullable();
            $table->string('timestamp')->nullable();
            $table->string('transaction_type')->nullable();
            $table->string('amount')->nullable();
            $table->string('party_a')->nullable();
            $table->string('party_b')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('callback_url')->nullable();
            $table->string('account_reference')->nullable();
            $table->string('transaction_desc')->nullable();
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
        Schema::dropIfExists('mpesa_stk_push');
    }
}
