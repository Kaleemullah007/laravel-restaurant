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
        Schema::create('purchase_returns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->string('product_name');
            $table->unsignedBigInteger('sale_id')->nullable();
            $table->decimal('quantity', 10, 2);
            $table->decimal('total_price', 10, 2);
            $table->decimal('unit_price', 10, 2);
            $table->unsignedBigInteger('owner_id');
            $table->integer('purchase_history_id')->default(0);
            $table->boolean('is_process')->default(false)->comment('If true then inventory is updated');
            // $table->foreign('purchase_history_id')->references('id')->on('purchase_histories');
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('sale_id')->references('id')->on('sales');
            $table->foreign('owner_id')->references('id')->on('users')->comments('user is Acutally Vendor id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_returns');
    }
};
