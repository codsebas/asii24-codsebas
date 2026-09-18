# Defensa Oral - Semana 11: Prototipo Navegable Móvil/Web

## 1. Justificación del Prototipo Autónomo en Vanilla Web

**Pregunta del Tribunal:** ¿Por qué optar por un prototipo autónomo en Vanilla JS/CSS en lugar de emplear frameworks pesados como React, Vue o Angular?

**Defensa Técnica:**
En auditorías de sistemas hospitalarios e interoperabilidad técnica, la inmediatez y la independencia tecnológica son esenciales. Un prototipo basado en estándares web puros (HTML5/CSS3/ES6+) se ejecuta instantáneamente en cualquier navegador hospitalario, terminal móvil o kiosco sin requerir un pipeline de compilación (`node_modules`, webpack, vite). Esto permite que evaluadores, comités médicos y auditores verifiquen el comportamiento exacto de los contratos OpenAPI y las pautas WCAG 2.1 AA de forma transparente, auditable y con cero sobrecarga de red.

---

## 2. Gestión de Errores RFC 7807 en la Experiencia del Usuario

**Pregunta del Tribunal:** ¿Cómo demuestra el prototipo que los errores técnicos del backend no degradan la experiencia médica ni operativa?

**Defensa Técnica:**
El prototipo demuestra que los errores bajo el estándar RFC 7807 (*Problem Details*) se traducen automáticamente en acciones humanas comprensibles. En lugar de alertar con un código HTTP 422 genérico o colapsar la aplicación, la interfaz descompone el arreglo `invalid_params`, señala con borde rojo y `aria-invalid="true"` el input específico, anuncia el fallo en lectores de pantalla vía `aria-live="assertive"` y mantiene todos los datos ingresados en pantalla, permitiendo al usuario corregir la falla en segundos.

---

## 3. Adaptabilidad Táctil y Ergonomía en Urgencias

**Pregunta del Tribunal:** ¿Qué elementos del prototipo demuestran cumplimiento de diseño móvil para entornos de salud?

**Defensa Técnica:**
Al inspeccionar el prototipo en resolución móvil (320–430 px), el menú superior se transforma en una Bottom Bar fija, accesible con el pulgar. Los botones principales tienen una altura mínima de 48px, los badges de métodos HTTP mantienen un ratio de contraste certificado $\ge 4.5:1$ y los diálogos modales emergen como Bottom Sheets, evitando que el personal deba operar el dispositivo con ambas manos en áreas estériles.
