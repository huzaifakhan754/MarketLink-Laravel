<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('markets', function (Blueprint $table) {
            $table->string('location')->after('name');
            $table->string('days')->after('location');
            $table->string('timing')->after('days');
            $table->string('image')->nullable()->after('timing');
        });
    }

    public function down(): void
    {
        Schema::table('markets', function (Blueprint $table) {
            $table->dropColumn([
                'location',
                'days',
                'timing',
                'image',
            ]);
        });
    }
};