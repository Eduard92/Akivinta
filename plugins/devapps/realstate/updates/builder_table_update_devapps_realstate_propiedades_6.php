<?php namespace Devapps\RealState\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDevappsRealstatePropiedades6 extends Migration
{
    public function up()
    {
        Schema::table('devapps_realstate_propiedades', function($table)
        {
            $table->integer('antiguedad');
            $table->decimal('m2_terreno', 10, 2)->default(0)->change();
        });
    }
    
    public function down()
    {
        Schema::table('devapps_realstate_propiedades', function($table)
        {
            $table->dropColumn('antiguedad');
            $table->decimal('m2_terreno', 10, 2)->default(NULL)->change();
        });
    }
}
