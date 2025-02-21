<?php

use App\Models\OrderStatus;
use App\Models\OrderType;
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
        Schema::table('sales', function (Blueprint $table) {
            $table->foreignIdFor(OrderType::class)->constrained();
            $table->string('order_type_name');
            $table->foreignIdFor(OrderStatus::class)->constrained();
            $table->string('order_status_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            //
        });
    }
};
