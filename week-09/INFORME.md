# Informe Técnico - Semana 9: Usabilidad y Accesibilidad WCAG

## 1. Metodología de Evaluación

La evaluación de usabilidad y accesibilidad para el **Centro de Documentación y Manuales por Rol** se llevó a cabo aplicando una metodología mixta:
1. **Inspección Heurística:** Análisis de las 10 heurísticas de Jakob Nielsen sobre las 5 pantallas (WF-01 a WF-05) diseñadas en la Semana 8.
2. **Evaluación de Accesibilidad WCAG 2.1 Nivel AA:** Verificación técnica de 6 dimensiones fundamentales: accesibilidad por teclado, orden y visibilidad del foco, ratios de contraste cromático, etiquetado semántico ARIA, regiones vivas para mensajes asíncronos y mecanismos de prevención de errores críticos.

---

## 2. Análisis Dimensional y Hallazgos Principales

### 2.1. Teclado y Foco (WCAG 2.1.1, 2.1.2, 2.4.7)
Se identificó que el modal de confirmación SemVer Major (`WF-05`) permitía que la navegación con `Tab` saliera del diálogo modal hacia el fondo inactivo (violación de WCAG 2.1.2 No Keyboard Trap inverso). Se formuló un patrón de trampa de foco accesible que retiene la navegación dentro del modal y asegura el retorno del foco al elemento detonador tras el cierre con tecla `Escape`.

### 2.2. Contraste Cromático (WCAG 1.4.3)
Los badges indicadores de métodos HTTP (ej. `GET` en azul claro `#61AFFE` sobre fondo blanco) registraban una relación de contraste de 3.2:1, incumpliendo el umbral mínimo de 4.5:1 para texto normal. Se prescribió una paleta ajustada con ratio 5.1:1.

### 2.3. Etiquetas y Semántica ARIA (WCAG 1.3.1, 4.1.2)
Los campos de carga de especificación OpenAPI y el selector de rol carecían de asociación explícita mediante `aria-describedby`, impidiendo que usuarios de lectores de pantalla conozcan de antemano los formatos admitidos (`.yaml`, `.json`) o las restricciones de versión.

### 2.4. Mensajes Asíncronos y Regiones Vivas (WCAG 4.1.3)
La consola interactiva del Sandbox API actualizaba los payloads de respuesta dinámicamente sin notificar a los lectores de pantalla. Se requirió la adición de `aria-live="polite"` y `aria-atomic="true"` en el contenedor de respuestas.

### 2.5. Prevención de Errores y Mapeo RFC 7807 (WCAG 3.3.1, 3.3.4)
Las acciones de deprecación de contratos y la conmutación entre entornos Sandbox y Producción carecían de confirmación irreversible explícita. Asimismo, los errores estructurados bajo el estándar RFC 7807 (`ProblemDetails`) se exponían sin vincular directamente el campo infractor en el DOM mediante `aria-invalid="true"` y `aria-errormessage`.

---

## 3. Impacto en OpenAPI, Postman y Consumo Intermodular

Las correcciones propuestas optimizan la interoperabilidad técnica y la seguridad hospitalaria:
- **Contratos OpenAPI 3.0:** Se estandarizan los esquemas de error 422 con punteros precisos (`pointer`), facilitando el enlace directo con los inputs de formulario accesibles.
- **Colecciones Postman v2.1:** Los tests de integración ahora validan la presencia de descripciones semánticas y mensajes de error orientados a personas.
- **Seguridad del Paciente:** Evita la ejecución accidental de peticiones destructivas en entornos de producción hospitalaria mediante confirmaciones estrictas por teclado.
