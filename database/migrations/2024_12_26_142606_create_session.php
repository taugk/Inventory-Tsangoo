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
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('ip_address', 45)->nullable();
            $table->timestamp('user_agent')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade'); // Optional user relation
            $table->text('payload'); // Session data
            $table->integer('last_activity'); // Timestamp for session expiry
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
    }
};
