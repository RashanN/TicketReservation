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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('member_id')->constrained('members')->onDelete('cascade'); // Foreign key
            $table->integer('Numberof_ticket'); // Number of tickets
            $table->string('AgentID'); // Agent ID
            $table->decimal('TotalPrice', 10, 2); // Total Price
            $table->decimal('DiscountPrice', 10, 2)->nullable(); // Discount Price
            $table->date('Date'); // Date of ticket
            $table->boolean('PaymentStatus')->default(false); // Payment status
            $table->boolean('IssuedStatus')->default(false); // Issued status
            $table->decimal('IncentivePrice', 10, 2)->nullable(); // Incentive price
            $table->string('PaymentType')->nullable(); // Payment type
            $table->text('other')->nullable(); // Optional additional information
            $table->timestamps(); // Created at and updated at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
