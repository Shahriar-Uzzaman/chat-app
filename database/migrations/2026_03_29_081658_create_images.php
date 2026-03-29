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
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->morphs('imageable');
            $table->string('type')->default('default')->index();
            $table->string('path');
            $table->string('disk')->default('public');
            $table->string('file_name')->nullable();
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('size')->nullable();
            $table->unsignedInteger('order_column')->nullable()->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
