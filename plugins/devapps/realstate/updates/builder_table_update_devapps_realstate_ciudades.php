<?php namespace Devapps\RealState\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDevappsRealstateCiudades extends Migration
{
    public function up()
    {
        Schema::table('devapps_realstate_ciudades', function($table)
        {
            $table->dropColumn('codigo_postal');
        });
    }
    
    public function down()
    {
        Schema::table('devapps_realstate_ciudades', function($table)
        {
            $table->integer('codigo_postal')->nullable();
        });
    }
}
