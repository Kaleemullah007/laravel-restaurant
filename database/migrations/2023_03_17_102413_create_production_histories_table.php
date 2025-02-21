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
        Schema::create('production_histories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->integer('qty');
            $table->boolean('is_production')->default(true);
            $table->boolean('is_wastage')->default(false);
            $table->float('wastage_qty', 10, 2);
            $table->unsignedBigInteger('owner_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('purchase_id');
            $table->foreign('owner_id')->references('id')->on('users')->comments('user is Acutally Vendor id');
            $table->foreign('purchase_id')->references('id')->on('purchases')->comments('purchase id is Acutally Vendor id');
            $table->foreign('product_id')->references('id')->on('products')->comments('product id');
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
        Schema::dropIfExists('production_histories');
    }
};
