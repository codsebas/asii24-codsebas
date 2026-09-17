# Guía de Defensa Oral: Componentes y Desacoplamiento (Semana 7)

**Estudiante:** Albino Sebastián Rosales Ruano
**GitHub:** [`codsebas`](https://github.com/codsebas)
**Módulo:** ASII-24 — Centro de documentación y manuales por rol

---

### Pregunta 1: ¿Cuál fue el punto de mayor acoplamiento identificado y cómo se resolvió?
**Respuesta:**
El punto crítico residía en el controlador web, el cual asumía responsabilidades mixtas: parseaba peticiones HTTP crudas, validaba reglas de formato OpenAPI, evaluaba permisos en arrays duros y formateaba errores ad-hoc.
Se resolvió aplicando el principio de responsabilidad única (SRP):
1. El controlador delega la validación de comandos a DTOs inmutables (`PublishContractCommand`).
2. El control de acceso se transfirió al `RoleAuthorizationGuard` en el dominio.
3. El formateo de errores se centralizó en `ProblemDetailsHandler` bajo el estándar RFC 7807.

---

### Pregunta 2: ¿Cómo interactúan los componentes de frontend con el backend desacoplado?
**Respuesta:**
Los componentes de interfaz (`ContractViewerWidget` y `ContractPublishModal`) nunca invocan directamente el motor de base de datos ni conocen modelos internos. Se comunican a través del servicio cliente `ApiContractClientService`, el cual consume exclusivamente la API REST mediante DTOs estandarizados y cabeceras de seguridad (`Bearer JWT` y `X-Tenant-ID`), recibiendo respuestas de éxito o errores RFC 7807 universales.

---

### Pregunta 3: ¿Qué métrica justifica la refactorización efectuada?
**Respuesta:**
Se evaluó el Acoplamiento Eferente ($C_e$) y la Inestabilidad ($I = \frac{C_e}{C_a + C_e}$). Antes del refactor, el controlador poseía un $C_e = 5$ (dependiente de OpenAPI, SQL, PDO, RBAC y JSON manual). Tras la refactorización, su acoplamiento eferente se redujo a $C_e = 2$ (solo conoce el comando DTO y el handler de respuesta), aumentando drásticamente la cohesión y modificabilidad del sistema.
