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
        $cacheKey = 'api:properties:' . md5(json_encode(Request::all()));
        return Cache::remember($cacheKey, 60, function() {
            $page = max(1, (int) Request::get('page', 1));
            $perPage = min(100, max(1, (int) Request::get('per_page', 12)));

            $query = Propiedad::with(['ciudad', 'categoria', 'portada'])->where('activo', 1);

            if ($cat = Request::get('categoria_id')) {
                $query->where('id_categoria', $cat);
                    protected function authorizeRequest()
                    {
                        $envKey = env('REALSTATE_API_KEY', null);
                        if (!$envKey) {
                            // No API key configured — allow access (dev mode)
                            return true;
                        }

                        $header = Request::header('X-API-KEY') ?: Request::get('api_key');
                        if (!$header) return false;

                        // timing-attack safe compare
                        return function_exists('hash_equals') ? hash_equals($envKey, $header) : ($envKey === $header);
                    }

                    protected function unauthorizedResponse()
                    {
                        return response()->json(['message' => 'Unauthorized'], 401);
                    }

            }
            if ($city = Request::get('ciudad_id')) {
                        if (!$this->authorizeRequest()) return $this->unauthorizedResponse();

                        $cacheKey = 'api:properties:' . md5(json_encode(Request::all()));
                        return Cache::remember($cacheKey, 60, function() {
            if ($d = Request::get('disponibilidad')) {
                $query->where('estado', $d);
            }
            if ($n = Request::get('nombre')) {
                $query->where(function($q) use ($n) {
                    $q->where('nombre', 'like', "%{$n}%")
                      ->orWhere('titulo', 'like', "%{$n}%")
                      ->orWhereHas('categoria', function($q2) use ($n) { $q2->where('categoria', 'like', "%{$n}%"); })
                      ->orWhereHas('ciudad', function($q3) use ($n) { $q3->where('ciudad', 'like', "%{$n}%"); });
                });
            }

            $results = $query->orderBy('updated_at', 'desc')->paginate($perPage);

            $data = $results->getCollection()->map(function($item){
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
    }

    public function property($slug)
    {
        $cacheKey = 'api:property:' . $slug;
        return Cache::remember($cacheKey, 60, function() use ($slug) {
            $item = Propiedad::with(['ciudad', 'categoria', 'galeria', 'portada'])->where('slug', $slug)->where('activo',1)->first();
            if (!$item) return response()->json(['message' => 'Not found'], 404);

            return response()->json([
                'id' => $item->id,
                'slug' => $item->slug,
                'titulo' => $item->titulo,
                'nombre' => $item->nombre,
                        if (!$this->authorizeRequest()) return $this->unauthorizedResponse();

                        $cacheKey = 'api:property:' . $slug;
                        return Cache::remember($cacheKey, 60, function() use ($slug) {
                            $item = Propiedad::with(['ciudad', 'categoria', 'galeria', 'portada'])->where('slug', $slug)->where('activo',1)->first();
                            if (!$item) return response()->json(['message' => 'Not found'], 404);

                            $portada = $item->portada ? [
                                'path' => $item->portada->getPath(),
                                'thumbs' => [
                                    '800' => $item->portada->getThumb(800, null),
                                    '400' => $item->portada->getThumb(400, null)
                                ]
                            ] : null;

                            $galeria = $item->galeria->map(function($f){
                                return [
                                    'path' => $f->getPath(),
                                    'thumbs' => [ '800' => $f->getThumb(800, null), '400' => $f->getThumb(400, null) ]
                                ];
                            })->all();

                            return response()->json([
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
                            ]);
                        });
    {
        return Cache::remember('api:categories', 300, function() {
            return Categoria::where('activo',1)->get(['id','categoria']);
        });
    }
}
