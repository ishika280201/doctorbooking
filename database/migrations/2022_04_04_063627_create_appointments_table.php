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
        Schema::create('appointments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('customer_order_id');
            $table->integer('user_id');
            $table->string('name');
            $table->string('phone_number');
            $table->integer('doctor_id');
            $table->string('appointment_date');
            $table->decimal('discount',10,2)->default(0);
            $table->decimal('grand_total',10,2)->default(0);
            $table->integer('payement_method_id')->default('1');
            $table->string('payement_mode')->default('COD');
            $table->string('order_date');
            $table->enum('status',['pending','accept','canceled','temporary'])->default('pending');
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
        Schema::dropIfExists('appointments');
    }
};
