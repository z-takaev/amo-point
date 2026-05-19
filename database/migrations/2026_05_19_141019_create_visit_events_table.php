<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visit_events', function (Blueprint $table): void {
            $table->id();
            $table->string('ip', 45);
            $table->string('city');
            $table->string('device');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visit_events');
    }
};
