# Análisis y Diseño del Cambio Práctico (ASII-24)

## 1. Planteamiento del Requerimiento de Cambio

En el marco de la acreditación hospitalaria internacional (Joint Commission International), se solicita que el módulo **ASII-24** evolucione para soportar:
1. **Ciclo de Vida Documental:** Clasificación explícita de documentos en tres estados: `DRAFT` (Borrador técnico en revisión), `PUBLISHED` (Vigente y observable por roles clínicos) y `DEPRECATED` (Histórico reemplazado o en desuso).
2. **Rol de Auditoría Externa (`AuditorExterno`):** Acceso de solo lectura a documentos en estado `PUBLISHED` y `DEPRECATED`, prohibiendo cualquier operación de publicación o modificación, y requiriendo trazabilidad de acceso.

---

## 2. Análisis de Impacto por Capa

### A. Capa de Dominio (`Domain`)
- **Nuevo Value Object:** `DocumentStatus` con valores tipados `DRAFT`, `PUBLISHED`, `DEPRECATED`.
- **Regla de Invariante:** Un documento en estado `DRAFT` solo es visible para el rol `Admin`. Los documentos `PUBLISHED` son accesibles por los roles autorizados habituales (`Médico`, `Enfermera`, `TecnicoLab`, `Recepcionista`).
- **Compatibilidad hacia atrás:** Si no se especifica estado en registros existentes, el sistema asume por defecto `PUBLISHED`, preservando la vigencia de toda la documentación previamente registrada.

### B. Capa de Aplicación y Persistencia (`Application` & `Persistence`)
- **Casos de Uso:** `PublishDocument` ahora valida el estado inicial (por defecto `PUBLISHED`).
- **Repositorio:** La columna `status` se añade al esquema relacional con valor predeterminado `'PUBLISHED'`. El contrato de repositorio `DocumentRepository` incorpora el filtrado opcional por estado.

### C. Interfaz Cliente-Servidor y Contrato OpenAPI 3.0.3
- **Esquema:** Se añade la propiedad `status: { type: string, enum: [DRAFT, PUBLISHED, DEPRECATED] }` en `DocumentSchema`.
- **Cabeceras HTTP de Deprecación:** Cuando se consulta un documento en estado `DEPRECATED`, el servidor retorna los headers estándar RFC 8594:
  - `Deprecation: @true`
  - `Sunset: Wed, 31 Dec 2026 23:59:59 GMT`
  - `Link: </api/v1/api-contracts/{new_id}>; rel="successor-version"`

### D. Suite de Pruebas Postman
- **Caso 1 (Éxito Auditor):** `GET /api/v1/api-contracts/1` con token de `AuditorExterno` $\rightarrow$ `200 OK` (lectura autorizada).
- **Caso 2 (Denegación Auditor):** `POST /api/v1/api-contracts` con token de `AuditorExterno` $\rightarrow$ `403 Forbidden` (bloqueo RBAC estricto).
- **Caso 3 (Deprecación):** `GET /api/v1/api-contracts/{id_deprecated}` $\rightarrow$ `200 OK` con validación de cabecera `Deprecation`.

---

## 3. Conclusión Arquitectónica

Gracias al desacoplamiento en 4 capas y el uso del patrón Repository, este cambio no genera refactorizaciones masivas en el core de negocio: únicamente se extienden los DTOs de transporte, se añade la validación de estado en el dominio y se actualiza el esquema declarativo OpenAPI.
