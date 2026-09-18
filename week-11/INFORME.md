# Informe Técnico - Semana 11: Prototipo Navegable Móvil/Web

## 1. Arquitectura de Presentación del Prototipo

Para garantizar máxima portabilidad en terminales médicas y dispositivos de guardia sin riesgo de fallas por dependencias externas, se implementó una arquitectura de **Single-File SPA (Single Page Application)** basada en Vanilla JavaScript y CSS3 moderno:
- **Gestión de Estado Reactiva:** Un almacén de estado ligero gestiona el rol activo (`ROLE_MEDICO`, `ROLE_ENFERMERA`, `ROLE_AUDITOR`, `ROLE_ADMIN`), el estado de conectividad (`online`/`offline`) y el historial de peticiones.
- **Enrutamiento por Hash:** Navegación fluida entre vistas (`#manuales`, `#api-explorer`, `#publicador`) sin requerir recarga de página, manteniendo el foco accesible según WCAG 2.4.3.
- **Diseño Adaptativo Móvil/Desktop:** Reglas fluidas mediante Flexbox/Grid. En pantallas $\le 768\text{px}$ se activa una barra de navegación inferior fija de 56px (*Bottom Navigation Bar*) y modales anclados en la base (*Bottom Sheets*), garantizando áreas táctiles $\ge 48 \times 48\text{ px}$.

---

## 2. Implementación de Caminos de Interacción

### 2.1. Camino Feliz (Happy Path)
- **Rol Asistencial (Médico/Enfermería):** Acceso directo a guías operativas. Al buscar "Triage", se renderiza la tarjeta clínica con paso a paso y badge de disponibilidad offline.
- **Rol Técnico (Auditor/Dev):** Inspección de endpoints OpenAPI (`GET /api/v1/contracts`). Al pulsar "Try it out", el simulador procesa los parámetros y devuelve un payload JSON formateado bajo el esquema `ContractDTO` con identificadores sintéticos (`PAC-SYNTH-9941`), cabeceras HTTP y botón de un clic para copiar el comando `cURL`.

### 2.2. Error Crítico y Recuperación RFC 7807 (Critical Error Path)
- Al intentar publicar un contrato con incremento `Major` (Breaking Change) sin escribir la confirmación de seguridad `CONFIRMAR-V3.0.0`, el sistema intercepta la acción y genera un objeto **ProblemDetails RFC 7807 (HTTP 422)**.
- La interfaz transfiere el foco al campo infractor, aplica `aria-invalid="true"`, despliega el mensaje de error con `role="alert"` y preserva íntegramente los datos cargados para permitir la corrección *in-situ* sin reiniciar el formulario.

---

## 3. Resiliencia ante Red Degradada (Offline-First)

El botón interactivo "Simular Red" permite evaluar en tiempo real la transición entre estados:
- En modo offline, los manuales clínicos se sirven desde la memoria local emulada.
- Si se intenta una petición de red no cacheada, la UI despliega un error 504 Gateway Timeout con botón de reintento idempotente.
