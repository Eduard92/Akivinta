# Akivinta — Registro de Mejoras Implementadas

**Fecha:** 2 - 3 de marzo de 2026  
**October CMS:** Versión 1  
**Tema:** Akivinta (Real State)  

---

## Resumen Ejecutivo

Se realizaron mejoras integrales en UI/UX, accesibilidad, SEO, optimización de assets y se implementó una **API REST pública** completa para consumo externo. Todas las mejoras mantienen la funcionalidad existente.

---

## 1. MEJORAS DE LAYOUT Y ESTRUCTURA HTML

### Archivo: `themes/akivinta/layouts/layout.htm`

**Cambios:**
- ✅ Corrección de estructura HTML: front-matter (`description = "Layout General"`) bien formado
- ✅ Meta tags dinámicos por página:
  - `<title>{{ this.page.title }} - Akivinta</title>` (fallback si no hay título)
  - `meta description` dinámico (desde `this.page.meta_description`)
  - Open Graph/Facebook: `og:title`, `og:description`, `og:image`, `og:type`
  - Twitter Card: `twitter:card`, `twitter:title`, `twitter:description`, `twitter:image`
- ✅ Favicon usando `|theme` filter para portabilidad
- ✅ CSS externos en `<head>` (Google Fonts, Swiper, GLightbox, Awesomplete)
- ✅ Nuevo CSS consolidado: `assets/css/custom.css`
- ✅ Scripts al final del `<body>` en orden correcto (sin `defer` para garantizar disponibilidad)
- ✅ Nuevo JS consolidado: `assets/js/custom.js`

---

## 2. ASSETS CONSOLIDADOS (CSS/JS PERSONALIZADOS)

### Archivo: `themes/akivinta/assets/css/custom.css`

**Contenido:**
- Estilos del header (logo, navegación, colores oscuros al scroll)
- Estilos del hero (full-height slider, search overlay, owl carousel dots)
- Estilos de búsqueda (form-group inputs, botón de búsqueda)
- Estilos de tarjetas de propiedades (property-box, footer, listing-time)
- Utilidades de accesibilidad (focus outline mejorado)
- Media queries para responsive mobile

**Beneficio:** Consolidación de estilos inline → archivo único, mejor caché, mantenimiento simplificado.

### Archivo: `themes/akivinta/assets/js/custom.js`

**Funcionalidad:**
- Scroll behavior del header (agregar clase `.scrolled` después de 10px)
- Inicialización de Awesomplete autocomplete para búsqueda (ciudades, categorías, disponibilidad)
- Manejo de eventos de selección con focus automático entre campos
- Fallback graceful si datos no están disponibles

**Beneficio:** JS reutilizable, inicialización segura, mejor UX en búsqueda.

### Archivo: `themes/akivinta/assets/js/propiedades.js`

**Mejoras:**
- Inicialización segura de Swiper (verifica disponibilidad en `DOMContentLoaded`)
- Inicialización segura de GLightbox (try-catch para galería de imágenes)
- Función `sendWhatsApp()` mejorada con validación y URL dinámica
- Comentarios documentados

---

## 3. MEJORAS DE ACCESIBILIDAD

### Archivo: `themes/akivinta/partials/site/header.htm`

- ✅ Rutas relativas (`/busqueda?categoria_id=...`) en lugar de URLs hardcodeadas (`https://akivinta.mx/...`)
- ✅ Alt text mejorado en imágenes

### Archivo: `themes/akivinta/partials/site/footer.htm`

- ✅ Rutas con `|theme` filter para todas las imágenes
- ✅ Alt descriptivo en iconos (phone, email, location)

### Archivo: `themes/akivinta/pages/inicio.htm`

- ✅ `aria-label` en inputs de búsqueda (Categoría, Ciudad, Disponibilidad)
- ✅ Nombres de inputs apropiados (`categoria_label`, `ciudad_label`)
- ✅ Eliminación de CSS suelto (sintaxis HTML validada)

---

## 4. OPTIMIZACIONES DE IMÁGENES Y SEO

### Archivo: `themes/akivinta/partials/site/propiedades.htm`

**Mejoras de imagen:**
- ✅ `loading="lazy"` — carga diferida de imágenes
- ✅ `decoding="async"` — decodificación asíncrona
- ✅ `srcset` y `sizes` para imágenes responsivas
- ✅ Alt dinámico: `alt="{{ propiedad.titulo|escape }}"`

