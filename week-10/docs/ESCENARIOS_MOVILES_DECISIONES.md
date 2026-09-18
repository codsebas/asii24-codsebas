# Escenarios Móviles Extremos y Decisiones de Contenido - ASII-24

Este documento formaliza dos escenarios de uso en movilidad con condiciones operativas hospitalarias y manejo de fallos.

---

## Escenario 1: Médico de Guardia Consultando Protocolo con Pérdida de Conexión Wi-Fi

```mermaid
sequenceDiagram
    autonumber
    actor Medico as Médico en Aislamiento (Móvil 360px)
    participant UI as Interfaz Móvil (PWA/Browser)
    participant SW as Service Worker & Cache Storage
    participant API as Backend Hospitalario (WiFi)

    Medico ->> UI: Abre "Protocolo de Sedación y Vía Aérea"
    UI ->> API: Solicita versión más reciente
    Note over API: Falla de red: Wi-Fi fuera de alcance (Timeout)
    API --x UI: Error de conexión de red
    UI ->> SW: Consultar documento en caché local
    SW -->> UI: Retorna protocolo v2.1.0 almacenado
    UI ->> Medico: Renderiza manual + Píldora ámbar "[ MODO OFFLINE ]"
    Medico ->> UI: Consulta dosis y procedimientos de forma fluida
```

### Decisiones de Contenido y Jerarquía:
1. **Priorización Clínica:** Se colocan en la parte superior las dosis de fármacos y alertas de riesgo vital.
2. **Colapso de Información Secundaria:** Las referencias bibliográficas, historial de versiones y firmas de comité se ocultan dentro de un acordeón cerrado para no saturar la pantalla de 360 px.
3. **Manejo de Errores y Notificación:** No se interrumpe al médico con un pop-up bloqueante. En su lugar, un indicador superior discreto en color ámbar informa: *"Modo sin conexión: visualizando copia local vigente"*.

---

## Escenario 2: Desarrollador On-Call Ejecutando Sandbox con Timeout y Fallo de Red Celular

```mermaid
sequenceDiagram
    autonumber
    actor Dev as Auditor / Dev On-Call (Móvil 390px)
    participant UI as Consola Sandbox Móvil
    participant Client as ApiContractClient
    participant Server as Sandbox API Gateway

    Dev ->> UI: Pulsa "Probar Endpoint" (GET /api/v1/contracts)
    UI ->> Client: Inicia petición HTTP con Idempotency-Key
    Client ->> Server: Envía solicitud con timeout de 5000ms
    Note over Server: Latencia extrema en red 4G / Congestión
    Server --x Client: Timeout alcanzado (504 Gateway Timeout)
    Client -->> UI: Mapeo a ProblemDetails RFC 7807
    UI ->> Dev: Despliega tarjeta de error 504 con botón "Reintentar"
    Dev ->> UI: Pulsa "Reintentar Petición (Intento 2/3)"
    UI ->> Server: Reenvío con Exponential Backoff
    Server -->> UI: HTTP 200 OK con datos sintéticos
    UI ->> Dev: Renderiza respuesta truncada con botón "Copiar cURL"
```

### Decisiones de Contenido y Jerarquía:
1. **Prevención de Pérdida de Datos:** Los parámetros ingresados por el desarrollador en el formulario móvil no se borran al ocurrir el timeout.
2. **Diagnóstico Accesible RFC 7807:** El error se visualiza con título amigable: *"Tiempo de espera agotado (504). La red tardó más de 5 segundos en responder"*.
3. **Mecanismo de Recuperación:** Se provee un botón táctil de ancho completo `[ Reintentar Petición ]` que ejecuta un reintento con *Exponential Backoff* (2s, 4s, 8s) sin recargar la página.
