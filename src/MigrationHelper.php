<?php


namespace Thinkone\NovaPageSettings;

use Illuminate\Database\Schema\Blueprint;

class MigrationHelper
{
    public static function defaultColumns(Blueprint $table)
    {
        $table->id();
        $table->string('type', 50)->default('default')->index();
        $table->string('page', 255)->index();
        $table->string('key', 100)->index();
        $table->text('value')->nullable();
        $table->timestamps();

        $table->index([ 'page', 'key', 'type' ]);
    }
}
