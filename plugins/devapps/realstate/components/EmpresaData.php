<?php namespace Devapps\RealState\Components;

use Cms\Classes\ComponentBase;
use Devapps\RealState\Models\Empresa;

use Input;

use Session;
use Redirect;
use Flash;

    use Backend\Models\BrandSetting;
use System\Classes\MediaLibrary;


class EmpresaData extends ComponentBase
{
        public function componentDetails()
    {
        return [
            'name'        => 'Empresa',
            'description' => 'Muestra datos de la empresa.'
        ];
    }
    
    

public function onRun()
{
    


$brand = BrandSetting::instance();

                $this->page['brand'] = $brand;

    

}

    

    
    
}