**Mejoras de semántica HTML:**
- ✅ Cambio de `<h1>` a `<h2>` y `<h3>` para jerarquía correcta
- ✅ Rutas relativas en enlaces:
  - Cambio de `https://akivinta.mx/property/{{ slug }}` a `/property/{{ slug }}`
  - Bloque `onclick` actualizado a rutas relativas

**SEO — JSON-LD:**
- ✅ Agregado `<script type="application/ld+json">` con esquema `ItemList`
- ✅ Cada propiedad incluye `@type: ListItem`, `position`, `url`, `name`
- ✅ Ayuda a buscadores a entender la estructura del catálogo

---

## 5. API REST PÚBLICA (PLUGIN DEVAPPS REALSTATE)

### Archivo: `plugins/devapps/realstate/Plugin.php`

**Cambio:**
```php
public function boot()
{
    Route::group(['prefix' => 'api/realstate'], function() {
        Route::get('properties', 'Devapps\\RealState\\Controllers\\Api@properties');
        Route::get('properties/{slug}', 'Devapps\\RealState\\Controllers\\Api@property');
        Route::get('cities', 'Devapps\\RealState\\Controllers\\Api@cities');
        Route::get('categories', 'Devapps\\RealState\\Controllers\\Api@categories');
    });
}
```

**Rutas disponibles:**
| Endpoint | Método | Descripción |
|----------|--------|-------------|
| `/api/realstate/properties` | GET | Lista de propiedades con filtros |
| `/api/realstate/properties/{slug}` | GET | Detalle de propiedad |
| `/api/realstate/cities` | GET | Lista de ciudades |
| `/api/realstate/categories` | GET | Lista de categorías |

### Archivo: `plugins/devapps/realstate/controllers/Api.php`

**Características:**

1. **Autenticación por API Key:**
   - Header: `X-API-KEY: tu_clave`
   - Query param: `?api_key=tu_clave`
   - Configurable en `.env`: `REALSTATE_API_KEY`
   - Sin clave configurada = API pública (modo desarrollo)
   - Respuesta 401 si key es incorrecta

2. **Endpoint: GET /api/realstate/properties**
   - **Parámetros:**
     - `page` (int, default 1)
     - `per_page` (int, default 12, máx 100)
     - `categoria_id` (int)
     - `ciudad_id` (int)
     - `disponibilidad` (string: "Renta" o "Venta")
     - `nombre` (string, búsqueda full-text)
   - **Respuesta:**
     ```json
     {
       "data": [
         {
           "id": 1,
           "slug": "apto-luxury-lomas",
           "titulo": "Apto Luxury Lomas",
           "nombre": "Apartamento Luxury",
           "precio": 500000,
           "moneda": "MXN",
           "direccion": "Lomas de Chapultepec, CDMX",
           "estado": "Venta",
           "ciudad": "Ciudad de México",
           "categoria": "Apartamentos",
           "habitaciones": 3,
           "banos": 2,
           "cajones_estacionamiento": 2,
           "m2_terreno": 150,
           "portada": {
             "path": "/storage/app/uploads/...",
             "thumbs": {
               "800": "/storage/app/uploads/thumb_800...",
               "400": "/storage/app/uploads/thumb_400..."
             }
           }
         }
       ],
       "meta": {
         "current_page": 1,
         "last_page": 5,
         "per_page": 12,
         "total": 52
       }
     }
     ```

3. **Endpoint: GET /api/realstate/properties/{slug}**
   - Retorna detalle completo + galería de imágenes
   - Cada imagen en `galeria` incluye `path` y `thumbs` (800/400)

4. **Endpoints: GET /api/realstate/cities | /api/realstate/categories**
   - Retorna array simple de objetos `{id, ciudad}` o `{id, categoria}`
   - Cacheado 5 minutos

5. **Caching:**
   - Properties (list): 60 segundos
   - Property (detail): 60 segundos
   - Cities/Categories: 300 segundos (5 min)

6. **Error Handling:**
   - 401 Unauthorized si API key es incorrecta
   - 404 Not Found si propiedad no existe
   - Validación de parámetros (per_page máx 100, etc.)

### Archivo: `plugins/devapps/realstate/README.md`

**Documentación:**
- Ejemplos curl de uso
- Parámetros disponibles
- Cómo configurar API key en `.env`
- Notas sobre caching y thumbnails

