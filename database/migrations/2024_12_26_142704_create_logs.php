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
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned()->nullable();  // Store the user ID related to the action
            $table->text('action');  // Store the action that occurred (e.g., "Logged in", "Purchased item", etc.)
            $table->text('level');
            $table->text('message');
            $table->text('context');
            $table->timestamp('timestamp')->useCurrent();  // The time when the log was created
            $table->timestamps();

            // Foreign key relationship to the users table
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
