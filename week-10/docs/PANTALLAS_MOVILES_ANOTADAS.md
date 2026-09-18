# Pantallas Móviles Anotadas (Viewport 320–430 px) - ASII-24

Especificación detallada de 4 interfaces móviles adaptadas para uso táctil y resiliencia offline.

---

## PM-01: Portal Hub Móvil (Rol Médico / Asistencial)

```text
+------------------------------------------+  <- Viewport: 360px
| [SHI-2026] [Rol: Medico]   [ ONLINE ]    |  <- Header compacto (48px)
+------------------------------------------+
| [ Buscar protocolos o APIs...     ] [Q]  |  <- Input 100% width (48px)
| Filtros: [ Todos ] [ Urgencias ] [ UCI ] |  <- Chips con scroll horizontal
+------------------------------------------+
| ACCESO RAPIDO A GUIAS CLINICAS           |
|                                          |
| +--------------------------------------+ |  <- Data Card 1
| | Protocolo: Triage y Reanimacion      | |
| | Rol: Medico / Enf. | Ver. 2.4.0      | |
| | [✓ Disponible Offline]               | |
| | [ Ver Procedimiento ]     (48x48 px) | |
| +--------------------------------------+ |
|                                          |
| +--------------------------------------+ |  <- Data Card 2
| | Guia: Prescripcion de Antibioticos   | |
| | Rol: Medico | Ver. 1.8.0             | |
| | [ Descargar Caché ]       (48x48 px) | |
| +--------------------------------------+ |
+------------------------------------------+
| [ Inicio ]  [ Manuales* ]  [ APIs ] [ ? ]|  <- Bottom Nav Bar (56px)
+------------------------------------------+
```

### Anotaciones de Interacción:
- **Área Táctil:** Los botones "Ver Procedimiento" y "Descargar Caché" tienen altura de 48px y ocupan el ancho completo de la tarjeta.
- **Jerarquía:** El estado de red `[ ONLINE ]` es claramente visible en la esquina superior derecha.

---

## PM-02: Lector de Protocolos Clínicos (Modo Offline Activo)

```text
+------------------------------------------+
| [< Volver] Protocolo: Sedacion  [MODO OFFLINE]|  <- Network status ámbar
+------------------------------------------+
| ALERTA CLINICA - VIA AEREA CRITICA       |
| [!] Requiere monitorizacion continua de  |  <- Tarjeta de advertencia
|     oximetria y capnografia.             |
+------------------------------------------+
| 1. Dosis de Induccion                    |
| - Paciente adulto: 1.5 - 2.0 mg/kg       |
| - Paciente geriatrico: Reducir 40%       |
|                                          |
| 2. Procedimiento de Preoxigenacion       |
| Administrar O2 al 100% durante 3 minutos.|
|                                          |
| [✓ Contenido cargado desde memoria local]|
+------------------------------------------+
| [ Indice Rapido ]     [ Marcar Favorito ]|  <- Botones apilados (48px c/u)
+------------------------------------------+
```

### Anotaciones de Interacción:
- **Resiliencia:** El badge `[ MODO OFFLINE ]` alerta que el documento se lee desde la memoria del teléfono sin interrupciones.
- **Tipografía:** Texto clínico a 16px con interlineado 1.5 para lectura rápida en situaciones de estrés.

---

## PM-03: Consola API y Sandbox Compacto (Rol Auditor / Dev)

```text
+------------------------------------------+
| API Explorer: ASII-24    [ SANDBOX ] [?] |
+------------------------------------------+
| Endpoint seleccionado:                   |
| +--------------------------------------+ |
| | [GET] /api/v1/contracts              | |  <- Badge GET celeste oscuro
| | Version: v2.0.0 | Auth: Bearer ***   | |
| +--------------------------------------+ |
| Parametro: [ role = MEDICO           ]   |  <- Input vertical (48px)
|                                          |
| [ Probar Endpoint (Try It Out) ] (48px)  |  <- Boton primario
|                                          |
| Respuesta Sandbox (HTTP 200 OK):         |
| +--------------------------------------+ |
| | {                                    | |  <- Visor monoespaciado
| |   "contract_id": "CTR-SYNTH-9941",   | |     truncado a 5 lineas
| |   "status": "ACTIVE"                 | |
| | }                                    | |
| +--------------------------------------+ |
| [ Copiar cURL ]    [ Ver Esquema DTO ]   |  <- Touch targets de 48px
+------------------------------------------+
| [ Inicio ]  [ Manuales ]  [ APIs* ] [ ? ]|
+------------------------------------------+
```

### Anotaciones de Interacción:
- **Protección de Datos:** Se muestran datos sintéticos y el token se encuentra enmascarado.
- **Acción Rápida:** Botón "Copiar cURL" permite replicar la petición en una terminal sin necesidad de escribir en pantalla.

---

## PM-04: Bottom Sheet de Confirmación Crítica y Reconexión

```text
+------------------------------------------+
| (Fondo inactivo oscurecido al 60%)       |
|                                          |
+==========================================+  <- Bottom Sheet anclada
|               [ === ]                    |  <- Drag handle táctil
| CONFIRMAR VERSION SEMVER MAJOR           |
|                                          |
| [!] ADVERTENCIA: La version v2.0.0       |
| introduce cambios no compatibles.        |
|                                          |
| Escriba "CONFIRMAR" para continuar:      |
| [ CONFIRMAR                          ]   |  <- Input 48px alto
|                                          |
| [ Confirmar y Desplegar ]       (48px)   |  <- Boton primario rojo
| [ Cancelar Accion ]             (48px)   |  <- Boton secundario neutro
+==========================================+
```

### Anotaciones de Interacción:
- **Ergonomía:** El diálogo emerge desde el borde inferior, permitiendo al pulgar interactuar directamente con los botones de acción sin estirar la mano.
