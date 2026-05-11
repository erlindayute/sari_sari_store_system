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
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('store_name');
            $table->string('code')->unique();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('currency', 10)->default('Euro');
            $table->string('timezone')->default('Europe/Rome');
            $table->integer('low_stock_threshold')->default(10);
            $table->enum('plan', ['free', 'pro', 'business'])->default('pro');
            $table->timestamp('trial_ends_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};
