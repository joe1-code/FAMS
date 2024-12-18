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
        DB::statement('

            CREATE VIEW arrears_general AS 
            SELECT
                u.id AS userID,
                CONCAT(
                    COALESCE(u.firstname, \'\'), \' \',
                    COALESCE(u.middlename, \'\'), \' \',
                    COALESCE(u.lastname, \'\')
                ) AS fullnames,
                MAX(um.created_at) AS latest_arrears_date,
                SUM(um.total_arrears) AS total_arrears,
                SUM(COALESCE(ap.paid_amount, 0)) AS total_paid,
                (SUM(um.total_arrears) - SUM(COALESCE(ap.paid_amount, 0))) AS member_arrears
            FROM users u
            LEFT JOIN unpaid_members um ON u.id = um.user_id
            LEFT JOIN arrears_payments ap ON ap.unpaid_member_id = um.id
            WHERE um.pay_status = false
            AND um.created_at < DATE_TRUNC(\'month\', CURRENT_DATE)
            GROUP BY u.id, u.firstname, u.middlename, u.lastname
            ORDER BY latest_arrears_date DESC;

                ');
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('arrears_general');
        DB::statement('DROP VIEW IF EXISTS arrears_general');
    }
};
