<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSellersTable extends Migration
{
    public function up(): void
    {
        Schema::table('sellers', function (Blueprint $table) {
            $table->string('name')->after('seller_id');
            $table->date('birthdate')->nullable()->after('name');
            $table->string('phone_number')->nullable()->after('birthdate');
            $table->string('address')->nullable()->after('phone_number');
            $table->text('bio')->nullable()->after('address');
            $table->string('avatar')->nullable()->after('bio');
        });
    }

    public function down(): void
    {
        Schema::table('sellers', function (Blueprint $table) {
            $table->dropColumn([
                'name', 'birthdate',
                'phone_number', 'address', 'bio', 'avatar'
            ]);
        });
    }
}