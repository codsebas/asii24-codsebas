# Defensa Oral - Semana 8: Diseño de Experiencia de Usuario (UX)

## 1. Desacoplamiento de la Experiencia por Perfil de Usuario

**Pregunta del Tribunal:** ¿Por qué no unificar la documentación técnica de OpenAPI con los manuales de usuario en una sola vista estándar de Swagger UI?

**Defensa Técnica:**
Unificar ambas audiencias bajo una interfaz técnica como Swagger UI introduciría sobrecarga cognitiva severa y riesgo operativo para el personal clínico. Los médicos y enfermeras operan bajo presión de tiempo y requieren respuestas procedimentales inmediatas (por ejemplo: protocolo de ingreso en triage o reporte de laboratorio crítico), sin verse expuestos a parámetros JSON, cabeceras HTTP ni códigos de estado.

Por ello, se implementó una arquitectura de información desacoplada: el sistema detecta el rol del usuario mediante RBAC y adapta el layout. Para perfiles clínicos se presentan guías operativas en lenguaje natural con ayudas contextuales; para perfiles técnicos se habilita la consola interactiva con especificación OpenAPI 3.0, colecciones Postman y payloads de prueba.

---

## 2. Gestión de Errores Recuperables frente a Fallas Críticas

**Pregunta del Tribunal:** ¿Cómo garantiza la UX que un fallo de conexión o error de esquema no obligue al usuario a reescribir su trabajo?

**Defensa Técnica:**
El diseño adopta el estándar RFC 7807 (*Problem Details for HTTP APIs*) vinculado a un patrón de error recuperable en la UI. Si la validación de un contrato OpenAPI falla al publicarse o si ocurre una desconexión de red:
1. El estado del formulario se preserva íntegramente en memoria reactiva local.
2. La interfaz resalta con precisión el campo o línea que causó el conflicto (ej. error 422 con puntero JSON `/paths/~1contracts/post`).
3. Se ofrece un botón de reintento (`Reintentar validación`) que solo envía la diferencia sin recargar la página completa, eliminando la frustración del usuario y el riesgo de pérdida de datos.

---

## 3. Prevención de Errores y Confirmación Crítica

**Pregunta del Tribunal:** ¿Qué controles se aplican para evitar la publicación accidental de contratos que rompan compatibilidad?

**Defensa Técnica:**
Se diseñó un modal de confirmación crítica que analiza el cambio de versión (SemVer). Si se detecta un cambio *Major* (ruptura de contrato), el modal exige al administrador escribir explícitamente el nombre de la versión para habilitar el botón de confirmación, listando los módulos y consumidores que serán afectados.
