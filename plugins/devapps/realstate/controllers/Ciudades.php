<?php namespace Devapps\RealState\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Ciudades extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public $requiredPermissions = [
        'admin_ciudad' 
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Devapps.RealState', 'main-menu-ciudad');
    }
}
