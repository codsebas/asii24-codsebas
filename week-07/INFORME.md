# Informe Técnico: Diseño de Componentes y Refactorización (Semana 7)

**Estudiante:** Albino Sebastián Rosales Ruano
**GitHub:** [`codsebas`](https://github.com/codsebas)
**Módulo Oficial:** Contratos API: OpenAPI/Postman y documentación técnica
**Adaptación Académica:** Centro de documentación y manuales por rol

---

## 1. Introducción y Arquitectura de Componentes

Para dar respuesta a los requerimientos de la Semana 7 del Sistema Hospitalario Integrado (SHI), se diseñó la topología de componentes frontend y backend del módulo **ASII-24**:

* **Componentes Frontend (Web/Móvil):**
  - `ContractViewerWidget`: Renderizador visual especializado por rol clínico (`Médico`, `Enfermera`, `TecnicoLab`, `Recepcionista`, `AuditorExterno`).
  - `ContractPublishModal`: Formulario administrativo con validaciones reactivas para `Admin`.
  - `ApiContractClientService`: Capa de transporte desacoplada con gestión de tokens Bearer JWT y tenant `X-Tenant-ID`.
* **Componentes Backend:**
  - `Presentation Component`: Controladores delegados delgados y manejador de errores RFC 7807 (`ProblemDetailsHandler`).
  - `Application Component`: Casos de uso atómicos guiados por DTOs (`PublishContractHandler`, `GetContractHandler`).
  - `Domain Component`: Entidades invariantes y guardián de autorización `RoleAuthorizationGuard`.
  - `Persistence Component`: Adaptadores de repositorio desacoplados (`PdoDocumentRepository` e `InMemoryDocumentRepository`).

---

## 2. Identificación del Punto de Mayor Acoplamiento

En la arquitectura preliminar de la Semana 4, el controlador web (`DocumentController`) concentraba múltiples responsabilidades ortogonales:
1. Deserialización y validación estructural del JSON de entrada.
2. Invocación de reglas de formato SemVer y validaciones de alcance.
3. Evaluación manual de pertenencia a arrays de roles.
4. Mapeo y serialización de respuestas de error ad-hoc.

Este diseño generaba una fuga de abstracciones (*leaky abstractions*), donde cualquier ajuste en los esquemas OpenAPI o en las políticas de seguridad requería modificar directamente el controlador.

---

## 3. Justificación y Comparación Antes / Después del Refactor

| Dimensión | Antes de la Refactorización | Después de la Refactorización | Beneficio Obtenido |
|---|---|---|---|
| **Acoplamiento Eferente ($C_e$)** | $C_e = 5$ (OpenAPI, SQL, PDO, RBAC, JSON) | $C_e = 2$ (Command DTO, ErrorHandler) | Reducción del 60% en dependencias directas |
| **Cohesión (LCOM)** | Cohesión baja (mezcla de HTTP, validación y DB) | Cohesión alta (orquestación pura de protocolo) | Principio de Responsabilidad Única (SRP) |
| **Manejo de Errores** | Respuestas ad-hoc inconsistentes | Estándar RFC 7807 (`ProblemDetails`) | Respuestas uniformes para clientes web y móviles |
| **Transporte de Datos** | Arrays asociativos crudos desestructurados | DTOs inmutables fuertemente tipados | Prevención de errores en tiempo de compilación/ejecución |

---

## 4. Conclusión

La refactorización ejecutada permite que el módulo ASII-24 evolucione hacia las siguientes semanas (diseño UX y movilidad) con interfaces estables, previsibles y fuertemente protegidas contra regresiones.
