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
        Schema::table('purchase_histories', function (Blueprint $table) {
            // $table->unsignedBigInteger('purchase_history_id')->nullable();
            // $table->foreign('purchase_history_id')->references('id')->on('purchase_histories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchase_histories', function (Blueprint $table) {
            // $table->dropForeign(['purchase_history_id']); // Drop the foreign key
            // $table->dropColumn('purchase_history_id');   // Drop the column
        });
    }
};