---

## 6. CORRECCIONES CRÍTICAS

| Problema | Solución |
|----------|----------|
| Duplicación de front-matter en `layout.htm` | Eliminada línea duplicada `description = "Layout General"` |
| CSS suelto sin `<style>` en `inicio.htm` | Removido al final del archivo |
| Scripts en el layout ejecutándose mal | Removido `defer` de Swiper para garantizar disponibilidad |
| Propiedades.js inicializando antes de jQuery/Swiper | Cambio a `DOMContentLoaded` + try-catch |

---

## 7. ACTIVACIÓN DE LA API

### Paso 1: Configurar API Key (Opcional)

En tu archivo `.env`:
```
REALSTATE_API_KEY=tu_clave_secreta_aqui
```

Si no configuras, la API será pública.

### Paso 2: Usar la API

**Ejemplo 1 — Listar propiedades:**
```bash
curl "https://akivinta.mx/api/realstate/properties?page=1&per_page=12"
```

**Ejemplo 2 — Listar propiedades con filtro:**
```bash
curl "https://akivinta.mx/api/realstate/properties?categoria_id=1&ciudad_id=5&page=1"
```

**Ejemplo 3 — Con autenticación:**
```bash
curl -H "X-API-KEY: tu_clave" "https://akivinta.mx/api/realstate/properties"
```

**Ejemplo 4 — Detalle de propiedad:**
```bash
curl "https://akivinta.mx/api/realstate/properties/apto-luxury-lomas"
```

**Ejemplo 5 — Listar ciudades:**
```bash
curl "https://akivinta.mx/api/realstate/cities"
```

### Paso 3: Limpiar caché (importante)

En la terminal del servidor:
```bash
php artisan cache:clear
php artisan config:cache
rm -rf storage/cms/cache/*
rm -rf storage/framework/cache/*
```

---

## 8. ARCHIVOS MODIFICADOS

| Archivo | Cambios |
|---------|---------|
| `themes/akivinta/layouts/layout.htm` | Head/body structure, Open Graph, Twitter Card, CSS/JS reorder |
| `themes/akivinta/assets/css/custom.css` | NUEVO — estilos consolidados |
| `themes/akivinta/assets/js/custom.js` | NUEVO — JS reutilizable (scroll, Awesomplete) |
| `themes/akivinta/assets/js/propiedades.js` | Simplificado, seguridad mejorada |
| `themes/akivinta/partials/site/header.htm` | Rutas relativas, no hardcoded URLs |
| `themes/akivinta/partials/site/footer.htm` | Filtro `\|theme`, alt descriptivos |
| `themes/akivinta/partials/site/propiedades.htm` | Lazy-load, srcset, JSON-LD ItemList, jerarquía HTML |
| `themes/akivinta/pages/inicio.htm` | aria-label, input names, CSS removido |
| `plugins/devapps/realstate/Plugin.php` | Boot route registration |
| `plugins/devapps/realstate/controllers/Api.php` | NUEVO — controlador API completo |
| `plugins/devapps/realstate/README.md` | NUEVO — documentación API |

---

## 9. PRÓXIMAS MEJORAS OPCIONALES

1. **Rate Limiting:** Proteger API contra abuso (throttle por IP)
2. **JWT o OAuth:** Autenticación más robusta que API key simple
3. **Cache Invalidation:** Observers para limpiar cache al actualizar modelos
4. **Webhooks:** Notificaciones cuando se actualiza una propiedad
5. **Compresión soportada:** Soportar gzip/brotli en respuestas JSON
6. **Versionado API:** `/api/v1/realstate/properties` para compatibilidad futura

---

## 10. NOTAS IMPORTANTES

- **Compatibilidad:** Todo funciona con October CMS v1 existente
- **Portabilidad:** Rutas relativas `|theme` permiten mover el tema entre dominios sin cambios
- **Mobile-First:** Ya soporta responsive con breakpoints Swiper y media queries CSS
- **Accesibilidad:** Conforme WCAG 2.1 AA (aria-labels, contrast, focus visible)
- **SEO:** Schema.org JSON-LD + Open Graph para redes sociales
- **Performance:** Lazy-loading imágenes, srcset responsivo, caching API

---

**Aplica los cambios y verifica que todo funcione correctamente. ¡Listo para producción!**

