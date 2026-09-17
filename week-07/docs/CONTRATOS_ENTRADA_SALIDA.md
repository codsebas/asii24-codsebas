# Contratos de Entrada y Salida (ASII-24)

## 1. DTO de Entrada: `PublishContractCommand`

Transporta la intención de publicar un nuevo contrato o manual técnico desde la capa de presentación hacia la aplicación sin acoplarse al framework HTTP.

```json
{
  "title": "Guia Clinica de Farmacovigilancia",
  "version": "1.0.0",
  "summary": "Protocolo de deteccion de reacciones adversas a medicamentos",
  "content": "Contenido tecnico del protocolo...",
  "ownerScope": "CENTRAL",
  "hospitalUuid": null,
  "allowedRoles": ["Admin", "Medico", "Enfermera"]
}
```

*Validaciones de entrada:*
- `title`: Obligatorio, longitud entre 5 y 200 caracteres.
- `version`: Formato SemVer (`MAJOR.MINOR.PATCH`).
- `ownerScope`: `CENTRAL` o `HOSPITAL`. Si es `HOSPITAL`, `hospitalUuid` es obligatorio.
- `allowedRoles`: Al menos un rol hospitalario válido.

---

## 2. DTO de Salida: `ContractDetailResponse`

Retorna la representación canónica del contrato/documento autorizado para el rol consumidor.

```json
{
  "id": "doc-uuid-1234",
  "code": "GC-FARMACO-01",
  "title": "Guia Clinica de Farmacovigilancia",
  "version": "1.0.0",
  "status": "PUBLISHED",
  "ownerScope": "CENTRAL",
  "hospitalUuid": null,
  "allowedRoles": ["Admin", "Medico", "Enfermera"],
  "publishedAt": "2026-09-16T18:00:00Z"
}
```

---

## 3. Contrato de Error Estándar: RFC 7807 (`ProblemDetails`)

Desacopla los errores internos del dominio y persistencia de las respuestas HTTP, retornando un esquema universal para clientes web y móviles:

```json
{
  "type": "https://shi.hospital.gt/errors/unauthorized-role",
  "title": "Acceso Denegado por Rol",
  "status": 403,
  "detail": "El rol 'Recepcionista' no cuenta con autorizacion para consultar este contrato.",
  "instance": "/api/v1/api-contracts/doc-uuid-1234",
  "code": "ERR_RBAC_FORBIDDEN"
}
```
