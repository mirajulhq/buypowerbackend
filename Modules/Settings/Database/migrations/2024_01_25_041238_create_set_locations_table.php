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
        Schema::create('set_locations', function (Blueprint $table) {
            $table->id();
            $table->string('location')->nullable();
            $table->text('address')->nullable();
            $table->boolean('is_active')->default(true);
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
        Schema::dropIfExists('set_locations');
    }
};
