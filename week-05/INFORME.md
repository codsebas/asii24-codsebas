# Informe Técnico — ASII-24 Semana 5: Cliente-Servidor, API REST y Evaluación de Microservicio

## 1. Portada y Datos Generales

* **Institución:** Universidad Mariano Gálvez de Guatemala
* **Facultad:** Ingeniería en Sistemas de Información y Ciencias de la Computación
* **Curso:** Análisis de Sistemas II
* **Ciclo:** Octavo Ciclo
* **Estudiante:** Albino Sebastián Rosales Ruano
* **Carné / Usuario:** `codsebas`
* **Módulo Asignado:** ASII-24 — Contratos API: OpenAPI/Postman y documentación técnica
* **Adaptación Académica:** Centro de documentación y manuales por rol
* **Repositorio Oficial:** `https://github.com/codsebas/asii24-codsebas.git`
* **Ruta de Evidencia:** `week-05/`

---

## 2. Índice

1. Portada y Datos Generales
2. Índice
3. Introducción y Contexto
4. Objetivos Técnicos
5. Evolución a Arquitectura Cliente-Servidor
6. Especificación del Contrato API (OpenAPI 3.0.3)
7. Colección de Verificación en Postman y Ambientes
8. Evaluación de Frontera de Microservicio (ADR-001)
9. Propiedad de Datos, Comunicación y Consistencia
10. Seguridad: Aislamiento Tenant y Autenticación JWT
11. Resiliencia, Observabilidad y Manejo de Fallos Parciales
12. Plan Operativo: Issue, Rama, Worktree y Pull Request
13. Diagramas de Arquitectura y Secuencia
14. Validación Automatizada de Contratos
15. Declaración de Uso de Inteligencia Artificial
16. Conclusiones
17. Bibliografía

---

## 3. Introducción y Contexto

En el marco del Sistema Hospitalario Integrado (SHI), la estandarización de contratos de integración entre módulos y subsistemas es un pilar crítico para evitar acoplamientos rígidos. 

La **Semana 5** formaliza la exposición de capacidades bajo el paradigma **Cliente-Servidor**, estableciendo un contrato de interfaz canónico mediante **OpenAPI 3.0**, un conjunto de pruebas ejecutables en **Postman** y un análisis exhaustivo sobre la frontera de **microservicio**, sopesando las ventajas de autonomía frente al costo operativo de la fragmentación distribuida.

---

## 4. Objetivos Técnicos

* Definir la especificación OpenAPI 3.0.3 completa para la publicación y consulta de contratos técnicos y manuales por rol.
* Elaborar una colección Postman parametrizada con tests automatizados para validar los códigos HTTP `200`, `201`, `400`, `401`, `404`, `409` y `422`.
* Realizar un Registro de Decisión Arquitectónica (ADR) para evaluar si el módulo debe desacoplarse como microservicio autónomo o mantenerse como componente en un monolito modular.
* Definir los mecanismos de seguridad basados en cabeceras multitenant obligatorias (`X-Tenant-ID`) y autenticación Bearer JWT.
* Detallar el plan formal de Git: gestión de issue, rama, worktree y pull request.

---

## 5. Evolución a Arquitectura Cliente-Servidor

El módulo pasa de un consumo puramente interno a una interfaz de red cliente-servidor abierta y estandarizada:
* **Clientes heterogéneos:** El contrato permite el consumo transparente desde clientes web hospitalarios (SPA en Vue/React o Blade), dispositivos móviles de enfermería/médicos (Android/iOS) y plataformas externas de auditoría.
* **Sin estado (Stateless):** Cada solicitud HTTP transporta toda la información necesaria para su procesamiento (contexto de tenant y token JWT), facilitando balanceo de carga y tolerancia a fallos.

---

## 6. Especificación del Contrato API (OpenAPI 3.0.3)

El contrato se encuentra formalizado en [`contracts/openapi.yaml`](contracts/openapi.yaml) y cumple con las siguientes directrices:
* **Endpoints y Métodos:**
  - `POST /api/v1/api-contracts`: Registro e indexación de un contrato API / manual técnico.
  - `GET /api/v1/api-contracts/{id}`: Recuperación del contrato por UUID.
* **Esquemas Reutilizables:**
  - `ApiContractPublishRequest`: Define campos requeridos (`id`, `module_code`, `version`, `owner_scope`, `specification`).
  - `ApiContractResponse`: Estructura normalizada de respuesta con `data` envuelta, estatus de publicación y checksum SHA-256.
  - `ErrorResponse`: Formato uniforme de errores con código y mensaje descriptivo.

---

## 7. Colección de Verificación en Postman y Ambientes

En [`postman/`](postman/) se disponen los artefactos de prueba:
* **Colección (`SHI-ASII24.postman_collection.json`):**
  - Caso 1: Publicación exitosa de contrato (aserta `201` y extrae `contractId` dinámicamente).
  - Caso 2: Petición con payload inválido (aserta `422`).
  - Caso 3: Petición sin cabecera de Tenant (aserta `400`).
  - Caso 4: Petición no autenticada sin token Bearer (aserta `401`).
  - Caso 5: Publicación de versión duplicada (aserta `409`).
  - Caso 6: Consulta exitosa de contrato (aserta `200`).
  - Caso 7: Consulta de contrato inexistente (aserta `404`).
