<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/*
 * Supabase exposes every table in the "public" schema through its REST API using
 * the public anon key. Laravel connects with the database role (which bypasses
 * RLS), so we turn RLS ON with NO policies: the REST API then sees nothing, and
 * the admins' password hashes and volunteers' phone numbers stay private.
 *
 * Re-run this statement manually if you ever add a table outside Laravel.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() !== 'pgsql') {
            return;
        }

        DB::unprepared(<<<'SQL'
        DO $$
        DECLARE r record;
        BEGIN
            FOR r IN SELECT tablename FROM pg_tables WHERE schemaname = 'public' LOOP
                EXECUTE format('ALTER TABLE public.%I ENABLE ROW LEVEL SECURITY', r.tablename);
            END LOOP;
        END $$;
        SQL);
    }

    public function down(): void
    {
        // Intentionally left empty: never switch RLS off automatically.
    }
};
