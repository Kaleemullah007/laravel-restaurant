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
        Schema::create('purchase_histories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->integer('qty');
            $table->decimal('price', 10, 2);
            $table->decimal('sale_price', 10, 2);
            $table->decimal('total', 10, 2)->default(0);
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('owner_id');
            $table->foreign('user_id')->references('id')->on('users')->comments('From which vendor he bought product');
            $table->foreign('owner_id')->references('id')->on('users')->comments('user is Acutally Vendor id');
            $table->softDeletes();
            $table->string('tenant_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_histories');
    }
};
