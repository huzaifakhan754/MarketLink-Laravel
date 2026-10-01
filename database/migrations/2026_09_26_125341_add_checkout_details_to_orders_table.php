<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {

            $table->string('customer_name')->nullable()->after('user_id');

            $table->string('customer_phone')->nullable()->after('customer_name');

            $table->string('customer_email')->nullable()->after('customer_phone');

            $table->foreignId('market_id')
                ->nullable()
                ->after('farmer_id')
                ->constrained('markets')
                ->nullOnDelete();

            $table->date('pickup_date')
                ->nullable()
                ->after('market_id');

            $table->string('time_slot')
                ->nullable()
                ->after('pickup_date');

            $table->string('pickup_name')
                ->nullable()
                ->after('time_slot');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {

            $table->dropForeign(['market_id']);

            $table->dropColumn([
                'customer_name',
                'customer_phone',
                'customer_email',
                'market_id',
                'pickup_date',
                'time_slot',
                'pickup_name',
            ]);
        });
    }
};