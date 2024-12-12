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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Compulsory
            $table->string('email'); // Compulsory
            $table->string('phone')->nullable(); // Optional
            $table->string('nic')->nullable(); // Optional
            $table->string('company_name')->nullable(); // Optional
            $table->string('designation')->nullable(); // Optional
            $table->string('slimID')->nullable(); // Optional
            $table->text('other')->nullable(); // Optional
            $table->timestamps(); // Created at and updated at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
