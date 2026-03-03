<?php namespace Devapps\RealState\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDevappsRealstatePropiedades extends Migration
{
    public function up()
    {
        Schema::table('devapps_realstate_propiedades', function($table)
        {
            $table->smallInteger('slug');
        });
    }
    
    public function down()
    {
        Schema::table('devapps_realstate_propiedades', function($table)
        {
            $table->dropColumn('slug');
        });
    }
}
