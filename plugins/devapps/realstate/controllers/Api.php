<?php namespace Devapps\RealState\Controllers;

use Illuminate\Routing\Controller;
use Devapps\RealState\Models\Propiedad;
use Devapps\RealState\Models\Ciudad;
use Devapps\RealState\Models\Categoria;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;

class Api extends Controller
{
    public function properties()
    {
        if (!$this->authorizeRequest()) return $this->unauthorizedResponse();

        $cacheKey = 'api:properties:' . md5(json_encode(Request::all()));
        return Cache::remember($cacheKey, 60, function() {
            $page = max(1, (int) Request::get('page', 1));
            $perPage = min(100, max(1, (int) Request::get('per_page', 12)));

            $query = Propiedad::with(['ciudad', 'categoria', 'portada'])->where('activo', 1);

            // Filter by category
            if ($cat = Request::get('categoria_id')) {
                $query->where('id_categoria', $cat);
            }

            // Filter by city
            if ($city = Request::get('ciudad_id')) {
                $query->where('id_ciudad', $city);
            }

            // Filter by availability
            if ($d = Request::get('disponibilidad')) {
                $query->where('estado', $d);
            }

            // Filter by name/title
            if ($n = Request::get('nombre')) {
                $query->where(function($q) use ($n) {
                    $q->where('nombre', 'like', "%{$n}%")
                      ->orWhere('titulo', 'like', "%{$n}%")
                      ->orWhereHas('categoria', function($q2) use ($n) {
                          $q2->where('categoria', 'like', "%{$n}%");
                      })
                      ->orWhereHas('ciudad', function($q3) use ($n) {
                          $q3->where('ciudad', 'like', "%{$n}%");
                      });
                });
            }

            $results = $query->orderBy('updated_at', 'desc')->paginate($perPage);

            $data = $results->getCollection()->map(function($item){
                $portada = null;
                if ($item->portada) {
                    $portada = [
                        'path' => $item->portada->getPath(),
                        'thumbs' => [
                            '800' => $item->portada->getThumb(800, null),
                            '400' => $item->portada->getThumb(400, null)
                        ]
                    ];
                }

                return [
                    'id' => $item->id,
                    'slug' => $item->slug,
                    'titulo' => $item->titulo,
                    'nombre' => $item->nombre,
                    'precio' => $item->precio,
                    'moneda' => $item->moneda,
                    'direccion' => $item->direccion,
                    'estado' => $item->estado,
                    'ciudad' => $item->ciudad ? $item->ciudad->ciudad : null,
                    'categoria' => $item->categoria ? $item->categoria->categoria : null,
                    'habitaciones' => $item->habitaciones,
                    'banos' => $item->banos,
                    'cajones_estacionamiento' => $item->cajones_estacionamiento,
                    'm2_terreno' => $item->m2_terreno,
                    'portada' => $portada
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $data,
                'pagination' => [
                    'total' => $results->total(),
                    'per_page' => $results->perPage(),
                    'current_page' => $results->currentPage(),
                    'last_page' => $results->lastPage()
                ]
            ]);
        });
    }

    public function property($slug)
    {
        if (!$this->authorizeRequest()) return $this->unauthorizedResponse();

        $cacheKey = 'api:property:' . $slug;
        return Cache::remember($cacheKey, 60, function() use ($slug) {
            $item = Propiedad::with(['ciudad', 'categoria', 'galeria', 'portada'])
                ->where('slug', $slug)
                ->where('activo', 1)
                ->first();

            if (!$item) {
                return response()->json(['message' => 'Not found'], 404);
            }

            $portada = null;
            if ($item->portada) {
                $portada = [
                    'path' => $item->portada->getPath(),
                    'thumbs' => [
                        '800' => $item->portada->getThumb(800, null),
                        '400' => $item->portada->getThumb(400, null)
                    ]
                ];
            }

            $galeria = $item->galeria ? $item->galeria->map(function($f){
                return [
                    'path' => $f->getPath(),
                    'thumbs' => [
                        '800' => $f->getThumb(800, null),
                        '400' => $f->getThumb(400, null)
                    ]
                ];
            })->all() : [];

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $item->id,
                    'slug' => $item->slug,
                    'titulo' => $item->titulo,
                    'nombre' => $item->nombre,
                    'descripcion' => $item->descripcion,
                    'precio' => $item->precio,
                    'moneda' => $item->moneda,
                    'direccion' => $item->direccion,
                    'estado' => $item->estado,
                    'ciudad' => $item->ciudad ? $item->ciudad->ciudad : null,
                    'categoria' => $item->categoria ? $item->categoria->categoria : null,
                    'habitaciones' => $item->habitaciones,
                    'banos' => $item->banos,
                    'cajones_estacionamiento' => $item->cajones_estacionamiento,
                    'm2_terreno' => $item->m2_terreno,
                    'portada' => $portada,
                    'galeria' => $galeria
                ]
            ]);
        });
    }

    public function cities()
    {
        if (!$this->authorizeRequest()) return $this->unauthorizedResponse();

        return Cache::remember('api:cities', 300, function() {
            $cities = Ciudad::where('activo', 1)
                ->get(['id', 'ciudad'])
                ->map(function($item) {
                    return [
                        'id' => $item->id,
                        'nombre' => $item->ciudad
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => $cities
            ]);
        });
    }

    public function categories()
    {
        if (!$this->authorizeRequest()) return $this->unauthorizedResponse();

        return Cache::remember('api:categories', 300, function() {
            $categories = Categoria::where('activo', 1)
                ->get(['id', 'categoria'])
                ->map(function($item) {
                    return [
                        'id' => $item->id,
                        'nombre' => $item->categoria
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => $categories
            ]);
        });
    }

    /**
     * Check if API request is authorized
     * Allows access if no REALSTATE_API_KEY configured (dev mode)
     * Otherwise requires valid X-API-KEY header or api_key query param
     */
    protected function authorizeRequest()
    {
        $envKey = env('REALSTATE_API_KEY', null);
        if (!$envKey) {
            // No API key configured — allow access (dev mode)
            return true;
        }

        $header = Request::header('X-API-KEY') ?: Request::get('api_key');
        if (!$header) {
            return false;
        }

        // timing-attack safe compare
        return function_exists('hash_equals') ? hash_equals($envKey, $header) : ($envKey === $header);
    }

    /**
     * Return unauthorized response
     */
    protected function unauthorizedResponse()
    {
        return response()->json([
            'success' => false,
            'message' => 'Unauthorized'
        ], 401);
    }
}
