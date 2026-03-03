<?php namespace Devapps\RealState\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDevappsRealstatePropiedades5 extends Migration
{
    public function up()
    {
        Schema::table('devapps_realstate_propiedades', function($table)
        {
            $table->decimal('m2_terreno', 10, 2)->nullable()->change();
            $table->decimal('precio', 10, 0)->nullable()->change();
            $table->integer('cuota_mant')->nullable()->change();
            $table->integer('habitaciones')->nullable()->change();
            $table->integer('banos')->nullable()->change();
            $table->integer('medio_banos')->nullable()->change();
            $table->integer('cajones_estacionamiento')->nullable()->change();
            $table->integer('plantas')->nullable()->change();
            $table->smallInteger('m2_construccion')->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('devapps_realstate_propiedades', function($table)
        {
            $table->decimal('m2_terreno', 10, 2)->nullable(false)->change();
            $table->decimal('precio', 10, 0)->nullable(false)->change();
            $table->integer('cuota_mant')->nullable(false)->change();
            $table->integer('habitaciones')->nullable(false)->change();
            $table->integer('banos')->nullable(false)->change();
            $table->integer('medio_banos')->nullable(false)->change();
            $table->integer('cajones_estacionamiento')->nullable(false)->change();
            $table->integer('plantas')->nullable(false)->change();
            $table->smallInteger('m2_construccion')->nullable(false)->change();
        });
    }
}
