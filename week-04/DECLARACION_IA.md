# Declaración de Uso de Inteligencia Artificial — ASII-24 Semana 4

**Estudiante:** Albino Sebastián Rosales Ruano  
**GitHub:** [`codsebas`](https://github.com/codsebas)  
**Módulo:** ASII-24 — Contratos API: OpenAPI/Postman y documentación técnica  
**Semana:** 4 — Arquitectura en capas y patrón repositorio  

---

## 1. Declaración de Transparencia

De conformidad con las directrices académicas del curso de Análisis de Sistemas II, se declara que se utilizó asistencia de modelos de lenguaje e inteligencia artificial durante la elaboración de los artefactos técnicos de la **Semana 4**.

## 2. Herramientas Utilizadas

* **Antigravity / Gemini 3.8 Flash (High)**: Asistente principal de análisis, estructuración de código y validación cruzada.

## 3. Propósito del Uso

* Asistencia en el diseño de los diagramas PlantUML para la vista de cuatro capas y el patrón Repository.
* Generación de la plantilla base de pruebas unitarias en PHP nativo para verificar los adaptadores `InMemory` y `PDO`.
* Revisión de sintaxis y verificación de cumplimiento de principios Clean Architecture y SOLID (Dependency Inversion).

## 4. Partes Aceptadas, Modificadas o Rechazadas

* **Aceptado:** Estructura modular de capas (`Domain`, `Application`, `Infrastructure`, `Presentation`), respetando el principio de que el controlador no contenga SQL ni lógica de negocio.
* **Modificado:** Se ajustó la firma del adaptador PDO para utilizar sentencias preparadas explícitas sobre SQLite/PostgreSQL y asegurar la gestión de transacciones en inserciones relacionales múltiples (`documents` y `document_roles`).
* **Rechazado:** Se rechazó cualquier propuesta de acoplar el código de Semana 4 a un ORM o framework pesado en el repositorio educativo personal, preservando código PHP 8.2 puro y de fácil portabilidad.

## 5. Validación Humana

Todo el código fuente, esquemas SQL, scripts de inicialización y diagramas PlantUML fueron probados, depurados y verificados localmente por el estudiante antes de su incorporación definitiva al repositorio. El estudiante asume la responsabilidad total sobre el contenido presentado.
