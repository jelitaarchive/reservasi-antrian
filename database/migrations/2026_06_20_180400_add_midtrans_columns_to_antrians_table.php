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
        Schema::table('antrians', function (Blueprint $table) {

            if (!Schema::hasColumn('antrians', 'order_id')) {
                $table->string('order_id')->nullable();
            }

            if (!Schema::hasColumn('antrians', 'snap_token')) {
                $table->string('snap_token')->nullable();
            }

            if (!Schema::hasColumn('antrians', 'transaction_status')) {
                $table->string('transaction_status')
                    ->default('pending');
            }

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('antrians', function (Blueprint $table) {
            // Drop column jika rollback dilakukan (opsional tapi bagus untuk kerapian)
            if (Schema::hasColumn('antrians', 'order_id')) {
                $table->dropColumn('order_id');
            }
            if (Schema::hasColumn('antrians', 'snap_token')) {
                $table->dropColumn('snap_token');
            }
            if (Schema::hasColumn('antrians', 'transaction_status')) {
                $table->dropColumn('transaction_status');
            }
        });
    }
};