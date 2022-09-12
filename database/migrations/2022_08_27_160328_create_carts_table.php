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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->string('name')->nullable();
            $table->string('ref_code')->nullable();
            $table->string('rent_code')->nullable();
            $table->string('ref_file')->nullable();
            $table->string('rent_time')->nullable();
            $table->string('return_time')->nullable();
            $table->enum('status', ['WAITING', 'WAITING ACCEPTMENT', 'READY TO PICKUP', 'RENT', 'RETURN']);
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
        Schema::dropIfExists('carts');
    }
};
