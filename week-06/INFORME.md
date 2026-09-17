# Informe Técnico y Presentación Ejecutiva (Primer Parcial ASII)

**Estudiante:** Albino Sebastián Rosales Ruano
**GitHub:** [`codsebas`](https://github.com/codsebas)
**Módulo Oficial:** Contratos API: OpenAPI/Postman y documentación técnica
**Adaptación Académica:** Centro de documentación y manuales por rol

---

## Diapositiva 1: Portada y Delimitación del Sistema
* **Sistema:** Sistema Hospitalario Integrado (SHI) — Módulo ASII-24.
* **Propósito:** Centralizar, versionar y gobernar la documentación técnica, guías clínicas y manuales operativos asegurando acceso restringido y diferenciado por rol hospitalario.
* **Alcance delimitado:** Publicación y consulta autorizada con separación de tenencia multitenant (`CENTRAL` vs `HOSPITAL`).

---

## Diapositiva 2: Modelado de Negocio y Actores (Semana 1)
* **Actores Principales:** `Admin` (gestor y publicador de contratos/manuales).
* **Actores Consumidores:** `Médico`, `Enfermera`, `TecnicoLab`, `Recepcionista`.
* **Casos de Uso Nucleares:** Catálogo de 10 casos de uso (`UC-01` a `UC-10`), destacando la publicación autorizada, listado por rol y consulta detallada con denegación explícita.
* **Artefactos Base:** Diagramas UML de casos de uso, actividad con bifurcaciones y secuencia de interacción.

---

## Diapositiva 3: Requisitos y Principios SOLID (Semana 2)
* **Requisitos:** 10 Requisitos Funcionales (`RF-01` a `RF-10`) y 8 No Funcionales (`RNF-01` a `RNF-08`) bajo formato `Dado / Cuando / Entonces`.
* **Principio SOLID Aplicado:** **Dependency Inversion Principle (DIP)**.
* **Impacto:** Los módulos de alto nivel (reglas de acceso y publicación) no dependen de detalles de infraestructura (almacenamiento de archivos o bases de datos específicas); ambos dependen de abstracciones estables.

---

## Diapositiva 4: Arquitectura en 4 Capas (Semana 3)
* **Estructura Desacoplada:**
  - `Presentation`: Punto de entrada HTTP y serialización JSON.
  - `Application`: Orquestación de casos de uso sin reglas de negocio embebidas.
  - `Domain`: Entidad `Document` con invariantes de negocio estrictas.
  - `Persistence`: Almacenamiento desacoplado con PDO y SQLite.
* **Cero Frameworks:** Implementación inicial en PHP 8.2+ vanilla para garantizar pureza arquitectónica y máxima portabilidad pedagógica.

---

## Diapositiva 5: Patrón Repository y Controladores Delgados (Semana 4)
* **Patrón Repository:** Contrato abstracto `DocumentRepository` en la capa de aplicación.
* **Adaptadores:**
  - `InMemoryDocumentRepository` para pruebas unitarias instantáneas y confiables.
  - `PdoDocumentRepository` para persistencia relacional con sentencias preparadas contra inyección SQL.
* **Controlador Delgado (Thin Controller):** `DocumentController` procesa solicitudes y delega el 100% de la lógica a los casos de uso, retornando códigos HTTP estandarizados (`201`, `200`, `403`, `404`, `409`, `422`).

---

## Diapositiva 6: Interfaz Cliente-Servidor y Contratos Formales (Semana 5)
* **OpenAPI 3.0.3 Canónico:** Contrato declarativo inmutable (`contracts/openapi.yaml`) que define esquemas, parámetros y respuestas antes de la codificación.
* **Seguridad:** Autenticación mediante tokens Bearer JWT y cabecera de aislamiento `X-Tenant-ID`.
* **Automatización:** Suite de pruebas en Postman v2.1 con assertions programáticas en JavaScript para certificar cumplimiento de contratos en pipelines CI/CD.

---

## Diapositiva 7: Evaluación de Frontera de Microservicio (ADR-001)
* **Decisión:** Mantener el módulo como componente desacoplado dentro del **Monolito Modular** del HIS.
* **Justificación:** El volumen de peticiones actual no justifica el costo operativo de latencia de red, consistencia eventual y orquestación de clúster distribuido.
* **Criterios de Transición:** Se definieron umbrales cuantitativos (>1,000 req/s o bases de datos independientes) para ejecutar una extracción física futura sin rehacer código.

---

## Diapositiva 8: Trazabilidad Extremo a Extremo y Cambio Práctico
* **Trazabilidad:** Coherencia total desde la necesidad clínica del actor hasta el esquema OpenAPI y la tabla de base de datos.
* **Resiliencia ante el Cambio:** Incorporación exitosa de estados de ciclo de vida (`DRAFT`, `PUBLISHED`, `DEPRECATED`) y soporte para el rol `AuditorExterno` sin romper la compatibilidad hacia atrás ni requerir refactorizaciones estructurales.
