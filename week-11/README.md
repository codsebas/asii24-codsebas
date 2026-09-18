# ASII-24 - Semana 11: Prototipo Navegable Móvil/Web

## Centro de Documentación y Manuales por Rol | Sistema Hospitalario Integrado 2026

- **Módulo:** ASII-24 — Contratos API: OpenAPI/Postman y documentación técnica
- **Adaptación:** Centro de documentación y manuales por rol
- **Estudiante:** Albino Sebastián Rosales Ruano (`codsebas`)
- **Semana:** 11 (Mejores prácticas para diseño móvil/web y prototipo funcional)

---

## 1. Resumen Ejecutivo de la Entrega

En esta entrega se culmina el ciclo de diseño y análisis mediante un **prototipo interactivo navegable y funcional (`prototype/index.html`)**, desarrollado bajo estándares web modernos (HTML5 semántico, CSS3 responsive y JavaScript ES6+ sin dependencias externas pesadas).

El prototipo opera de forma nativa tanto en estaciones de escritorio ($1024\text{px}+$) como en dispositivos móviles hospitalarios compactos ($320 - 430\text{px}$), cubriendo con rigor técnico:
1. **Camino Feliz (Happy Path):** Selección de rol, búsqueda de manuales clínicos con disponibilidad offline y ejecución interactiva en Sandbox de contratos OpenAPI 3.0 con respuesta HTTP 200 OK sanitizada y copia rápida de cURL.
2. **Error Crítico (Critical Error Path):** Publicación SemVer Major con validación de seguridad fallida (HTTP 422 ProblemDetails RFC 7807), foco accesible, atributo `aria-invalid="true"` y recuperación *in-situ*.
3. **Simulación de Contingencia de Red:** Conmutación dinámica entre estado `[ ONLINE ]` y `[ MODO OFFLINE ]` con Service Worker cache y timeout de red 504.

---

## 2. Instrucciones para Ejecutar el Prototipo

El prototipo es completamente autónomo y no requiere instalación de servidores pesados:

```bash
# Opción 1: Abrir directamente en el navegador predeterminado
# En Windows PowerShell:
Start-Process "docs/asii-24/week-11/prototype/index.html"

# Opción 2: Servir mediante servidor web ligero integrado en PHP
php -S localhost:8000 -t docs/asii-24/week-11/prototype
```

---

## 3. Matriz de Validación Automatizada

Para verificar la integridad del prototipo, contratos y accesibilidad:

```bash
php docs/asii-24/week-11/scripts/run-validation.php
```
