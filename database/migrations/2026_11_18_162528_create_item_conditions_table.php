<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('item_conditions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('borrow_detail_id')->constrained('borrow_details')->onDelete('cascade');
            $table->foreignId('checked_by')->constrained('users')->onDelete('cascade');
            $table->string('condition_before')->nullable();
            $table->string('condition_after')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('item_conditions');
    }
};