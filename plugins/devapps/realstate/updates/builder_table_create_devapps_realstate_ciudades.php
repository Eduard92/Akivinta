<?php namespace Devapps\RealState\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateDevappsRealstateCiudades extends Migration
{
    public function up()
    {
        Schema::create('devapps_realstate_ciudades', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->string('ciudad');
            $table->integer('id_pais');
            $table->integer('codigo_postal')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('devapps_realstate_ciudades');
    }
}
