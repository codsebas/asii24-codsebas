# ASII-24 - Semana 9: Evaluación del Diseño, Usabilidad y Accesibilidad

## Centro de Documentación y Manuales por Rol | Sistema Hospitalario Integrado 2026

- **Módulo:** ASII-24 — Contratos API: OpenAPI/Postman y documentación técnica
- **Adaptación:** Centro de documentación y manuales por rol
- **Estudiante:** Albino Sebastián Rosales Ruano (`codsebas`)
- **Semana:** 9 (Evaluación del diseño, usabilidad y accesibilidad)

---

## 1. Resumen Ejecutivo de la Auditoría

En esta entrega se realiza la auditoría formal de usabilidad y accesibilidad sobre las interfaces del **Centro de Documentación y Manuales por Rol** (desarrolladas en Semana 8), fundamentada en las **10 Heurísticas de Jakob Nielsen** y las pautas **WCAG 2.1 (Nivel AA)**.

Se priorizan los hallazgos y correcciones según su impacto directo en la especificación OpenAPI 3.0, colecciones Postman v2.1, endpoints REST, esquemas de error RFC 7807 y versionado documental SemVer.

### Entregables Incluidos
1. **Checklist de Usabilidad y WCAG (`docs/CHECKLIST_USABILIDAD_WCAG.md`):** Evaluación de las 10 heurísticas y 11 criterios WCAG 2.1 AA aplicados a las pantallas del módulo.
2. **Evidencia de 6 Hallazgos Críticos (`docs/HALLAZGOS_ACCESIBILIDAD.md`):** Documentación técnica detallada (Teclado, Foco, Contraste, Etiquetas/ARIA, Mensajes/Aria-Live y Prevención de errores).
3. **Backlog Priorizado MoSCoW (`docs/BACKLOG_PRIORIZADO.md`):** Matriz de tareas correctivas con esfuerzo, impacto en OpenAPI/Postman y criterios de aceptación verificables en formato Gherkin.
4. **Diagrama PlantUML (`docs/diagrams/source/accessibility-focus-flow.puml`):** Flujo de foco accesible por teclado y gestión de modales (Focus Trap).
5. **Suite de Validación Automatizada (`scripts/run-validation.php`):** Test suite en PHP que certifica la presencia de los 6 hallazgos, criterios WCAG y consistencia del backlog.

---

## 2. Matriz Resumen de Hallazgos

| ID | Dimensión UX/WCAG | Pantalla Afectada | Criterio Violado | Severidad | Prioridad MoSCoW |
| :--- | :--- | :--- | :--- | :---: | :---: |
| `HALL-01` | Teclado y Foco | Modal de Publicación (`WF-05`) | WCAG 2.1.2 / 2.4.3 | Alta | **Must Have** |
| `HALL-02` | Contraste Cromático | Badges HTTP (`WF-01`, `WF-04`) | WCAG 1.4.3 | Media | **Could Have** |
| `HALL-03` | Etiquetas y Semántica ARIA | Carga OpenAPI (`WF-02`) | WCAG 1.3.1 / 4.1.2 | Alta | **Should Have** |
| `HALL-04` | Mensajes y Regiones Vivas | Consola Sandbox (`WF-04`) | WCAG 4.1.3 | Media | **Should Have** |
| `HALL-05` | Prevención de Errores | Deprecación de API (`WF-02`, `WF-04`) | WCAG 3.3.4 | Crítica | **Must Have** |
| `HALL-06` | Recuperación RFC 7807 | Errores 422 (`WF-02`, `WF-05`) | WCAG 3.3.1 / 3.3.3 | Alta | **Must Have** |

---

## 3. Ejecución de Validaciones

```bash
php docs/asii-24/week-09/scripts/run-validation.php
```
