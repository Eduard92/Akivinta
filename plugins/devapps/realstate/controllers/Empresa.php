<?php namespace Devapps\RealState\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Empresa extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public $requiredPermissions = [
        'admin_company' 
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Devapps.RealState', 'main-menu-company');
    }
}
