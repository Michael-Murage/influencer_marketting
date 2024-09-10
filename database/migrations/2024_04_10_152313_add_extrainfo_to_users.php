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
        Schema::table('users', function (Blueprint $table) {
            // brand
            $table->string('company_name')->nullable();
            $table->string('role')->nullable();
            $table->string('company_size')->nullable();
            $table->string('industry')->nullable();
            $table->string('website_url')->nullable();

            // influencer / creator
            $table->string('profession')->nullable();
            $table->string('interest')->nullable();
            $table->string('active_socials')->nullable();
            
            $table->string('profile_pic')->nullable();
            $table->string('pic_1')->nullable();
            $table->string('pic_2')->nullable();
            $table->string('pic_3')->nullable();
            $table->boolean('profile_complete')->default(false);
            $table->boolean('info_gathering_prompted')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
