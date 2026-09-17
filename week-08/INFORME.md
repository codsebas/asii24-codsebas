# Informe Técnico - Semana 8: Diseño de Experiencia de Usuario (UX)

## 1. Introducción y Justificación de Diseño

El diseño de experiencia de usuario en sistemas hospitalarios críticos requiere minimizar la fatiga cognitiva del personal asistencial y asegurar precisión técnica absoluta para los integradores de software. En este módulo, el **Centro de Documentación y Manuales por Rol** resuelve tres necesidades operativas esenciales:
1. **Personal Clínico (Médicos y Enfermería):** Demandan acceso inmediato a protocolos hospitalarios y guías de servicio sin fricción terminológica de ingeniería de software.
2. **Desarrolladores y Auditores:** Requieren inspeccionar contratos OpenAPI 3.0, descargar colecciones Postman v2.1 y ejecutar pruebas seguras en un sandbox interactivo.
3. **Administradores:** Necesitan mecanismos de publicación asistida con validación sintáctica en tiempo real y confirmación estricta para evitar roturas de compatibilidad hacia atrás.

---

## 2. Arquitectura de Información y Taxonomía por Rol

La estructura documental se organiza jerárquicamente bajo un esquema de control de acceso basado en roles (RBAC):
- **Nivel Operativo Clínico:** Procedimientos de admisión, triage, consulta externa y solicitud de exámenes, presentados en formato narrativo estructurado con badges de criticidad médica.
- **Nivel Técnico de Integración:** Catálogo de endpoints REST, esquemas de entrada/salida (DTOs), códigos de estado HTTP y formatos de error RFC 7807 (Problem Details).
- **Nivel de Gobernanza de Plataforma:** Historial de versiones (SemVer: Major.Minor.Patch), changelog de contratos y estado de vigencia o deprecación de APIs.

---

## 3. Estrategia de Estados de Interfaz (Lifecycle UX)

Para erradicar la incertidumbre del usuario ante fallas o latencia, cada componente implementa una máquina de estados determinista:
- **Skeleton Loading:** Se emplean pantallas esqueleto con animaciones tenues que preservan el espacio de visualización, reduciendo a cero el desplazamiento acumulativo del diseño (Cumulative Layout Shift - CLS).
- **Actionable Empty States:** Cuando una búsqueda no arroja coincidencias o un usuario nuevo carece de guías marcadas, se despliegan acciones sugeridas ("Explorar catálogo general" o "Solicitar nuevo manual").
- **Mapeo de Errores RFC 7807:** Los fallos técnicos (400 Bad Request, 404 Not Found, 422 Unprocessable Entity) se traducen a explicaciones en lenguaje natural con micro-copys comprensibles, identificando el campo afectado y proveyendo un botón de reintento (`Retry`) sin recargar la página.

---

## 4. Políticas de Seguridad y Protección de Datos en UI

La interacción con contratos API y manuales técnicos incorpora salvaguardas de privacidad clínica:
- **Enmascaramiento de Tokens:** Los tokens de autenticación en la consola interactiva se muestran ofuscados (`Bearer eyJhbGci...****`).
- **Anonimización de Datos Clínicos:** Todos los payloads de ejemplo en Swagger y Postman utilizan identificadores ficticios sintéticos (`PAC-SYNTH-9842`, `MED-SYNTH-102`), evitando exponer registros médicos reales de pacientes.
- **Indicadores de Entorno:** Un banner de alto contraste alerta si el usuario se encuentra ejecutando pruebas en entorno `Sandbox` o inspeccionando contratos de `Producción`.
