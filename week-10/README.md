# ASII-24 - Semana 10: Diseño para Movilidad

## Centro de Documentación y Manuales por Rol | Sistema Hospitalario Integrado 2026

- **Módulo:** ASII-24 — Contratos API: OpenAPI/Postman y documentación técnica
- **Adaptación:** Centro de documentación y manuales por rol
- **Estudiante:** Albino Sebastián Rosales Ruano (`codsebas`)
- **Semana:** 10 (Diseño para movilidad en sistemas hospitalarios)

---

## 1. Resumen Ejecutivo de Movilidad

En esta entrega se adapta el **Centro de Documentación y Manuales por Rol** a dispositivos móviles compactos (**viewport de 320 a 430 px**), optimizando la ergonomía táctil para personal asistencial (médicos y enfermería con guías clínicas) y personal técnico de guardia (auditores y desarrolladores con contratos OpenAPI 3.0 y Postman).

Se definen patrones de diseño táctil con zonas de toque (*Touch Targets*) de al menos **$48 \times 48\text{ px}$**, navegación fija inferior (*Bottom Navigation Bar*), reemplazo de tablas densas por tarjetas colapsables (*Data Cards*) y resiliencia ante conectividad hospitalaria degradada mediante almacenamiento en caché local offline.

### Entregables Incluidos
1. **Reglas de Breakpoints (`docs/RESPONSIVE_BREAKPOINTS_SPEC.md`):** Matriz adaptativa desde 320 px hasta pantallas de escritorio, jerarquía tipográfica y zonas táctiles.
2. **Propuesta de 4 Pantallas Móviles Anotadas (`docs/PANTALLAS_MOVILES_ANOTADAS.md`):** Especificaciones de interfaz para viewport 320–430 px con micro-copys y estados.
3. **Dos Escenarios Móviles con Decisiones de Contenido y Error (`docs/ESCENARIOS_MOVILES_DECISIONES.md`):**
   - Escenario 1: Médico consultando protocolo en aislamiento con pérdida de Wi-Fi (Caché local).
   - Escenario 2: Desarrollador *on-call* ejecutando pruebas en Sandbox con timeout de red y RFC 7807.
4. **Diagrama PlantUML (`docs/diagrams/source/mobile-navigation-flow.puml`):** Navegación móvil y ciclo de conectividad.
5. **Suite de Validación Automatizada (`scripts/run-validation.php`):** Test suite en PHP que certifica pantallas, breakpoints, escenarios y reglas táctiles.

---

## 2. Matriz de Breakpoints del Sistema

| Breakpoint | Rango (px) | Dispositivos Clave | Estrategia de Layout |
| :--- | :---: | :--- | :--- |
| **Mobile Compact** | **320 – 430** | Smartphones hospitalarios (iPhone SE, Galaxy A) | 1 columna, Bottom Navigation, Data Cards, touch targets $\ge 48\text{px}$ |
| **Mobile Large / Tablet** | 431 – 767 | Dispositivos de mano grandes / Phablets | 1-2 columnas fluidas, tarjetas apiladas |
| **Tablet Clinical** | 768 – 1023 | iPads y terminales móviles en carros de curación | 2 columnas (Split view: lista y detalle de manual) |
| **Desktop Station** | 1024+ | Estaciones fijas de enfermería y consultorios | 3 columnas, sidebar expandida y consola API completa |

---

## 3. Ejecución de Validaciones

```bash
php docs/asii-24/week-10/scripts/run-validation.php
```
