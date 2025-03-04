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
        Schema::table('deal_products', function (Blueprint $table) {
            $table->unsignedBigInteger('deal_product_id');
            $table->foreign('deal_product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('deal_products', function (Blueprint $table) {
            $table->dropForeign(['deal_product_id']);
            $table->dropColumn('deal_product_id');
        });
    }
};
