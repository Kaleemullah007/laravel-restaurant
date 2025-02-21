<?php

use App\Models\Deal;
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
        Schema::create('deal_products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->decimal('price', 8, 2);
            $table->decimal('discount_price', 8, 2);
            $table->decimal('quantity', 8, 2);
            $table->boolean('is_swappable')->default(false);
            $table->foreignIdFor(Deal::class)->constrained();
            $table->unsignedBigInteger('owner_id');
            $table->foreign('owner_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deal_products');
    }
};
