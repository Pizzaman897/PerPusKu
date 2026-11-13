<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::table('users')->join('murids', 'users.email', '=', 'murids.email')->exists()) {
            throw new RuntimeException('A user and a legacy account share an email address. Resolve the duplicate before migrating.');
        }

        Schema::create('user_migration_map', function (Blueprint $table) {
            $table->unsignedBigInteger('source_id')->primary();
            $table->unsignedBigInteger('user_id')->unique();
        });

        Schema::table('peminjaman', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
        });

        foreach (DB::table('murids')->orderBy('id')->cursor() as $legacyAccount) {
            $userId = DB::table('users')->insertGetId([
                'name' => $legacyAccount->name,
                'email' => $legacyAccount->email,
                'email_verified_at' => null,
                'password' => $legacyAccount->password,
                'remember_token' => $legacyAccount->remember_token,
                'created_at' => $legacyAccount->created_at,
                'updated_at' => $legacyAccount->updated_at,
            ]);

            DB::table('user_migration_map')->insert([
                'source_id' => $legacyAccount->id,
                'user_id' => $userId,
            ]);

            DB::table('peminjaman')
                ->where('murid_id', $legacyAccount->id)
                ->update(['user_id' => $userId]);
        }

        Schema::table('peminjaman', function (Blueprint $table) {
            $table->dropForeign(['murid_id']);
            $table->dropColumn('murid_id');
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
            $table->foreign('user_id')->references('id')->on('users')->restrictOnDelete();
        });

        Schema::drop('murids');
    }

    public function down(): void
    {
        $unmappedBorrowingsExist = DB::table('peminjaman')
            ->whereNotIn('user_id', DB::table('user_migration_map')->select('user_id'))
            ->exists();

        if ($unmappedBorrowingsExist) {
            throw new RuntimeException('Cannot roll back while borrowings belong to users created after the account migration.');
        }

        Schema::create('murids', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        foreach (DB::table('user_migration_map')->orderBy('source_id')->cursor() as $mapping) {
            $user = DB::table('users')->where('id', $mapping->user_id)->first();

            if ($user !== null) {
                DB::table('murids')->insert([
                    'id' => $mapping->source_id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'password' => $user->password,
                    'remember_token' => $user->remember_token,
                    'created_at' => $user->created_at,
                    'updated_at' => $user->updated_at,
                ]);
            }

            DB::table('peminjaman')
                ->where('user_id', $mapping->user_id)
                ->update(['user_id' => $mapping->source_id]);
        }

        Schema::table('peminjaman', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->renameColumn('user_id', 'murid_id');
            $table->foreign('murid_id')->references('id')->on('murids')->restrictOnDelete();
        });

        DB::table('users')->whereIn('id', DB::table('user_migration_map')->select('user_id'))->delete();
        Schema::drop('user_migration_map');
    }
};
