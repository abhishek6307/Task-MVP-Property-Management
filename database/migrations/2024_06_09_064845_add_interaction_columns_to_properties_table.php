<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInteractionColumnsToPropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::table('properties', function (Blueprint $table) {
        $table->unsignedInteger('views')->default(0);
        $table->unsignedInteger('likes')->default(0);
        $table->unsignedInteger('shares')->default(0);
    });
}

public function down()
{
    Schema::table('properties', function (Blueprint $table) {
        $table->dropColumn(['views', 'likes', 'shares']);
    });
}

}
