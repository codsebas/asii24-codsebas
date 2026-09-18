# Defensa Oral - Semana 10: Diseño para Movilidad

## 1. Desafío del Viewport de 320 px en Documentación Técnica

**Pregunta del Tribunal:** ¿Cómo se garantiza que un desarrollador u operador médico pueda leer contratos o manuales en pantallas de apenas 320 px sin sufrir fatiga visual?

**Defensa Técnica:**
Una pantalla de 320 px de ancho no soporta la arquitectura estándar de Swagger UI de tres columnas. Si se renderizara directamente, forzaría al usuario a realizar scroll horizontal constante. En nuestra solución, aplicamos una transformación radical a nivel de presentación:
1. Las filas de tabla se convierten en *Data Cards* apiladas de 1 columna con ancho `calc(100% - 24px)`.
2. Los fragmentos de código JSON se muestran con tipografía monospace escalable a 12px y salto de línea forzado (*word-wrap: break-word*).
3. Se incorpora un botón de acción rápida para copiar el comando `cURL` completo al portapapeles, permitiendo al integrador ejecutar pruebas sin necesidad de transcribir parámetros en la pantalla pequeña.

---

## 2. Seguridad en Almacenamiento Local Offline

**Pregunta del Tribunal:** ¿Qué riesgos de seguridad introduce la caché local de manuales y contratos en terminales móviles hospitalarios?

**Defensa Técnica:**
Se estableció una política estricta de segregación de datos en caché:
- Únicamente se almacenan en almacenamiento local (IndexedDB cifrado) manuales operativos de procedimientos estándar y esquemas públicos de contratos OpenAPI correspondientes al rol autenticado.
- Queda totalmente vetado el almacenamiento en caché de tokens de autenticación activos, contraseñas, secretos de API o identificadores clínicos reales de pacientes.
- Al cerrar sesión o transcurridos 15 minutos de inactividad, la clave de desencriptado local se purga de la memoria del navegador móvil.

---

## 3. Ergonomía del Bottom Sheet frente a Modales Centrados

**Pregunta del Tribunal:** ¿Por qué sustituir los modales tradicionales de confirmación por Bottom Sheets en dispositivos móviles?

**Defensa Técnica:**
En pantallas móviles sostenidas con una sola mano, la parte superior y central de la pantalla cae fuera de la zona natural de alcance del pulgar (*Thumb Zone*). Un modal centrado exige al operador cambiar el agarre del teléfono o utilizar la segunda mano, lo cual incrementa el riesgo de caída del dispositivo o de toques accidentales en situaciones de emergencia. El *Bottom Sheet* emerge desde el borde inferior, situando los botones principales de "Confirmar" y "Cancelar" en la franja más accesible y segura para el pulgar.
