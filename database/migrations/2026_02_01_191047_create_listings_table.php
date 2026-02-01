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
        Schema::create('listings', function (Blueprint $table) {
            $table->id();

            $table->string('type');
            $table->string('title');
            $table->text('description')->nullable();

            $table->integer('rooms')->default(0)->nullable();
            $table->integer('bathrooms')->default(0)->nullable();
            $table->integer('space')->default(0)->nullable();

            $table->integer('units')->default(1)->nullable();

            $table->string('thumbnail');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listings');
    }
};
