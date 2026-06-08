<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('author');
            $table->string('isbn')->unique();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('publisher')->nullable();
            $table->integer('page_count')->nullable();
            $table->integer('quantity')->default(1);
            $table->integer('available')->default(1);
            $table->string('cover_image')->nullable();
            $table->text('description')->nullable();
            $table->string('shelf_no')->nullable();
            $table->string('qr_code')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
