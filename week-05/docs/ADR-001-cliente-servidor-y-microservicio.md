# ADR-001: Evolución a Arquitectura Cliente-Servidor y Evaluación de Frontera de Microservicio

## Estado
Aceptado

## Contexto
El módulo oficial **ASII-24 (Contratos API: OpenAPI/Postman y documentación técnica)**, adaptado para el **Centro de documentación y manuales por rol**, opera dentro del ecosistema del Sistema Hospitalario Integrado (SHI).

En las semanas 3 y 4 se estructuró la solución como un monolito modular con arquitectura en capas y patrón Repository. Para la **Semana 5**, el requerimiento exige evolucionar hacia un diseño **Cliente-Servidor**, formalizar los contratos API bajo el estándar OpenAPI 3.0, acompañar la entrega con colecciones Postman automatizadas y evaluar rigurosamente si el módulo justifica convertirse en un **microservicio autónomo independiente**.

## Decisión Arquitectónica

### 1. Modelo Cliente-Servidor Desacoplado
Se separa la interfaz de consumo (clientes web, aplicaciones móviles, sistemas externos del hospital) del servicio de procesamiento documental.
* **Protocolo:** HTTP/1.1 y HTTP/2 sobre TLS/HTTPS.
* **Formato de intercambio:** JSON UTF-8 conforme al estándar RFC 8259.
* **Contrato Rector:** OpenAPI 3.0.3 ([`contracts/openapi.yaml`](../contracts/openapi.yaml)) como fuente única de verdad para endpoints, esquemas de entrada/salida, códigos de respuesta y ejemplos.
* **Verificación:** Colección de Postman ([`postman/SHI-ASII24.postman_collection.json`](../postman/SHI-ASII24.postman_collection.json)) que automatiza pruebas de integración contra los endpoints.

### 2. Evaluación de Frontera de Microservicio
Se analizó la conveniencia de extraer el módulo como un microservicio independiente con base de datos propia frente a mantenerlo como componente de un monolito modular:

| Criterio | Microservicio Independiente | Monolito Modular (Elegido) | Justificación de la Decisión |
| :--- | :--- | :--- | :--- |
| **Volumen de Tráfico** | Bajo/Medio (lectura esporádica de manuales y contratos). | Óptimo para el tamaño del HIS. | No existe saturación que requiera auto-escalado horizontal independiente. |
| **Complejidad Operativa** | Alta (despliegue de pipelines, service mesh, gateways, monitoreo distribuido). | Baja (despliegue atómico, CI/CD simplificado). | La infraestructura académica y del hospital no justifica la sobrecarga operativa. |
| **Consistencia de Datos** | Eventual (Sagas, Outbox, CDC). | Fuerte / ACID local. | Permite integridad transaccional inmediata entre documentos y roles. |
| **Propiedad de Datos** | Exclusiva del servicio. | Esquema delimitado (`api_contracts`, `documents`). | Se mantiene el desacoplamiento lógico sin duplicar servidores de base de datos. |

**Conclusión:** Se adopta un diseño **Monolito Modular con Frontera Lógica Limpia**:
* El módulo expone endpoints REST puros desacoplados.
* Si el tráfico o la necesidad institucional exige en el futuro extraer el módulo a un microservicio físico en un contenedor Docker independiente, la capa de dominio y aplicación no requerirá ningún cambio debido al patrón Repository y Clean Architecture implementados.

### 3. Seguridad y Control de Acceso
* **Autenticación:** Tokens Bearer JWT en el encabezado `Authorization: Bearer <token>`.
* **Aislamiento Multitenant:** Encabezado obligatorio `X-Tenant-ID`. Las peticiones sin este encabezado son rechazadas con HTTP `400 Bad Request`. Peticiones no autenticadas retornan HTTP `401 Unauthorized`.
* **Autorización por Rol (RBAC):** La consulta de manuales valida que el rol activo del usuario coincida con los `authorized_roles` del documento (o sea `Admin`).

### 4. Resiliencia y Observabilidad
* **Idempotencia:** La publicación de contratos calcula un checksum SHA-256 inmutable. Intentos de duplicación generan HTTP `409 Conflict`.
* **Tolerancia a Fallos:** En caso de caída de la red central, los clientes en hospitales locales utilizan copias en caché o réplicas locales para acceder a manuales de contingencia.
* **Observabilidad:** Códigos de estado HTTP estandarizados (`200`, `201`, `400`, `401`, `403`, `404`, `409`, `422`).

## Consecuencias
* Se dispone de una API REST profesional, verificable e integrable mediante herramientas estándar de la industria (Swagger UI, Postman, Newman).
* Cero riesgo de fragmentación prematura de infraestructura.
* Trazabilidad total de requisitos mediante el contrato formal OpenAPI.
