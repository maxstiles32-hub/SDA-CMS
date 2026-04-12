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
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('Super Admin', 'Pastor', 'Clerk', 'Treasurer', 'Head Elder', 'Department Leader', 'Funds Controller') DEFAULT 'Clerk'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('Super Admin', 'Pastor', 'Clerk', 'Treasurer', 'Head Elder', 'Department Leader') DEFAULT 'Clerk'");
    }
};
