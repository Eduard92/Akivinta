<?php namespace Devapps\RealState\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDevappsRealstatePropiedadesCategorias extends Migration
{
    public function up()
    {
        Schema::table('devapps_realstate_propiedades_categorias', function($table)
        {
            $table->string('slug');
        });
    }
    
    public function down()
    {
        Schema::table('devapps_realstate_propiedades_categorias', function($table)
        {
            $table->dropColumn('slug');
        });
    }
}
