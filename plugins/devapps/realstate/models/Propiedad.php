<?php namespace Devapps\RealState\Models;

use Model;

/**
 * Model
 */
class Propiedad extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];
    protected $jsonable = ['caracteristicas'];



    /**
     * @var string The database table used by the model.
     */
    public $table = 'devapps_realstate_propiedades';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $belongsTo = [
        'ciudad' => ['Devapps\RealState\Models\Ciudad','key'=>'id_ciudad'],
        'categoria' => ['Devapps\RealState\Models\Categoria','key'=>'id_categoria']

        ];

    public $attachOne = [
            'portada' => 'System\Models\File'
        ];
    
    public $attachMany = [
            'galeria' => 'System\Models\File'
        ];

}
