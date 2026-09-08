# Guía de Defensa Técnica Oral — ASII-24 Semana 5

**Estudiante:** Albino Sebastián Rosales Ruano  
**Módulo:** ASII-24 — Centro de documentación y manuales por rol  

---

## Preguntas Clave para la Defensa y Respuestas Justificadas

### 1. ¿Por qué se decidió NO separar este módulo en un microservicio físico independiente de inmediato?
**Respuesta:**
De acuerdo con el análisis de costo-beneficio registrado en el **ADR-001**:
* Un microservicio independiente introduce alta complejidad operacional (redes distribuidas, transacciones eventuales, latencia de red, gateways independientes y pipelines separados).
* El módulo ASII-24 maneja principalmente metadatos documentales y manuales por rol, cuyo volumen de tráfico no justifica dicha sobrecarga.
* La solución óptima es un **Monolito Modular con Frontera Lógica Limpia**: el código está totalmente desacoplado mediante Clean Architecture y el patrón Repository. Si en el futuro la carga o los requerimientos institucionales exigen extraerlo a un contenedor Docker independiente, la migración será directa sin refactorizar el dominio ni los casos de uso.

### 2. ¿Cómo se garantiza que la colección de Postman y el contrato OpenAPI permanezcan sincronizados?
**Respuesta:**
* El contrato `openapi.yaml` actúa como la **única fuente de verdad** (Contract-First Design).
* La colección Postman se diseñó mapeando exactamente los mismos paths, métodos, encabezados requeridos (`X-Tenant-ID`, `Authorization`) y payloads JSON definidos en los schemas de OpenAPI.
* Contamos con una suite automatizada (`php week-05/scripts/run-tests.php`) que valida la consistencia cruzada entre los endpoints de Postman y las rutas del contrato OpenAPI.

### 3. ¿Cómo maneja la API los escenarios de error exigidos (400, 401, 404, 409, 422)?
**Respuesta:**
Cada escenario está previsto tanto a nivel de middleware como en los controladores y validadores:
* **400 Bad Request:** Se dispara cuando falta la cabecera obligatoria `X-Tenant-ID`.
* **401 Unauthorized:** Ocurre cuando la petición no incluye el token Bearer JWT o éste es inválido/expirado.
* **403 Forbidden:** Ocurre cuando el rol del usuario autenticado no coincide con los roles autorizados del documento.
* **404 Not Found:** Se retorna cuando el ID del contrato o documento no existe en el repositorio.
* **409 Conflict:** Ocurre cuando se intenta publicar una versión ya existente de un contrato (idempotencia e inmutabilidad).
* **422 Unprocessable Entity:** Falla de validación estructural del payload o violación de invariantes de negocio.
