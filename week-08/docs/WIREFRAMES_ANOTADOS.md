# Wireframes Anotados con Especificación de Estados - ASII-24

Se presentan 5 wireframes estructurados con especificación de layout, micro-copys, validaciones y cobertura de los 5 estados obligatorios (`INITIAL`, `LOADING`, `EMPTY`, `SUCCESS`, `RECOVERABLE_ERROR`).

---

## WF-01: Portal Hub del Centro de Documentación y Manuales

```text
+-----------------------------------------------------------------------------------------+
| [SHI-2026] Centro de Documentacion y Manuales por Rol                [Rol: Medico] [?] |
+-----------------------------------------------------------------------------------------+
| [ Buscar manuales, endpoints o procedimientos...                        ] [ Buscar ]     |
| Filtros: [ Todos ] [ Clinica ] [ Laboratorio ] [ Farmacia ] [ Contratos API ]           |
+-----------------------------------------------------------------------------------------+
|                                                                                         |
|  +---------------------------+  +---------------------------+  +----------------------+ |
|  | Guia: Triage y Urgencias  |  | Protocolo: Hemocultivos   |  | Manual: Prescripcion | |
|  | Rol: Medico / Enfermeria  |  | Rol: Laboratorio / Medico |  | Rol: Medico Especial | |
|  | Ver. 2.4.0 (Vigente)      |  | Ver. 1.8.2 (Vigente)      |  | Ver. 3.0.1 (Vigente) | |
|  | [ Ver Manual ] [ PDF ]    |  | [ Ver Manual ] [ PDF ]    |  | [ Ver Manual ] [ PDF]| |
|  +---------------------------+  +---------------------------+  +----------------------+ |
|                                                                                         |
+-----------------------------------------------------------------------------------------+
```

### Especificación de Estados y Reglas de Interacción:
- **`INITIAL`:** Carga de tarjetas según el rol activo (`ROLE_MEDICO`). Se resaltan los manuales más frecuentados del servicio.
- **`LOADING`:** Tres tarjetas esqueleto grises (`pulse animation`) preservando dimensiones para evitar saltos visuales.
- **`EMPTY`:** "No se encontraron manuales para la búsqueda ingresada. ¿Desea solicitar la publicación de este manual al Administrador? [ Solicitar Manual ]".
- **`SUCCESS`:** Listado renderizado con contador total de documentos y badges de versión SemVer.
- **`RECOVERABLE_ERROR`:** "No se pudo sincronizar el catálogo de manuales. [ Reintentar conexión ]".
- **Ayuda Contextual:** El botón `[?]` despliega modal con glosario de términos y nivel de acceso del rol.

---

## WF-02: Gestor de Publicación y Versionado de Contratos (Rol: Admin)

```text
+-----------------------------------------------------------------------------------------+
| Publicador de Contratos OpenAPI y Manuales                            [Admin] [Cerrar X]|
+-----------------------------------------------------------------------------------------+
| Modulo: [ ASII-24: Contratos API y Documentacion          v ]                           |
| Archivo de Contrato: [ openapi.yaml                     ] [ Seleccionar Archivo... ]    |
|                                                                                         |
| Incremento SemVer: ( ) Patch (v1.0.1)  ( ) Minor (v1.1.0)  (*) Major (v2.0.0 - Breaking)|
| Audiencia permitida: [x] Medico  [x] Enfermeria  [x] Auditor  [x] Desarrollador         |
|                                                                                         |
| Descripcion de Cambios (Changelog):                                                     |
| +-------------------------------------------------------------------------------------+ |
| | Se agrega contrato de ProblemDetails RFC 7807 y validacion de DTOs en lote.        | |
| +-------------------------------------------------------------------------------------+ |
|                                                                                         |
| [!] Advertencia: Selecciono incremento Major. Se requerira confirmacion critica.        |
|                                                                                         |
| [ Cancelar ]                                               [ Validar y Publicar ]       |
+-----------------------------------------------------------------------------------------+
```

### Especificación de Estados y Reglas de Interacción:
- **`INITIAL`:** Formulario prellenado con la versión actual y detección automática de cambios.
- **`LOADING`:** Botón en estado disabled con spinner: "Validando sintaxis OpenAPI 3.0...".
- **`EMPTY`:** Si el campo de archivo está vacío, el botón "Validar y Publicar" permanece deshabilitado.
- **`SUCCESS`:** Redirección automática al hub con toast: "Contrato v2.0.0 publicado exitosamente".
- **`RECOVERABLE_ERROR`:** Validación semántica fallida (ej. tipo de dato no soportado): "Error en línea 45 de openapi.yaml: falta schema en response 422. [ Corregir en editor ]". El archivo cargado no se pierde.

---

## WF-03: Visor de Manuales Operativos Clínicos (Rol: Médico/Enfermería)

