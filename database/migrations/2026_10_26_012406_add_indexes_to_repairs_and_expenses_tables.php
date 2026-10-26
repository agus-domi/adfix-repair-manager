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
        Schema::table('repairs', function (Blueprint $table) {
            $table->index('received_at');
            $table->index('status');
            $table->index('client_id');
            $table->index('delivered_at');
        });

        Schema::table('expenses', function (Blueprint $table) {
            $table->index('created_at');
            $table->index('repair_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('repairs', function (Blueprint $table) {
            $table->dropIndex(['received_at']);
            $table->dropIndex(['status']);
            $table->dropIndex(['client_id']);
            $table->dropIndex(['delivered_at']);
        });

        Schema::table('expenses', function (Blueprint $table) {
            $table->dropIndex(['created_at']);
            $table->dropIndex(['repair_id']);
        });
    }
};
