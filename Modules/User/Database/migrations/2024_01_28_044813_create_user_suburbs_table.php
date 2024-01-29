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
        Schema::create('user_suburbs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_profile_id')->unsigned()->nullable();
            $table->foreign('user_profile_id')->references('id')->on('user_profiles');
            $table->bigInteger('suburb_id')->unsigned()->nullable();
            $table->foreign('suburb_id')->references('id')->on('set_suburbs');
            $table->boolean('is_active')->default(true);
            $table->bigInteger('location_id')->unsigned()->nullable();
            $table->foreign('location_id')->references('id')->on('set_locations');
            $table->bigInteger('create_user_id')->unsigned()->nullable();
            $table->foreign('create_user_id')->references('id')->on('users');
            $table->bigInteger('edit_user_id')->unsigned()->nullable();
            $table->foreign('edit_user_id')->references('id')->on('users');
            $table->softDeletes($column = 'deleted_at', $precision = 0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_suburbs');
    }
};
