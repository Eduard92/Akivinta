<?php namespace Devapps\RealState\Models;

use Model;

/**
 * Model
 */
class Ciudad extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'devapps_realstate_ciudades';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

            
    public $belongsTo = [
        'pais' => ['Devapps\RealState\Models\Pais','key'=>'id_pais']
        ];
    
    
}
