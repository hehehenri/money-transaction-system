<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Src\Transactions\Domain\Enums\TransactionStatus;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('sender_id')
                ->references('id')
                ->on('transactionables');
            $table->foreignUuid('receiver_id')
                ->references('id')
                ->on('transactionables');
            $table->integer('amount');
            $table->enum('status', array_column(TransactionStatus::cases(), 'value'));

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
