<?php namespace Devapps\RealState\Components;

use Cms\Classes\ComponentBase;
use Devapps\RealState\Models\Propiedad;
use Devapps\RealState\Models\Categoria;
use Raviraj\Rjsliders\Models\Slider;

use Input;

use Session;
use Redirect;
use Flash;

class Propiedades extends ComponentBase
{
        public function componentDetails()
    {
        return [
            'name'        => 'Propieades',
            'description' => 'Muestra los registros de Propieades.'
        ];
    }
    
    

public function onRun()
{
    
    
    $slug = $this->param('slug'); 


    if ($slug) {
        
        if ($this->page->id == 'category'){
                $categoria = Categoria::where('slug', $slug)->first();

                $this->page['categoria'] = $categoria;
                
                $this->page['propiedades'] = $categoria
                            ? $categoria->propiedades()->where('activo', true)->get()
                            : collect();
                                
                $this->page['propiedades'] =   $propiedades = Propiedad::where('activo',1)->get();
                $this->page['categorias'] =   $categoria = Categoria::where('activo', 1)->get();
                    
                }
                
        else if ($this->page->id == 'property'){
            
                $this->page['property'] =   $propiedades = Propiedad::where('slug', $slug)->first();
                
                if(!$propiedades)
                    return Redirect::to('/404');
                    
                $this->page['propiedades'] =   $propiedades = Propiedad::where('activo',1)->get();
                $this->page['categorias'] =   $categoria = Categoria::where('activo', 1)->get();

        }
                
                else{
            return Redirect::to('/404');

        }

            
    }
    else if ($this->page->id == 'inicio') {
         
                $this->page['propiedades'] =   $propiedades = Propiedad::where('activo',1)->get();
                $this->page['sliderHome'] =   $sliderHome = Slider::where('name','home')->first();

      
            

    }
    else if ($this->page->id == 'busqueda') {
         
        //$this->page['propiedades'] =   $propiedades = Propiedad::where('activo',1)->get();
        //$this->page['sliderHome'] =   $sliderHome = Slider::where('name','home')->first();
        //$this->page['propiedades'] = $this->loadProperties();
        //$this->page['categorias'] =   $categoria = Categoria::where('activo', 1)->get();
        //$this->page['sliderHome'] = Slider::where('name', 'home')->first();
        $this->page['propiedades'] = $this->loadProperties();
        $this->page['todas_las_categorias'] = Categoria::where('activo', true)->get();
        $this->page['categorias'] = Categoria::where('activo', 1)->get();

    }
    else {
        
            return Redirect::to('/404');
    }
}

    protected function loadActiveRecords()
    {
        return Propiedad::where('activo', true)->get();
    }
    
    
    public function onFilterProperties()
    {

        $this->page['propiedades'] = $this->loadProperties();
       
        
    }

    protected function loadProperties()
    {
        $query = Propiedad::query();

        $categoriaId = Input::get('categoria_id');  
        $ciudadId = Input::get('ciudad_id');        
        $disponibilidad = Input::get('disponibilidad'); 
        $nombre = Input::get('nombre'); 


        if ($categoriaId) {
            $query->where('id_categoria', $categoriaId);
        }

        if ($ciudadId) {
            $query->where('id_ciudad', $ciudadId);
        }

        if ($disponibilidad) {
            $query->where('estado', $disponibilidad);
        }

        // if ($nombre) {
        //     $query->where('nombre', 'like', '%' . $nombre . '%');
        // }

        // if ($nombre) {
        //     $query->where(function($q) use ($nombre) {
        //         $q->where('nombre', 'like', '%' . $nombre . '%')
        //         ->orWhereHas('categoria', function($q2) use ($nombre) {
        //             $q2->where('categoria', 'like', '%' . $nombre . '%');
        //         });
        //     });
        // }

        if ($nombre) {
            $query->where(function($q) use ($nombre) {
                $q->where('nombre', 'like', '%' . $nombre . '%')
                ->orWhereHas('categoria', function($q2) use ($nombre) {
                    $q2->where('categoria', 'like', '%' . $nombre . '%');
                })
                ->orWhereHas('ciudad', function($q3) use ($nombre) {
                    $q3->where('ciudad', 'like', '%' . $nombre . '%');
                });
            });
        }


        $query->where('activo', true);

        return $query->get();
    }

    

    // protected function loadProperties()
    // {
    //     $query = Propiedad::query();

    //     // Aplicar filtros
    //     $keyword = Input::get('keyword');
    //     $city = Input::get('city');
    //     $catagories = Input::get('catagories');
    //     $bedrooms = Input::get('bedrooms');
    //     $bathrooms = Input::get('bathrooms');
        
    //     $minPrice = Input::get('min_price');
    //     $maxPrice = Input::get('max_price');
        
        
    //     if ($keyword) {
    //         $query->where('nombre', 'like', '%' . $keyword . '%');
    //     }

    //     if ($city) {
    //         $query->where('id_ciudad',$city);
    //     }

    //     if ($catagories) {
    //         $query->where('id_categoria',$catagories);
    //     }

    //     if ($bedrooms) {
    //         $query->where('habitaciones',$bedrooms);
    //     }
    //     if ($bathrooms) {
    //         $query->where('banos',$bathrooms);
    //     }




    //     if ($minPrice) {
    //         $query->where('price', '>=', $minPrice);
    //     }

    //     if ($maxPrice) {
    //         $query->where('price', '<=', $maxPrice);
    //     }

    //     // Solo propiedades activas
    //     $query->where('activo', true);

    //     return $query->get();
    // }
    
    
    
}