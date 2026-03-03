# 🚀 Instrucciones de Deployment — Akivinta Mejoras

**Fecha:** 3 de marzo de 2026  
**Estado:** ✅ Listo para producción

---

## 📋 Checklist Pre-Deploy

- [x] Corregido `propiedades.js` — inicialización simple y segura
- [x] Validado `layout.htm` — front-matter correcto, meta tags funcionales
- [x] Validado `inicio.htm` — sin CSS suelto, sintaxis HTML limpia
- [x] Validado `custom.css` — estilos consolidados cargados
- [x] Validado `custom.js` — JS personalizado funcional
- [x] API REST implementada — 4 endpoints + autenticación
- [x] Accesibilidad mejorada — aria-labels, alt descriptivos
- [x] SEO mejorado — Open Graph, Twitter Card, JSON-LD

---

## 🔼 Procedimiento de Subida

### Opción 1: Git (Recomendado)

```bash
cd /home/u714618105/domains/akivinta.mx/public_html
git add .
git commit -m "feat: UI/UX, accesibilidad, SEO, API REST"
git push origin main
```

### Opción 2: FTP/SFTP

Subir estos archivos modificados:

**Tema:**
```
themes/akivinta/layouts/layout.htm
themes/akivinta/pages/inicio.htm
themes/akivinta/partials/site/header.htm
themes/akivinta/partials/site/footer.htm
themes/akivinta/partials/site/propiedades.htm
themes/akivinta/assets/css/custom.css (NUEVO)
themes/akivinta/assets/js/custom.js (NUEVO)
themes/akivinta/assets/js/propiedades.js
```

**Plugin:**
```
plugins/devapps/realstate/Plugin.php
plugins/devapps/realstate/controllers/Api.php (NUEVO)
plugins/devapps/realstate/README.md (NUEVO)
```

**Documentación:**
```
CHANGELOG_MEJORAS.md (NUEVO)
```

---

## 🔧 Post-Deploy (En el servidor)

**1. Limpiar cache:**
```bash
php artisan cache:clear
php artisan config:cache
rm -rf storage/cms/cache/*
rm -rf storage/framework/cache/*
```

**2. (Opcional) Configurar API Key:**

Editar `.env`:
```
REALSTATE_API_KEY=tu_clave_secreta_muy_larga_aqui
```

Luego:
```bash
php artisan config:cache
```

---

## ✅ Verificación Post-Deploy

### 1. Verificar frontend funciona
```
https://akivinta.mx → Debe cargar sin errores console
https://akivinta.mx/busqueda → Búsqueda funciona
https://akivinta.mx/property/[slug] → Detalle de propiedad
```

### 2. Verificar API está activa
```bash
curl "https://akivinta.mx/api/realstate/properties"
```

Debe retornar JSON con lista de propiedades.

### 3. Verificar CSS y JS funcionan
```
F12 → Console → Sin errores rojos
F12 → Network → Todos los assets cargan (200 OK)
```

### 4. Verificar meta tags
```bash
curl "https://akivinta.mx" | grep -A5 "og:title"
```

Debe mostrar Open Graph tags.

---

## 🐛 Troubleshooting

| Problema | Solución |
|----------|----------|
| Página en blanco | Limpiar caché: `php artisan cache:clear` |
| CSS no carga | Verificar `custom.css` existe: `ls themes/akivinta/assets/css/custom.css` |
| JS error "Swiper is not defined" | Ya corregido en nueva versión `propiedades.js` |
| API retorna 401 | API key configurada pero incorrecta; verificar `.env` |
| API retorna 404 para `/api/realstate/...` | Ejecutar `php artisan config:cache` |

---

## 📞 Soporte

Todos los cambios están documentados en `CHANGELOG_MEJORAS.md` con:
- Detalles técnicos de cada mejora
- Archivos modificados
- Ejemplos de uso de la API

---

**¡Listo para subir a producción!** 🎉

