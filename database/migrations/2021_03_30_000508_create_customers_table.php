<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(false);
            $table->text('address')->nullable();
            $table->boolean('checked')->nullable(false);
            $table->text('description');
            $table->string('interest')->nullable();
            $table->dateTime('date_of_birth')->nullable();
            $table->string('email')->nullable(false);
            $table->string('account')->nullable(false);
            $table->json('credit_card')->nullable(true);
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
        Schema::dropIfExists('customers');
    }
}
