# Informe Técnico - Semana 10: Diseño para Movilidad en Salud

## 1. Ergonomía Hospitalaria y Factores Humanos

El personal médico y de enfermería opera en condiciones críticas de movilidad: desplazamientos continuos entre camas, uso de guantes protectores de nitrilo/látex y necesidad de consultar protocolos con una sola mano. En un smartphone compacto (320–430 px de ancho), el diseño de interfaces exige:
- **Thumb Zone Optimization:** Ubicar las funciones más frecuentes en el tercio inferior de la pantalla (zona de confort del pulgar), reservando el área superior exclusivamente para visualización pasiva.
- **Touch Targets Accesibles:** Elementos interactivos con un área táctil mínima de **$48 \times 48\text{ px}$** y separación de 8 px para evitar toques accidentales por personal enguantado o bajo estrés.
- **Reducción de Carga Cognitiva:** Eliminación de texto periférico; visualización prioritaria de dosis, alertas de bioseguridad y pasos de procedimiento en la primera pantalla visible.

---

## 2. Arquitectura de Información Responsive (320–430 px)

Para adaptar la documentación técnica y manuales a dispositivos de mano:
- **Sustitución de Tablas Densas por Data Cards:** Las tablas de endpoints y manuales se desestructuran en tarjetas verticales autónomas. Cada tarjeta exhibe método HTTP con color distintivo, ruta simplificada y versionado SemVer.
- **Formularios Lineales Verticales:** Los campos de formulario y selectores de roles se despliegan al 100% del ancho del viewport, evitando desplazamientos laterales.
- **Diálogos Modales Adaptativos:** Los cuadros de confirmación de escritorio se reemplazan por *Bottom Sheets* emergentes ancladas al borde inferior.

---

## 3. Manejo de Contratos OpenAPI 3.0 y Postman en Móviles

La inspección de APIs desde terminales de guardia (*on-call*) incorpora mecanismos de condensación técnica:
- **Payloads Colapsables:** Los bloques JSON de peticiones y respuestas se truncan inicialmente a 5 líneas con botón "Expandir Payload" y botón de un toque para "Copiar cURL".
- **Esquemas de Error RFC 7807 Compactos:** Las respuestas 4xx/5xx se representan mediante tarjetas de diagnóstico compactas con la causa raíz y botón de reintento.

---

## 4. Estrategia de Resiliencia ante Redes Hospitalarias Degradadas

En sótanos, salas de radiología o pasillos con interferencia electromagnética, la conectividad Wi-Fi y celular es intermitente:
- **Caché Local Transparente:** Mediante Service Worker y almacenamiento IndexedDB, las versiones vigentes de los manuales clínicos quedan disponibles inmediatamente aun sin conexión.
- **Píldora de Estado de Red:** Un indicador cromático superior informa en tiempo real: `[ ONLINE ]` (Verde), `[ MODO OFFLINE (CACHÉ) ]` (Ámbar) o `[ RECONECTANDO... ]` (Azul).
- **Idempotencia en Transacciones:** En caso de caída de conexión durante el envío de peticiones, se adjunta la cabecera `Idempotency-Key` para permitir reintentos automáticos sin duplicar registros.
