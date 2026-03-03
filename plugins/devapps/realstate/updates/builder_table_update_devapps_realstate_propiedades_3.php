<?php namespace Devapps\RealState\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDevappsRealstatePropiedades3 extends Migration
{
    public function up()
    {
        Schema::table('devapps_realstate_propiedades', function($table)
        {
            $table->decimal('precio', 10, 0)->nullable(false)->default(0.00)->change();
            $table->integer('cuota_mant')->nullable(false)->default(0)->change();
            $table->string('vialidad', 191)->default(null)->change();
            $table->integer('habitaciones')->nullable(false)->default(0)->change();
            $table->integer('banos')->nullable(false)->default(0)->change();
            $table->integer('medio_banos')->nullable(false)->default(0)->change();
            $table->integer('cajones_estacionamiento')->nullable(false)->default(0)->change();
            $table->integer('plantas')->nullable(false)->default(0)->change();
            $table->smallInteger('m2_construccion')->nullable(false)->default(0)->change();
        });
    }
    
    public function down()
    {
        Schema::table('devapps_realstate_propiedades', function($table)
        {
            $table->decimal('precio', 10, 0)->nullable()->default(NULL)->change();
            $table->integer('cuota_mant')->nullable()->default(NULL)->change();
            $table->string('vialidad', 191)->default('NULL')->change();
            $table->integer('habitaciones')->nullable()->default(NULL)->change();
            $table->integer('banos')->nullable()->default(NULL)->change();
            $table->integer('medio_banos')->nullable()->default(NULL)->change();
            $table->integer('cajones_estacionamiento')->nullable()->default(NULL)->change();
            $table->integer('plantas')->nullable()->default(NULL)->change();
            $table->smallInteger('m2_construccion')->nullable()->default(NULL)->change();
        });
    }
}
