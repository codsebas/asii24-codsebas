# Guía y Banco de Respuestas para Defensa Oral (Parcial 1)

**Estudiante:** Albino Sebastián Rosales Ruano
**GitHub:** [`codsebas`](https://github.com/codsebas)
**Módulo:** ASII-24 — Centro de documentación y manuales por rol

---

### Pregunta 1: ¿Cómo se garantiza la trazabilidad continua desde los casos de uso iniciales hasta el contrato OpenAPI 3.0?
**Respuesta:**
Cada caso de uso delimitado en Semana 1 (`UC-01` a `UC-10`) mapea directamente a una intención de negocio que fue refinada en Semana 2 con criterios `Dado / Cuando / Entonces`. En la capa de aplicación (Semana 3 y 4), cada caso de uso se modeló como una clase atómica (`PublishDocument`, `GetDocumentById`, `ListDocumentsByRole`). Finalmente, en Semana 5, estos casos de uso se expusieron formalmente en el contrato canónico `contracts/openapi.yaml` como operaciones REST parametrizadas con validaciones de cabecera `Authorization: Bearer` y `X-Tenant-ID`, verificadas mediante la colección Postman.

---

### Pregunta 2: ¿Por qué se implementó el Patrón Repository y qué ventaja aporta al hospital?
**Respuesta:**
El patrón Repository (Semana 4) aísla completamente la lógica de negocio de la infraestructura de persistencia. El dominio solo conoce la interfaz `DocumentRepository`. Esto permite al hospital:
1. Cambiar el motor de persistencia (ej. migrar de SQLite local a PostgreSQL o un repositorio federado) sin tocar una sola regla de negocio.
2. Ejecutar suites de pruebas unitarias ultra-rápidas mediante `InMemoryDocumentRepository` sin depender de conexiones de red ni bases de datos activas.
3. Prevenir vulnerabilidades críticas de inyección SQL mediante el adaptador `PdoDocumentRepository` que utiliza exclusivamente sentencias preparadas.

---

### Pregunta 3: ¿Cómo responde el diseño ante el cambio práctico (ciclo de vida y rol Auditor)?
**Respuesta:**
La arquitectura demostró alta cohesión y bajo acoplamiento:
1. En el dominio, el estado es una regla invariante más que se valida al instanciar `Document`, asignando `PUBLISHED` por defecto para preservar total compatibilidad hacia atrás.
2. En la persistencia, se agregó la columna `status` sin alterar la estructura de claves primarias.
3. En la capa cliente-servidor, el contrato OpenAPI simplemente declaró el enum y se habilitaron cabeceras RFC 8594 (`Deprecation` y `Sunset`) para documentos en desuso, permitiendo que el nuevo rol `AuditorExterno` tenga acceso de solo lectura sin capacidad de alterar contratos.
