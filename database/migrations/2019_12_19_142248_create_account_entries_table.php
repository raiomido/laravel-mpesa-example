<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id');
            $table->enum('type', array('DEBIT', 'CREDIT'));
            $table->string('balance_before')->nullable();
            $table->decimal('balance_after', 15, 2)->nullable();
            $table->decimal('amount', 15, 2)->nullable();
            $table->morphs('entryable');
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
        Schema::dropIfExists('account_entries');
    }
}