* **Ambiente (`SHI-ASII24.postman_environment.example.json`):**
  - Plantilla segura con placeholders `{{baseUrl}}`, `{{tenantId}}`, `{{accessToken}}` y `{{contractId}}`, **garantizando la ausencia total de credenciales reales o secretos**.

---

## 8. Evaluación de Frontera de Microservicio (ADR-001)

Mediante el documento formal [`docs/ADR-001-cliente-servidor-y-microservicio.md`](docs/ADR-001-cliente-servidor-y-microservicio.md), se concluye:
* **Decisión:** Mantener el módulo como un **Monolito Modular con Frontera Lógica Limpia** dentro de la aplicación principal, en lugar de desplegar un contenedor/servicio físico separado.
* **Justificación:** El volumen de transacciones de lectura/escritura documental no justifica la complejidad de transacciones distribuidas (Sagas), latencia de red adicional ni sobrecarga de infraestructura en el entorno hospitalario actual.
* **Preparación para Migración Futura:** Gracias a la separación estricta en capas (Domain, Application, Infrastructure), si en el futuro se decide extraer este módulo como un microservicio independiente en Docker/Kubernetes, la lógica de negocio y las pruebas se conservarán al 100%.

---

## 9. Seguridad, Resiliencia y Observabilidad

1. **Aislamiento Multitenant:** Obligatoriedad de la cabecera `X-Tenant-ID`. Evita la fuga de información clínica o manuales entre diferentes instituciones o sedes del hospital.
2. **Autenticación Bearer JWT:** Verificación de firma y tiempo de expiración en cada solicitud.
3. **Resiliencia ante Fallas de Red:** Los clientes locales hospitalarios cuentan con mecanismos de almacenamiento en caché para mantener disponibles los manuales de contingencia médica en caso de pérdida de conexión con el nodo central.
4. **Inmutabilidad y Checksum:** Los contratos publicados generan un hash criptográfico SHA-256 inmutable que previene modificaciones accidentales o no autorizadas de versiones previamente aprobadas.

---

## 10. Plan Operativo: Issue, Rama, Worktree y Pull Request

Para garantizar cumplimiento con la metodología del proyecto y buenas prácticas de ingeniería:

* **Issue Vinculado:** Issue `#24` (`Refs #24` o `Closes #24`).
* **Rama de Trabajo:** `feat/mod24-contratos-api`.
* **Metodología Worktree:**
  ```bash
  git worktree add ../shi-mod24-contratos-api feat/mod24-contratos-api
  ```
* **Estrategia de Commits:** Commits semánticos y atómicos por fase (`docs`, `feat`, `test`).
* **Pull Request:**
  - Rama base: `develop` (o `main` según política de la cátedra).
  - Rama origen: `feat/mod24-contratos-api`.
  - Verificaciones previas: `git diff --check`, pruebas unitarias y de integración pasando al 100%.

---

## 11. Diagramas de Arquitectura y Secuencia

Disponibles en `docs/diagrams/source/`:
* `client-server-boundary.puml`: Vista general de los clientes consumidores, Gateway y frontera lógica del módulo.
* `rest-security-sequence.puml`: Flujo secuencial de validación de Tenant y token JWT, con tratamiento de errores 400 y 401.
* `resilience-circuit.puml`: Manejo de contingencia y consulta en caché ante desconexión de red WAN.

---

## 12. Resultados de la Suite Automatizada de Validación

Se ejecutó el script `php week-05/scripts/run-tests.php`:

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

---

## 13. Declaración de Uso de Inteligencia Artificial

Ver detalles en [`week-05/DECLARACION_IA.md`](DECLARACION_IA.md).

---

## 14. Conclusiones

1. La formalización del contrato OpenAPI 3.0 garantiza una integración desacoplada, predecible y estandarizada entre clientes y el servicio de contratos técnicos.
2. La colección Postman automatizada provee una herramienta de verificación continua para asegurar que la implementación respeta fielmente el contrato en casos felices y excepcionales.
3. El ADR-001 proporciona una justificación técnica fundamentada para preservar el monolito modular, evitando la sobreingeniería de microservicios sin renunciar a la modularidad limpia.

---

## 15. Bibliografía

* OpenAPI Initiative. (2024). *OpenAPI Specification v3.0.3*. https://spec.openapis.org/oas/v3.0.3
* Newman, S. (2021). *Building Microservices: Designing Fine-Grained Systems* (2nd ed.). O'Reilly Media.
* Postman Inc. (2024). *Postman Collection Format v2.1.0*. https://schema.postman.com/
* Fielding, R. T. (2000). *Architectural Styles and the Design of Network-based Software Architectures* (Doctoral dissertation). University of California, Irvine.
