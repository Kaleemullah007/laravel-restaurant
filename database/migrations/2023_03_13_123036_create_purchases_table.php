<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->unsignedBigInteger('user_id');
            // $table->unsignedBigInteger('product_id');
            $table->integer('qty');
            $table->float('price', 10, 2);
            $table->float('sale_price', 10, 2);
            $table->float('total', 10, 2);
            $table->foreign('user_id')->references('id')->on('users')->comments('user is Acutally Vendor id');
            $table->unsignedBigInteger('owner_id');
            $table->foreign('owner_id')->references('id')->on('users')->comments('user is Acutally Vendor id');
            // $table->foreign('product_id')->references('id')->on('products');
            $table->softDeletes();
            $table->string('tenant_id')->nullable();

            $table->index(['owner_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
