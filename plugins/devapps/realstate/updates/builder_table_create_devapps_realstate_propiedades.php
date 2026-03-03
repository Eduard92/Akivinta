<?php namespace Devapps\RealState\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateDevappsRealstatePropiedades extends Migration
{
    public function up()
    {
        Schema::create('devapps_realstate_propiedades', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('id_ciudad');
            $table->integer('id_categoria');
            $table->string('nombre');
            $table->text('pagina')->nullable();
            $table->text('direccion')->nullable();
            $table->decimal('m2_terreno', 10, 2);
            $table->string('estado');
            $table->decimal('precio', 10, 0)->nullable();
            $table->boolean('activo');
            $table->text('caracteristicas')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->integer('cuota_mant');
            $table->string('vialidad');
            $table->integer('habitaciones');
            $table->integer('banos');
            $table->integer('medio_banos');
            $table->integer('cajones_estacionamiento');
            $table->integer('plantas');
            $table->smallInteger('m2_construccion');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('devapps_realstate_propiedades');
    }
}
