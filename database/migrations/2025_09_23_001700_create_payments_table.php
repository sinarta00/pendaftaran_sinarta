<?php
// database/migrations/xxxx_create_payments_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Participant::class)
      ->constrained()
      ->cascadeOnDelete();

            $table->string('invoice_number')->nullable();
            $table->enum('payment_type', ['dp', 'full']);
            $table->decimal('amount', 10, 2);
            $table->decimal('remaining_amount', 10, 2)->default(0);
            $table->date('payment_date')->nullable();
            $table->enum('status', ['pending', 'confirmed'])->default('pending');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
};