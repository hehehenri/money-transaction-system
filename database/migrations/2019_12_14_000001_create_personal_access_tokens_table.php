<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('personal_access_tokens', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('tokenable_id');
            $table->string('tokenable_type');
            $table->string('token')->unique();
            $table->timestamp('expires_at');

            $table->timestamps();
        });
    }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down(): void
        {
            Schema::dropIfExists('personal_access_tokens');
        }
};
