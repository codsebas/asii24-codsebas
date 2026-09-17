# ASII-24 - Semana 8: Diseño de Experiencia de Usuario (UX)

## Centro de Documentación y Manuales por Rol | Sistema Hospitalario Integrado 2026

- **Módulo:** ASII-24 — Contratos API: OpenAPI/Postman y documentación técnica
- **Adaptación:** Centro de documentación y manuales por rol
- **Estudiante:** Albino Sebastián Rosales Ruano (`codsebas`)
- **Semana:** 8 (Diseño de experiencia de usuario)

---

## 1. Resumen Ejecutivo y Alcance

En esta entrega se diseña la experiencia de usuario (UX) integral para la **publicación y consulta de documentación y manuales diferenciados por rol**. El diseño desacopla la consulta técnica (contratos OpenAPI 3.0 y colecciones Postman v2.1) de la consulta clínica asistencial (manuales y guías operativas) y la gobernanza administrativa de publicaciones.

### Entregables Incluidos
1. **User Flows por Rol (`docs/USER_FLOW_ROLES.md`):** Flujos de interacción detallados para Administrador/Publisher, Personal Clínico (Médicos y Enfermería) y Desarrolladores/Auditores de integración.
2. **Wireframes Anotados (`docs/WIREFRAMES_ANOTADOS.md`):** 5 pantallas con ciclo completo de estados (`INITIAL`, `LOADING`, `EMPTY`, `SUCCESS`, `RECOVERABLE_ERROR`), micro-copy, ayuda contextual y reglas de interacción.
3. **Modelos de Diagramas PlantUML (`docs/diagrams/source/`):**
   - `ux-user-flow.puml`: Diagrama de actividades con bifurcaciones de decisión y confirmación por rol.
   - `wireframes-navigation.puml`: Mapa de navegación y transiciones de estados UI.
4. **Validación Automatizada (`scripts/run-validation.php`):** Suite CLI en PHP que valida cobertura de roles, estados UX obligatorios, protección de datos y consistencia OpenAPI.

---

## 2. Matriz de Roles y Experiencia Diferenciada

| Rol | Enfoque UX Principal | Componentes Clave | Protección de Datos |
| :--- | :--- | :--- | :--- |
| **Administrador / API Publisher** | Publicación, validación y versionado | Validador OpenAPI, selector SemVer, modal de confirmación | Logs de auditoría sin secrets |
| **Médico / Especialista** | Consulta rápida de guías operativas | Buscador contextual, filtros por servicio, lectura offline | Sin exposición de endpoints crudos |
| **Enfermería** | Protocolos clínicos y flujo de turnos | Fichas paso a paso, checklist de procedimientos | Datos operativos sintéticos |
| **Auditor / Desarrollador Integrador** | Consumo de APIs y depuración | Consola Swagger/OpenAPI, snippets Postman, sandbox RFC 7807 | Enmascaramiento de tokens y PII |

---

## 3. Matriz de Estados de Interfaz

- **Estado Inicial (`INITIAL`):** Interfaz limpia con accesos directos y sugerencias según rol autenticado.
- **Estado de Carga (`LOADING`):** Skeleton screens accesibles que reducen la percepción de latencia sin saltos de layout.
- **Estado Vacío (`EMPTY`):** Pantalla guiada con sugerencias de búsqueda y botón de solicitud de documentación.
- **Estado Éxito (`SUCCESS`):** Renderizado de contenido, toasts no invasivos y confirmación visual.
- **Estado Error Recuperable (`RECOVERABLE_ERROR`):** Diagnóstico mapeado con RFC 7807 (ProblemDetails), preservación del formulario y botón de reintento inmediato.

---

## 4. Ejecución de Validaciones

```bash
php docs/asii-24/week-08/scripts/run-validation.php
```
