# Evidencia de Hallazgos de Usabilidad y Accesibilidad - ASII-24

Se detallan 6 hallazgos técnicos identificados sobre el Centro de Documentación y Manuales por Rol (`WF-01` a `WF-05`).

---

### HALL-01: Fuga de Foco por Teclado y Falta de Escape en Modal de Confirmación
- **Pantalla Afectada:** `WF-05` (Modal de Confirmación Crítica SemVer Major).
- **Dimensión:** Teclado y Foco.
- **Criterios Violados:** WCAG 2.1.2 (No Keyboard Trap) y WCAG 2.4.3 (Focus Order).
- **Severidad:** **Alta**.
- **Descripción:** Al navegar con la tecla `Tab` dentro del modal abierto, tras alcanzar el botón "Confirmar y Desplegar", el siguiente `Tab` traslada el foco a enlaces de la página de fondo inactiva. Asimismo, presionar la tecla `Escape` no cierra el modal.
- **Corrección Propuesta:** Implementar contención de foco (*Focus Trap*): ciclar el foco al primer botón al presionar `Tab` en el último control, y asociar el listener `keydown (Escape)` para cerrar el diálogo y devolver el foco al elemento detonador.
- **Criterio Verificable:** La navegación por `Tab` queda confinada dentro del modal. Presionar `Escape` cierra el diálogo y posiciona el foco en el botón detonador original.

---

### HALL-02: Contraste Cromático Insuficiente en Badges de Métodos HTTP
- **Pantalla Afectada:** `WF-01` (Portal Hub) y `WF-04` (Consola Interactiva Sandbox).
- **Dimensión:** Contraste Cromático.
- **Criterio Violado:** WCAG 1.4.3 (Contrast Minimum - Nivel AA).
- **Severidad:** **Media**.
- **Descripción:** El badge del método `GET` emplea texto celeste `#61AFFE` sobre fondo `#FFFFFF`, alcanzando una relación de contraste de apenas 3.2:1 (el estándar exige $\ge 4.5:1$ para texto regular).
- **Corrección Propuesta:** Reemplazar los colores por una paleta accesible: texto `#0B4A6F` sobre fondo `#E0F2FE` (ratio de contraste resultante: 6.8:1).
- **Criterio Verificable:** La herramienta de auditoría automatizada reporta ratio de contraste $\ge 4.5:1$ en todos los estados y badges.

---

### HALL-03: Ausencia de Descripción Semántica en Carga de Especificación OpenAPI
- **Pantalla Afectada:** `WF-02` (Gestor de Publicación y Versionado).
- **Dimensión:** Etiquetas y Semántica ARIA.
- **Criterios Violados:** WCAG 1.3.1 (Info and Relationships) y WCAG 4.1.2 (Name, Role, Value).
- **Severidad:** **Alta**.
- **Descripción:** El selector de archivos para `openapi.yaml` no asocia el texto de ayuda contextual sobre formatos permitidos mediante `aria-describedby`, dejando a usuarios de lectores de pantalla sin información de validación previa.
- **Corrección Propuesta:** Vincular el control de entrada con el elemento de ayuda: `<input type="file" id="spec-file" aria-describedby="spec-help" />` donde el texto indique: "Formatos admitidos: YAML o JSON bajo OpenAPI 3.0".
- **Criterio Verificable:** Al enfocar el input con lector de pantalla (NVDA/VoiceOver), se anuncia el label y la ayuda contextual de formato de archivo.

---

### HALL-04: Respuesta Asíncrona del Sandbox sin Anuncio en Región Viva
- **Pantalla Afectada:** `WF-04` (Consola Interactiva OpenAPI y Sandbox).
- **Dimensión:** Mensajes de Estado.
- **Criterio Violado:** WCAG 4.1.3 (Status Messages - Nivel AA).
- **Severidad:** **Media**.
- **Descripción:** Tras pulsar "Probar Endpoint (Try it out)", la respuesta simulada se inyecta en el DOM sin un contenedor reactivo `aria-live`, por lo que el usuario con discapacidad visual no recibe retroalimentación de la finalización de la petición.
- **Corrección Propuesta:** Configurar el contenedor de respuesta con los atributos `role="status"`, `aria-live="polite"` y `aria-atomic="true"`.
- **Criterio Verificable:** El lector de pantalla verbaliza automáticamente el estado HTTP y el resultado de la petición tras recibir la respuesta.

---

### HALL-05: Carencia de Barrera de Confirmación en Deprecación de Contratos y Ambigüedad de Entorno
- **Pantalla Afectada:** `WF-02` (Publicador de Contratos) y `WF-04` (Consola Sandbox).
- **Dimensión:** Prevención de Errores.
- **Criterio Violado:** WCAG 3.3.4 (Error Prevention: Legal, Financial, Data).
- **Severidad:** **Crítica**.
- **Descripción:** El cambio de estado de un endpoint a `DEPRECATED` se ejecuta en un solo clic sin advertencia de impacto sobre módulos consumidores (ej. Módulo 13 o 15). Además, no existe una diferenciación cromática inequívoca entre Sandbox y Producción.
- **Corrección Propuesta:** Incorporar diálogo modal de confirmación obligatoria para marcar contratos como obsoletos, y desplegar un banner superior con borde rojo/ámbar persistente indicando el entorno activo.
- **Criterio Verificable:** Ninguna deprecación se persiste sin confirmación modal explícita con listado de dependencias impactadas.

---

### HALL-06: Desconexión Semántica entre Errores RFC 7807 y Controles de Entrada
- **Pantalla Afectada:** `WF-02` (Publicador de Contratos) y `WF-05` (Modal de Confirmación).
- **Dimensión:** Identificación y Manejo de Errores.
- **Criterios Violados:** WCAG 3.3.1 (Error Identification) y WCAG 3.3.3 (Error Suggestion).
- **Severidad:** **Alta**.
- **Descripción:** Cuando el backend responde con un error 422 en formato RFC 7807 (`ProblemDetails`), el listado de fallos se muestra como un bloque de texto superior, sin marcar los inputs involucrados con `aria-invalid="true"` ni enlazar el mensaje de error con `aria-errormessage`.
- **Corrección Propuesta:** Parsear la propiedad `invalid-params` del payload RFC 7807, asignar `aria-invalid="true"` a los inputs señalados y transferir el foco al primer campo erróneo.
- **Criterio Verificable:** Al fallar la validación, el foco se posiciona en el primer campo inválido y el lector de pantalla lee el mensaje de error correspondiente.
