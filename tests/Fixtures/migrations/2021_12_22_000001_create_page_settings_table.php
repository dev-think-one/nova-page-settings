<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePageSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( config('nova-page-settings.default.settings_table'), function ( Blueprint $table ) {
            \Thinkone\NovaPageSettings\MigrationHelper::defaultColumns($table);
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('nova-page-settings.default.settings_table'));
    }
}
