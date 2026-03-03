<?php namespace Devapps\RealState\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDevappsRealstateCompany2 extends Migration
{
    public function up()
    {
        Schema::table('devapps_realstate_company', function($table)
        {
            $table->text('youtube')->nullable();
            $table->text('linkedin')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('devapps_realstate_company', function($table)
        {
            $table->dropColumn('youtube');
            $table->dropColumn('linkedin');
        });
    }
}
