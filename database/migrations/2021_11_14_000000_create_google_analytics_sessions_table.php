<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoogleAnalyticsSessionsTable extends Migration
{
    public function up(): void
    {
        Schema::create('google_analytics_sessions', function (Blueprint $table) {
            $table->id();
            $table->dateTime('started_at');
            $table->string('day', 8);
            $table->string('domain');
            $table->string('traffic_channel');
            $table->integer('total_hits');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('google_analytics_sessions');
    }
}
