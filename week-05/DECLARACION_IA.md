# Declaración de Uso de Inteligencia Artificial — ASII-24 Semana 5

**Estudiante:** Albino Sebastián Rosales Ruano  
**GitHub:** [`codsebas`](https://github.com/codsebas)  
**Módulo:** ASII-24 — Contratos API: OpenAPI/Postman y documentación técnica  
**Semana:** 5 — Cliente-servidor, API REST, microservicios e integración  

---

## 1. Declaración de Transparencia

De conformidad con las normas éticas y académicas de la Facultad de Ingeniería en Sistemas, se hace constar que se empleó asistencia de inteligencia artificial durante el desarrollo de los artefactos técnicos correspondientes a la **Semana 5**.

## 2. Herramientas Utilizadas

* **Antigravity / Gemini 3.8 Flash (High)**: Asistente para estructuración de especificaciones OpenAPI 3.0, armado de colecciones Postman y redacción técnica de decisiones de arquitectura.

## 3. Propósito del Uso

* Asistencia en la validación sintáctica del documento `openapi.yaml` y correspondencia de esquemas.
* Generación de la plantilla de pruebas automatizadas en JavaScript para los eventos de test de Postman.
* Estructuración del Registro de Decisión Arquitectónica (ADR-001) para evaluar de forma crítica la frontera de microservicios frente a monolitos modulares.

## 4. Partes Aceptadas, Modificadas o Rechazadas

* **Aceptado:** Estructura del contrato OpenAPI 3.0 con definición rigurosa de parámetros de seguridad (`bearerAuth`, `X-Tenant-ID`) y esquemas de respuesta estandarizados.
* **Modificado:** Se ajustaron los scripts de Postman para asegurar que las variables de entorno `contractId` se capturen dinámicamente en tiempo de ejecución sin requerir datos hardcodeados.
* **Rechazado:** Se descartó implementar despliegues complejos en contenedores o infraestructura distribuida real, acatando la directriz explícita de la consigna de Odoo de entregar diseño, prototipo y justificación razonada sin crear deuda técnica de infraestructura.

## 5. Validación Humana

El estudiante revisó, depuró y validó cada uno de los archivos YAML, JSON, PlantUML y de documentación, comprobando la ausencia de credenciales privadas y garantizando la coherencia técnica exigida por el curso.
