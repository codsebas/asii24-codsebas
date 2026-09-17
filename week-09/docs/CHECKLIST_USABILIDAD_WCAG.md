# Checklist de Usabilidad y Accesibilidad WCAG 2.1 AA - ASII-24

Evaluación aplicada a las 5 pantallas del **Centro de Documentación y Manuales por Rol** (`WF-01` a `WF-05`).

---

## 1. Evaluación de las 10 Heurísticas de Jakob Nielsen

| # | Heurística de Nielsen | Evaluación en Pantallas | Estado | Observación / Hallazgo |
| :---: | :--- | :--- | :---: | :--- |
| **H1** | Visibilidad del estado del sistema | `WF-01`, `WF-02`, `WF-04` | **Parcial** | Falta `aria-live` en respuesta de Sandbox (`HALL-04`). |
| **H2** | Correspondencia sistema y mundo real | `WF-01`, `WF-03` | **Conforme** | Términos clínicos familiares para médicos y enfermeras. |
| **H3** | Control y libertad del usuario | `WF-02`, `WF-05` | **Parcial** | Sin soporte para cerrar modal con `Escape` (`HALL-01`). |
| **H4** | Consistencia y estándares | `WF-01` a `WF-05` | **Conforme** | Uso estándar de SemVer, HTTP codes y RFC 7807. |
| **H5** | Prevención de errores | `WF-02`, `WF-04` | **No Conforme**| Deprecación sin confirmación y riesgo de entorno (`HALL-05`). |
| **H6** | Reconocimiento antes que recuerdo | `WF-01`, `WF-04` | **Conforme** | Sugerencias de búsqueda y esquemas visuales DTO. |
| **H7** | Flexibilidad y eficiencia de uso | `WF-01`, `WF-03` | **Conforme** | Filtros rápidos por servicio y soporte offline. |
| **H8** | Diseño estético y minimalista | `WF-01` a `WF-05` | **Parcial** | Badges HTTP con bajo contraste en temas oscuros (`HALL-02`). |
| **H9** | Reconocer, diagnosticar y recuperarse | `WF-02`, `WF-05` | **Parcial** | Errores 422 sin enlace semántico al input (`HALL-06`). |
| **H10**| Ayuda y documentación | `WF-01`, `WF-03` | **Conforme** | Ayudas contextuales con glosario y tooltips. |

---

## 2. Evaluación de Criterios de Conformidad WCAG 2.1 Nivel AA

| Criterio WCAG | Nombre del Criterio | Nivel | Pantalla | Estado | Hallazgo Asociado |
| :--- | :--- | :---: | :--- | :---: | :--- |
| **1.3.1** | Información y Relaciones | A | `WF-02`, `WF-04` | **No Conforme** | `HALL-03` (Falta `aria-describedby` en inputs) |
| **1.4.3** | Contraste Mínimo (4.5:1) | AA | `WF-01`, `WF-04` | **No Conforme** | `HALL-02` (Badges HTTP con ratio 3.2:1) |
| **2.1.1** | Teclado Completo | A | `WF-01` a `WF-05` | **Conforme** | Todos los controles son alcanzables por Tab. |
| **2.1.2** | Sin Trampas de Foco | A | `WF-05` | **No Conforme** | `HALL-01` (Foco escapa del modal activo) |
| **2.4.3** | Orden del Foco | A | `WF-02`, `WF-05` | **Conforme** | Orden lógico secuencial respetado. |
| **2.4.7** | Foco Visible | AA | `WF-01` a `WF-05` | **Conforme** | Anillo de foco de 2px de alto contraste visible. |
| **3.3.1** | Identificación de Errores | A | `WF-02`, `WF-05` | **No Conforme** | `HALL-06` (Falta `aria-invalid` en inputs con error) |
| **3.3.3** | Sugerencias ante Errores | AA | `WF-02` | **Conforme** | Mensajes indican formato y reglas SemVer esperadas. |
| **3.3.4** | Prevención de Errores Críticos | AA | `WF-02`, `WF-04` | **No Conforme** | `HALL-05` (Deprecación de API sin barrera estricta) |
| **4.1.2** | Nombre, Función y Valor | A | `WF-01`, `WF-02` | **Conforme** | Botones e inputs con labels accesibles. |
| **4.1.3** | Mensajes de Estado | AA | `WF-04` | **No Conforme** | `HALL-04` (Falta `aria-live` en respuesta asíncrona) |
