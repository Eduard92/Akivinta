<?php namespace Devapps\RealState;

use System\Classes\PluginBase;
use Illuminate\Support\Facades\Route;


class Plugin extends PluginBase
{
    public function registerComponents()
    {
               return [
            'Devapps\RealState\Components\Propiedades' => 'propiedades',
            'Devapps\RealState\Components\EmpresaData' => 'EmpresaData'
                    ];
    }

    public function registerSettings()
    {

    }

    public function boot()
    {
        // Register simple API routes for external consumption / SPA
        Route::group(['prefix' => 'api/realstate'], function() {
            Route::get('properties', 'Devapps\\RealState\\Controllers\\Api@properties');
            Route::get('properties/{slug}', 'Devapps\\RealState\\Controllers\\Api@property');
            Route::get('cities', 'Devapps\\RealState\\Controllers\\Api@cities');
            Route::get('categories', 'Devapps\\RealState\\Controllers\\Api@categories');
        });
    }

}
