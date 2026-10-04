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
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->string('quote_ref')->unique();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('type')->default('home'); // home, auto, life, business
            $table->string('type_label')->default('Homeowners');
            $table->string('coverage')->default('$500,000 Standard');
            $table->string('premium')->nullable();
            $table->string('location')->nullable();
            $table->string('zip_code', 20)->nullable();
            $table->string('status')->default('new'); // new, reviewing, quoted, converted, declined
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotes');
    }
};
