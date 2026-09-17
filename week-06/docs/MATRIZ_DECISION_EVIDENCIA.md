# Matriz de Decisión Arquitectónica y Evidencia (ASII-24)

Esta matriz conecta formalmente los desafíos de negocio y técnicos del Sistema Hospitalario Integrado (SHI) con las decisiones adoptadas en ASII-24 y su evidencia verificable en el repositorio.

| # | Problema de Diseño / Requisito | Decisión Arquitectónica Adoptada | Criterio de Calidad (ISO 25010) | Evidencia en Código / Artefacto |
|---|---|---|---|---|
| 1 | Acceso restringido y no autorizado a manuales clínicos y documentación técnica | Control de Acceso Basado en Roles (RBAC) con filtro estricto por claim en entidad de dominio | Seguridad / Confidencialidad | `docs/asii-24/week-03/src/Domain/Document.php` (método `isAllowedForRole`), `week-04/src/Domain/Document.php` |
| 2 | Acoplamiento rígido entre controladores web y el motor de base de datos SQL | Aplicación de Clean Architecture / Inversión de Dependencias (DIP) y Patrón Repositorio | Modificabilidad / Mantenibilidad | `docs/asii-24/week-02/02-solid-dependency-inversion.md`, `week-04/src/Application/Contracts/DocumentRepository.php` |
| 3 | Riesgo de inyección SQL y corrupción de datos documentales | Persistencia mediante PDO con sentencias estrictamente preparadas y parámetros tipados | Seguridad / Integridad | `docs/asii-24/week-03/src/Persistence/SQLiteDocumentRepository.php`, `week-04/src/Infrastructure/Repositories/PdoDocumentRepository.php` |
| 4 | Necesidad de pruebas unitarias rápidas y aisladas sin levantar base de datos | Creación de adaptador en memoria `InMemoryDocumentRepository` desacoplado de infraestructura | Testabilidad | `docs/asii-24/week-04/src/Infrastructure/Repositories/InMemoryDocumentRepository.php` |
| 5 | Ambigüedad en la comunicación entre módulos y equipos del hospital | Especificación canónica y formal bajo estándar OpenAPI 3.0.3 (contrato antes de código) | Interoperabilidad / Claridad | `docs/asii-24/week-05/contracts/openapi.yaml` |
| 6 | Verificación manual propensa a errores humanos en endpoints REST | Colección Postman v2.1 con assertions automatizadas en JavaScript para status codes y esquemas | Confiabilidad / Automatización | `docs/asii-24/week-05/postman/SHI-ASII24.postman_collection.json` |
| 7 | Riesgo de latencia y costo operativo excesivo por separación prematura de microservicios | ADR-001: Conservación temporal como módulo monolítico modular hasta alcanzar umbrales cuantitativos | Rendimiento / Eficiencia de Costos | `docs/asii-24/week-05/docs/ADR-001-cliente-servidor-y-microservicio.md` |
| 8 | Vulnerabilidad de cruce de datos entre diferentes sedes hospitalarias | Parámetro obligatorio de tenencia multi-hospital (`OwnerScope` y header `X-Tenant-ID`) | Seguridad / Aislamiento Multitenant | `docs/asii-24/week-04/src/Domain/OwnerScope.php`, `week-05/contracts/openapi.yaml` |
