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
        Schema::table('deposit_histories', function (Blueprint $table) {
            // $table->dropForeign(['tenant_id']);
            $table->dropColumn('tenant_id');
            $table->unsignedBigInteger('owner_id');
            $table->foreign('owner_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('deposit_histories', function (Blueprint $table) {

            $table->dropForeign(['owner_id']);
            // $table->dropForeign('deposit_histories_owner_id_foreign'); // Adjust the key name as needed
            $table->dropColumn('owner_id');

            $table->unsignedBigInteger('tenant_id');
        });
    }
};
