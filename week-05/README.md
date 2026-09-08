# ASII-24 — Semana 5: Cliente-Servidor, API REST, Microservicios e Integración

**Estudiante:** Albino Sebastián Rosales Ruano  
**GitHub:** [`codsebas`](https://github.com/codsebas)  
**Módulo Oficial:** Contratos API: OpenAPI/Postman y documentación técnica  
**Adaptación Académica:** Centro de documentación y manuales por rol  
**Repositorio Personal:** [`asii24-codsebas`](https://github.com/codsebas/asii24-codsebas)  

---

## 1. Propósito de la Entrega

Evolucionar el módulo **ASII-24** hacia un modelo formal **Cliente-Servidor**, especificando el contrato canónico de API bajo el estándar **OpenAPI 3.0**, la colección de pruebas en **Postman** (con scripts de verificación automatizada de códigos HTTP) y la evaluación razonada de una frontera de **microservicio** mediante un **Registro de Decisión Arquitectónica (ADR)** que analiza propiedad de datos, seguridad, resiliencia y observabilidad.

---

## 2. Estructura de Entregables

```text
week-05/
├── README.md                           # Guía general de la entrega
├── INFORME.md                          # Informe técnico formal académico
├── DECLARACION_IA.md                   # Declaración de asistencia con IA
├── DEFENSA_ORAL.md                     # Argumentación técnica para evaluación
├── contracts/                          # Contratos formales de interfaz
│   └── openapi.yaml                    # Especificación canónica OpenAPI 3.0.3
├── postman/                            # Colecciones y ambientes de prueba
│   ├── SHI-ASII24.postman_collection.json # Colección de pruebas de integración
│   └── SHI-ASII24.postman_environment.example.json # Plantilla de variables
├── docs/                               # Arquitectura y decisiones técnicas
│   ├── ADR-001-cliente-servidor-y-microservicio.md # Decisión de frontera
│   └── diagrams/source/
│       ├── client-server-boundary.puml # Arquitectura y clientes consumidores
│       ├── rest-security-sequence.puml # Secuencia Tenant y Bearer JWT
│       └── resilience-circuit.puml     # Resiliencia y contingencia local
└── scripts/
    └── run-tests.php                   # Suite automatizada de verificación
```

---

## 3. Contrato API y Colección Postman

### Contrato OpenAPI 3.0 (`contracts/openapi.yaml`):
* **Endpoints documentados:**
  - `POST /api/v1/api-contracts`: Publicación de versiones inmutables de contratos/documentos técnicos.
  - `GET /api/v1/api-contracts/{id}`: Recuperación de contrato autorizado.
* **Seguridad:** Bearer JWT (`bearerAuth`) y cabecera obligatoria de aislamiento multitenant (`X-Tenant-ID`).
* **Códigos HTTP cubiertos:** `201 Created`, `200 OK`, `400 Bad Request`, `401 Unauthorized`, `404 Not Found`, `409 Conflict`, `422 Unprocessable Entity`.

### Colección Postman (`postman/SHI-ASII24.postman_collection.json`):
* Incluye casos automatizados con tests en JavaScript para validar códigos de respuesta esperados.
* Utiliza variables de entorno (`baseUrl`, `tenantId`, `accessToken`, `contractId`) sin exponer credenciales ni tokens sensibles.

---

## 4. Instrucciones de Validación

### Ejecutar suite de pruebas de contratos:
```bash
php week-05/scripts/run-tests.php
```

Resultado verificado:
```text
=== ASII-24 Semana 5: Suite de Validacion de Contratos OpenAPI y Postman ===

--- 1. Validacion de Estructura de Contrato OpenAPI 3.0 ---
  [PASS] El archivo openapi.yaml existe y es legible
  [PASS] El contrato define version OpenAPI 3.0, titulo y paths clave
  [PASS] El contrato documenta todos los codigos HTTP obligatorios (200, 201, 400, 401, 404, 409, 422)

--- 2. Validacion de Coleccion y Ambiente Postman ---
  [PASS] La coleccion Postman es un JSON valido y contiene requests configuradas
  [PASS] El ambiente de Postman contiene variables parametrizadas y cero secretos reales

--- 3. Consistencia entre OpenAPI y Postman ---
  [PASS] Todas las operaciones requeridas de la coleccion Postman cubren el contrato OpenAPI

=======================================================
RESULTADOS FINALES: 6 superadas, 0 fallidas.
=======================================================
```
