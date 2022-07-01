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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id");
            $table->foreign('user_id')->references('id')->on('users');           
            $table->string('codebuy',20)->unique();
            $table->string("customer_name",200);
            $table->string("customer_email",250);
            $table->string('customer_mobile',15);
            $table->enum('status',['CREATED','PAYED,REJECTED'])->default('CREATED');
            $table->decimal('cant',18,2);
            $table->decimal('total',18,2);
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
        Schema::dropIfExists('orders');
    }
};
