<?php namespace Devapps\RealState\Models;

use Model;

/**
 * Model
 */
class Pais extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'devapps_realstate_paises';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    
    public $belongsTo = [
        'ciudad' => ['Devapps\RealState\Models\Ciudad','key'=>'ciudad_id']
        ];
    
        
}
