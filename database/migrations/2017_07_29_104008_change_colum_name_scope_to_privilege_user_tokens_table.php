<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumNameScopeToPrivilegeUserTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_tokens', function (Blueprint $table) {
            $table->dropColumn('scope');
        });

        Schema::table('user_tokens', function (Blueprint $table) {
            $table->mediumText('privilege')->after('token')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_tokens', function (Blueprint $table) {
            $table->dropColumn('privilege');
        });
        Schema::table('user_tokens', function (Blueprint $table) {
            $table->string('scope')->after('token')->nullable();
        });
    }
}