```text
+-----------------------------------------------------------------------------------------+
| Centro de Documentacion > Guia: Protocolo de Administracion de Medicamentos Criticos   |
+-----------------------------------------------------------------------------------------+
| [ Indice ]                    |  1. Proposito y Alcance                                 |
| 1. Proposito                  |  Asegurar la doble verificacion previa a administracion.|
| 2. Procedimiento Doble Check  |                                                         |
| 3. Registro en Historia       |  [!] ALERTA CLINICA: Verifique siempre los 5 correctos:  |
| 4. Notificacion de Eventos    |      Paciente, Medicamento, Dosis, Via y Hora.          |
|                               |                                                         |
| [ Exportar PDF ] [ Favorito ] |  2. Procedimiento de Validacion                         |
| Modo: [ Lectura Offline OK ]  |  Escanee el codigo de barra del brazalete del paciente. |
+-----------------------------------------------------------------------------------------+
```

### Especificación de Estados y Reglas de Interacción:
- **`INITIAL`:** Apertura del primer capítulo del manual con tipografía optimizada para lectura en pantallas médicas.
- **`LOADING`:** Líneas esqueleto simulando párrafos de texto.
- **`EMPTY`:** "Este manual se encuentra en proceso de revisión por el comité técnico. [ Ver versión preliminar ]".
- **`SUCCESS`:** Renderizado Markdown de alta legibilidad con soporte para lectura offline en terminales móviles.
- **`RECOVERABLE_ERROR`:** Fallo al descargar PDF: "Error al generar archivo PDF. Puede seguir leyendo en pantalla o [ Reintentar descarga ]".

---

## WF-04: Consola Interactiva OpenAPI y Sandbox Seguro (Rol: Auditor/Dev)

```text
+-----------------------------------------------------------------------------------------+
| API Explorer: ASII-24 Contratos | Entorno: [ Sandbox Seguro v ]  Token: [ Bearer ***** ]|
+-----------------------------------------------------------------------------------------+
| GET  /api/v1/contracts          | Parametros: role=MEDICO (query)                       |
| POST /api/v1/contracts          | [ Probar Endpoint (Try it out) ]                      |
| GET  /api/v1/contracts/{id}     +-------------------------------------------------------+
|                                 | Respuesta Simulada (HTTP 200 OK):                     |
| Schemas:                        | {                                                     |
| - ContractDTO                   |   "contract_id": "CTR-SYNTH-8841",                    |
| - ProblemDetails (RFC 7807)     |   "patient_id": "PAC-REDACTED-***",                   |
| - RolePolicyDTO                 |   "status": "APPROVED"                                |
|                                 | }                                                     |
+-----------------------------------------------------------------------------------------+
```

### Especificación de Estados y Reglas de Interacción:
- **`INITIAL`:** Lista de endpoints agrupados por tags con badges cromáticos según método HTTP.
- **`LOADING`:** Spinner animado en la consola de respuesta: "Ejecutando en Sandbox...".
- **`SUCCESS`:** Visualización de headers HTTP y cuerpo de respuesta formateado con resaltado de sintaxis.
- **`RECOVERABLE_ERROR`:** Error de validación de parámetros (HTTP 422): Despliegue de estructura RFC 7807 con mensaje: "El parámetro role no es válido. Valores permitidos: ADMIN, MEDICO, ENFERMERA".
- **Protección de Datos:** Cualquier campo que contenga PII se reemplaza automáticamente por identificadores sintéticos (`PAC-REDACTED-***`).

---

## WF-05: Modal de Confirmación Crítica y Recuperación de Errores

```text
+-----------------------------------------------------------------------------------------+
| CONFIRMACION DE PUBLICACION MAYOR (BREAKING CHANGE)                    [ Cerrar X ]     |
+-----------------------------------------------------------------------------------------+
|  [!] ATENCION: La version que esta por publicar (v2.0.0) introduce cambios              |
|      incompatibles con versiones anteriores de los contratos de API.                    |
|                                                                                         |
|  Consumidores afectados identificados:                                                  |
|  - Modulo 13 (Signos Vitales)                                                           |
|  - Modulo 15 (Prescripciones)                                                           |
|                                                                                         |
|  Para confirmar esta accion destructiva, escriba "CONFIRMAR-V2.0.0" abajo:              |
|  [                                                                ]                     |
|                                                                                         |
|  [ Cancelar ]                                               [ Confirmar y Desplegar ]   |
+-----------------------------------------------------------------------------------------+
```

### Especificación de Estados y Reglas de Interacción:
- **Regla de Validación:** El botón `[ Confirmar y Desplegar ]` permanece bloqueado hasta que el usuario ingresa exactamente la cadena solicitada.
- **Accesibilidad:** Enfoque automático (*autofocus*) en el campo de texto, navegación con tabulador y cierre mediante tecla `Escape`.
- **Prevención de Errores:** Evita la propagación accidental de rupturas en los contratos de integración intermodular.
