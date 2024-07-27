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
        Schema::create('appartments', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('price');
            $table->unsignedInteger('entrance_number');
            $table->unsignedInteger('floor_number');
            $table->unsignedInteger('appartment_number')->unique();
            $table->unsignedInteger('rooms_number');
            $table->unsignedInteger('total_area');
            $table->unsignedInteger('kitchen_area');
            $table->string('repair_type');
            $table->unsignedBigInteger('type_id');
            $table->foreign('type_id')
                ->references('id')->on('appartment_types')
                ->onDelete('cascade');
            $table->unsignedBigInteger('entity_id');
            $table->foreign('entity_id')
                ->references('id')->on('entities')
                ->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appartments');
    }
};
