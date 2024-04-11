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
        Schema::create(
            'user_roles', function (Blueprint $table) {
                $table->uuid('user_id');
                $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
                $table->enum('role', ['admin', 'user', 'service'])->default('user');
                $table->timestamps();

                $table->unique(["user_id", "role"]);
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_roles');
    }
};
