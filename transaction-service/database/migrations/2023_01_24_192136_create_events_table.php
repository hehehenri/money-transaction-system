<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('type');
            $table->longText('payload');
            $table->timestamps('processed_at');
            $table->timestamps('created_at');
        });
    }

     public function down(): void
     {
         Schema::dropIfExists('events');
     }
};
