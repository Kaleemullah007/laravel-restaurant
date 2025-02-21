<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phone', 50);
            $table->string('user_type', 15)->default('customer');
            $table->boolean('is_factory_user')->default(0)->comment('0 for vendor and 1 for factory user');
            $table->unsignedBigInteger('owner_id')->nullable();
            $table->text('picture')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->string('business_email', 255)->nullable();
            $table->string('business_name', 40)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('postal_code', 10)->nullable();
            $table->string('business_phone', 20)->nullable();
            $table->string('country', 20)->nullable();
            $table->string('invoice_template')->default('view-sale');
            $table->integer('per_page')->default(10);
            $table->text('logo')->nullable();
            $table->string('currency', 10)->default('Rs.');
            $table->string('custom_note', 255)->default('A finance charge of 1.5% will be made on unpaid balances after 30 days.');
            $table->string('custom_note_heading', 40)->default('NOTICE:');
            $table->rememberToken();
            $table->string('tenant_id')->nullable();
            $table->timestamp('activated_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
