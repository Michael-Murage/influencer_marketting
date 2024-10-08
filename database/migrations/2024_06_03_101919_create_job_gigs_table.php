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
    Schema::create('job_gigs', function (Blueprint $table) {
      $table->id();
      $table->timestamps();
			$table->string('name');
			$table->text('description');
			$table->jsonb('tags')->nullable();
			$table->foreignId('user_id');
			$table->bigInteger('worker_id')->nullable();
      $table->jsonb('applicants')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('job_gigs');
  }
};
