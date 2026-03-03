<?php namespace Devapps\RealState\Models;

use Model;

/**
 * Model
 */
class Categoria extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'devapps_realstate_propiedades_categorias';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
    
    
    
       

    public $hasMany = [
    'propiedades' => ['Devapps\RealState\Models\Propiedad','key' => 'id_categoria', 'otherKey' => 'id']
    ];


}
