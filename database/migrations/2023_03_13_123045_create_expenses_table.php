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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->float('amount', 10, 2);
            $table->unsignedBigInteger('owner_id');
            $table->date('date');
            $table->foreign('owner_id')->references('id')->on('users')->comments('user is Acutally Vendor id');
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
        Schema::dropIfExists('expenses');
    }
};
