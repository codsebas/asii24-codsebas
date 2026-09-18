# Evidencia de Capturas y Escenas del Prototipo - ASII-24

Especificación y representación estructurada de las 4 escenas clave del prototipo interactivo (`prototype/index.html`).

---

## Escena 1: Desktop — Camino Feliz (API Explorer & Sandbox)

- **Dispositivo:** Desktop ($1024\text{px}+$)
- **Rol Activo:** `ROLE_AUDITOR` (Auditor / Desarrollador Integrador)
- **Flujo:** Selección de `GET /api/v1/contracts`, ejecución de prueba en Sandbox y recepción de respuesta exitosa.

```text
+-----------------------------------------------------------------------------------------+
| 🏥 SHI-2026 Docs & Manuales                                      ● ONLINE  [Simular Red]|
| Rol Activo: [ Auditor / Desarrollador v ]                                               |
| [ Manuales Clínicos ]  [* API Explorer & Sandbox *]  [ Publicador SemVer ]              |
+-----------------------------------------------------------------------------------------+
|                                                                                         |
| Catálogo de Contratos OpenAPI 3.0                                [ SANDBOX V2.1 ]       |
| Endpoint: [ GET /api/v1/contracts (Listar Contratos) v ]                                 |
|                                                                                         |
| [ ⚡ Probar Endpoint (Try It Out) ]                                                      |
|                                                                                         |
| ✅ HTTP 200 OK (ContractDetailResponse DTO)                                             |
| +-------------------------------------------------------------------------------------+ |
| | {                                                                                   | |
| |   "contract_id": "CTR-SYNTH-9941",                                                  | |
| |   "title": "Protocolo Triage y Urgencias",                                          | |
| |   "version": "v2.4.0",                                                              | |
| |   "auth_token": "Bearer eyJhbGci...***",                                            | |
| |   "patient_ref": "PAC-SYNTH-REDACTED",                                              | |
| |   "status": "ACTIVE"                                                                | |
| | }                                                                                   | |
| +-------------------------------------------------------------------------------------+ |
| [ 📋 Copiar Comando cURL ]                                                             |
+-----------------------------------------------------------------------------------------+
```

---

## Escena 2: Desktop — Error Crítico (Validación RFC 7807 SemVer Major)

- **Dispositivo:** Desktop ($1024\text{px}+$)
- **Rol Activo:** `ROLE_ADMIN` (Administrador / API Publisher)
- **Flujo:** Intento de publicar versión `Major` con advertencia bloqueante de ruptura de contratos intermodulares.

```text
+-----------------------------------------------------------------------------------------+
| 🛑 Error de Validación RFC 7807 (HTTP 422)                                               |
| +-------------------------------------------------------------------------------------+ |
| | Alerta de Seguridad RFC 7807:                                                       | |
| | Ha seleccionado incremento MAJOR (v3.0.0). Este cambio rompe compatibilidad con     | |
| | los módulos 13 y 15. Debe escribir la confirmación de seguridad para proceder.      | |
| +-------------------------------------------------------------------------------------+ |
| Escriba "CONFIRMAR-V3.0.0" para desbloquear:                                            |
| [                                                  ] (aria-invalid="true")              |
|                                                                                         |
| [ Cancelar ]                                               [ Confirmar Despliegue ]     |
+-----------------------------------------------------------------------------------------+
```

---

## Escena 3: Móvil — Camino Feliz (Lector Clínico y Resiliencia Offline)

- **Dispositivo:** Smartphone ($360\text{px}$ ancho)
- **Rol Activo:** `ROLE_MEDICO` (Médico Especialista)
- **Flujo:** Búsqueda y lectura de protocolo asistencial servido desde memoria local con red degradada.

```text
+------------------------------------------+
| 🏥 SHI-2026 Docs       ▲ MODO OFFLINE    |
| Rol: [ Médico Especialista v ]           |
+------------------------------------------+
| Protocolo: Triage y Urgencias            |
| Rol: Médico / Enf. • Ver. 2.4.0          |
| [✓ Disponible en Caché Local]            |
|                                          |
| ⚠️ ALERTA: Verifique escala de Glasgow   |
|    antes de sedación o intubación.       |
|                                          |
| [ Ver Procedimiento Completo ]  (48px)   |
+------------------------------------------+
| [ 📚 Manuales* ]   [ 🔌 API ]   [ 🚀 Pub ]|
+------------------------------------------+
```

---

## Escena 4: Móvil — Error Crítico (Bottom Sheet Táctil)

- **Dispositivo:** Smartphone ($360\text{px}$ ancho)
- **Rol Activo:** `ROLE_ADMIN`
- **Flujo:** Bottom Sheet anclada en el borde inferior (Thumb Zone) para confirmar o cancelar la acción crítica.

```text
+------------------------------------------+
| (Fondo oscurecido de la aplicación)      |
+==========================================+
| 🛑 Error 422: Confirmación SemVer Major  |
|                                          |
| Ruptura detectada con Módulo 13 y 15.    |
| Escriba "CONFIRMAR-V3.0.0":              |
| [ CONFIRMAR-V3.0.0                     ] |
|                                          |
| [ Confirmar ]                     (48px) |
| [ Cancelar ]                      (48px) |
+==========================================+
```
