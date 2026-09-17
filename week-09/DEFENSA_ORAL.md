# Defensa Oral - Semana 9: Usabilidad y Accesibilidad WCAG

## 1. Priorización de Accesibilidad en Software Hospitalario

**Pregunta del Tribunal:** ¿Por qué se clasificaron como `Must Have` los hallazgos de teclado y prevención de errores por encima del ajuste visual de contraste?

**Defensa Técnica:**
En un entorno clínico, la inaccesibilidad por teclado o la ambigüedad en la prevención de errores representan un riesgo operacional directo para el hospital. Si un usuario que opera mediante tecnologías de asistencia queda atrapado en un modal sin poder usar `Escape` (HALL-01), o si un administrador deprecia un contrato de API en producción sin una confirmación explícita (HALL-05), se interrumpe la interoperabilidad de módulos críticos como Signos Vitales o Prescripciones. Por ende, los criterios de prevención de fallas operativas y operabilidad básica tienen prioridad absoluta sobre los ajustes estéticos de contraste, los cuales se abordaron como `Could Have`.

---

## 2. Articulación entre RFC 7807 y Criterios WCAG

**Pregunta del Tribunal:** ¿Cómo se complementan el estándar técnico RFC 7807 y las pautas WCAG 3.3.1 y 3.3.3?

**Defensa Técnica:**
El estándar RFC 7807 provee la estructura serializable en backend (`type`, `title`, `status`, `detail`, `invalid-params`). Sin embargo, a nivel de frontend, un volcado JSON crudo incumple la pauta WCAG 3.3.1 (Identificación de Errores) y WCAG 3.3.3 (Sugerencia ante Errores).

La solución técnica diseñada toma los campos de `invalid-params` del JSON RFC 7807 y los enlaza en el DOM asociando `aria-invalid="true"` al campo infractor e insertando un contenedor de mensaje con `id` correspondiente referenciado por `aria-errormessage`. De este modo, los lectores de pantalla leen inmediatamente la causa del fallo y la acción de recuperación requerida.

---

## 3. Verificabilidad de las Correcciones del Backlog

**Pregunta del Tribunal:** ¿De qué manera se garantiza que una corrección de accesibilidad sea verificable y no quede como una declaración de intenciones?

**Defensa Técnica:**
Cada ítem del backlog priorizado cuenta con criterios de aceptación formulados en sintaxis formal Gherkin (`Dado / Cuando / Entonces`). Esto permite automatizar la verificación mediante herramientas de testing end-to-end (Playwright/Cypress con Axe-Core) y validaciones de teclado en CI/CD, garantizando que el criterio se cumpla antes del despliegue.
