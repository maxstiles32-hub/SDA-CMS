<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Update the 'role' enum to include 'Member'
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('Super Admin', 'Pastor', 'Clerk', 'Treasurer', 'Head Elder', 'Department Leader', 'Funds Controller', 'Member') DEFAULT 'Member'");

        // 2. Add member_id and must_change_password
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('member_id')->nullable()->after('id');
            $table->boolean('must_change_password')->default(false)->after('password');
        });

        // 3. Add foreign key index
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('member_id')->references('member_id')->on('members')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['member_id']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['member_id', 'must_change_password']);
        });

        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('Super Admin', 'Pastor', 'Clerk', 'Treasurer', 'Head Elder', 'Department Leader', 'Funds Controller') DEFAULT 'Clerk'");
    }
};
