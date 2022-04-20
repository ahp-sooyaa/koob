<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('program_name');
            $table->string('type'); // fixed price or percentage discount
            $table->string('value'); // if coupon value is 10 & type is percentage discount, it will be 10% otherwise it may be 10ks
            //$table->string('valid_duration'); // 30days or how long
            $table->string('quantity')->nullable();
            $table->date('expired_at');
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
        Schema::dropIfExists('coupons');
    }
}
