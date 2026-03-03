<?php namespace Devapps\RealState\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDevappsRealstateCompany extends Migration
{
    public function up()
    {
        Schema::table('devapps_realstate_company', function($table)
        {
            $table->increments('id')->unsigned();
        });
    }
    
    public function down()
    {
        Schema::table('devapps_realstate_company', function($table)
        {
            $table->dropColumn('id');
        });
    }
}
