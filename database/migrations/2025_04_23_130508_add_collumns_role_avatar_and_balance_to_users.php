<?php

use App\Enums\RoleUserEnum;
use App\Models\User;
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
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('user')->after('password');
            $table->integer('balance')->default(0)->after('role');
            $table->string('avatar')->nullable()->after('balance');
        });

        // create default user roles
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin123'),
            'role' => RoleUserEnum::ADMIN->value,
            'email_verified_at' => now(),
        ]);
    }
};
