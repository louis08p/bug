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
    Schema::table('factures', function (Blueprint $table) {
        $table->timestamp('date_paiement')->nullable()->after('date_facture');
    });
}

public function down(): void
{
    Schema::table('factures', function (Blueprint $table) {
        $table->dropColumn('date_paiement');
    });
}

};
