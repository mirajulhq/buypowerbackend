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
        Schema::create('set_suburbs', function (Blueprint $table) {
            $table->id();
            $table->string('suburb')->nullable();
            $table->bigInteger('state_id')->unsigned()->nullable();
            $table->foreign('state_id')->references('id')->on('set_states');
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
        Schema::dropIfExists('set_suburbs');
    }
};