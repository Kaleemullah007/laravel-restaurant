<?php

use App\Models\Deal;
use App\Models\Product;
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
            $table->dropConstrainedForeignId('deal_id');
            $table->foreignIdFor(Product::class)->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('deal_products', function (Blueprint $table) {
            $table->dropConstrainedForeignId('product_id');
            $table->foreignIdFor(Deal::class)->constrained();
        });
    }
};
