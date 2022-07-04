<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('taxes', 18, 2)->default(0.00);
            $table->decimal('shipping', 18, 2)->default(0.00);
            $table->decimal('shipping_discount', 18, 2)->default(0.00);
            $table->dateTime('vigency')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('taxes', 'shipping', 'shipping_discount', 'vigency');
        });
    }
};
