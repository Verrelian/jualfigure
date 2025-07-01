<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('payment_receipt', function (Blueprint $table) {
            $table->unsignedInteger('qty')->default(1)->after('price_total');
        });
    }

    public function down(): void
    {
        Schema::table('payment_receipt', function (Blueprint $table) {
            $table->dropColumn('qty');
        });
    }
};
