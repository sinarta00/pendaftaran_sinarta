<?php
// database/migrations/xxxx_create_pop_payments_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pop_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pop_participant_id')->constrained('pop_participants')->onDelete('cascade');
            $table->string('invoice_number')->nullable();
            $table->enum('payment_type', ['dp', 'full']);
            $table->decimal('amount', 12, 2);
            $table->decimal('remaining_amount', 12, 2)->default(0);
            $table->date('payment_date')->nullable();
            $table->enum('status', ['pending', 'confirmed'])->default('pending');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pop_payments');
    }
};