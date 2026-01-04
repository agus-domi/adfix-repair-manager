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
        Schema::create('repairs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();

            $table->string('device');
            $table->text('issue');

            $table->decimal('estimated_price', 10, 2)->nullable();
            $table->decimal('charged_amount', 10, 2)->nullable();

            $table->enum('status', ['pendiente', 'en_proceso', 'completado'])
                ->default('pendiente');

            $table->date('received_at');
            $table->date('delivered_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repairs');
    }
};
