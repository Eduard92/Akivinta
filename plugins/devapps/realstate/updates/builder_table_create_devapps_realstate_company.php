<?php namespace Devapps\RealState\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateDevappsRealstateCompany extends Migration
{
    public function up()
    {
        Schema::create('devapps_realstate_company', function($table)
        {
            $table->engine = 'InnoDB';
            $table->string('nombre');
            $table->text('direccion');
            $table->string('telefono')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string(' contacto')->nullable();
            $table->string('facebook')->nullable();
            $table->string(' instagram')->nullable();
            $table->string('maps')->nullable();
            $table->text('slogan')->nullable();
            $table->text('mision')->nullable();
            $table->text('vision');
            $table->text('footer');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('devapps_realstate_company');
    }
}
