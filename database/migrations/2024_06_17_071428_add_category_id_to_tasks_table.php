<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            if (DB::getDriverName() === 'sqlite') {
                // set as 'nullable', because SQLite does not accept 'not nullable' fields without default value
                $table->unsignedInteger('category_id')->after('due_date')->nullable();
            }else{
                $table->unsignedInteger('category_id')->after('due_date');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('category_id');
        });
    }
};
