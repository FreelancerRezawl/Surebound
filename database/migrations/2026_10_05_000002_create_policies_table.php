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
        Schema::create('policies', function (Blueprint $table) {
            $table->id();
            $table->string('policy_number')->unique();
            $table->string('holder_name');
            $table->string('type')->default('home');
            $table->string('type_label')->default('Homeowners Deluxe');
            $table->string('coverage_limit')->default('$500,000');
            $table->string('annual_premium')->default('$1,500 / yr');
            $table->date('effective_date')->nullable();
            $table->date('renewal_date')->nullable();
            $table->string('status')->default('active'); // active, pending, expired
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('policies');
    }
};
