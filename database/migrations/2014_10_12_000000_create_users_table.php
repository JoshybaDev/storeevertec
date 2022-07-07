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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name',100);
            $table->string('surname',100);
            $table->string('email',250)->unique();
            $table->string('mobile',15);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password',150);
            $table->rememberToken();
            $table->enum('level',['ADMIN','CUSTOMER'])->default('CUSTOMER');
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
        Schema::dropIfExists('users');
    }
};
