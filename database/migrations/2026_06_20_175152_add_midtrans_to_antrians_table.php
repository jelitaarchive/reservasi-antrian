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
        Schema::table('antrians', function ($table) {

            $table->string('order_id')->nullable();
            $table->string('snap_token')->nullable();
            $table->string('transaction_status')
                ->default('pending');

        });
    }

    public function down(): void
    {
        Schema::table('antrians', function ($table) {

            $table->dropColumn([
                'order_id',
                'snap_token',
                'transaction_status'
            ]);

        });
    }
};
