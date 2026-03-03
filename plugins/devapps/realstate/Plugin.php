<?php namespace Devapps\RealState;

use System\Classes\PluginBase;


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
    

}
