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
        Schema::dropIfExists('platform_lists');
        Schema::dropIfExists('user_lists');

        Schema::create('short_lists', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title');
            $table->foreignId('user_id')->nullable()->onDelete('cascade');
            $table->integer('list_type');
        });

        Schema::create('list_items', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('short_list_id')->onDelete('cascade');
            $table->foreignId('user_id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('short_lists');
        Schema::dropIfExists('list_items');

        Schema::create('user_lists', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title');
            $table->jsonb('content')->nullable();
            $table->foreignId('user_id');
        });

        Schema::create('platform_lists', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title');
            $table->jsonb('content')->nullable();
        });
    }
};
