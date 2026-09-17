# Backlog Priorizado de Correcciones de Usabilidad y Accesibilidad - ASII-24

Matriz de remediación estructurada bajo la metodología **MoSCoW**, con estimación de esfuerzo, impacto en contratos OpenAPI/Postman y criterios verificables en formato Gherkin.

---

## 1. Matriz de Priorización MoSCoW

| Prioridad | ID Hallazgo | Título de la Tarea de Remediación | Esfuerzo (SP) | Impacto OpenAPI / Postman |
| :---: | :---: | :--- | :---: | :--- |
| **Must Have** | `HALL-05` | Confirmación estricta en deprecación y advertencia visual de entorno | 5 | Previene roturas en contratos activos de integración. |
| **Must Have** | `HALL-01` | Contención de foco accesible (*Focus Trap*) y tecla Escape en modales | 3 | Garantiza operabilidad por teclado en acciones críticas. |
| **Must Have** | `HALL-06` | Enlace semántico de errores RFC 7807 con `aria-invalid` y `aria-errormessage` | 5 | Conecta DTOs ProblemDetails con inputs de formulario. |
| **Should Have**| `HALL-03` | Soporte descriptivo `aria-describedby` para carga y validación OpenAPI | 2 | Clarifica formatos admitidos en subida de contratos. |
| **Should Have**| `HALL-04` | Región viva `aria-live="polite"` en consola de pruebas Sandbox | 2 | Notifica respuestas asíncronas simuladas en Postman/API. |
| **Could Have** | `HALL-02` | Ajuste de contraste cromático en badges de métodos HTTP y estados | 1 | Mejora la legibilidad general sin impacto funcional. |

---

## 2. Especificación Técnica y Criterios Verificables de Aceptación

### Tarea 1: Prevención de Errores en Deprecación y Entorno (HALL-05) - Prioridad: Must Have
- **Corrección Técnica:** Implementar modal con confirmación de dos pasos para deprecación de APIs y banner persistente de entorno con `role="alert"`.
- **Criterio de Aceptación (Gherkin):**
  ```gherkin
  Dado que un administrador intenta marcar un endpoint como "DEPRECATED"
  Cuando pulsa el botón de cambio de estado
  Entonces el sistema despliega un modal bloqueante listando los módulos consumidores afectados
  Y exige escribir la confirmación "CONFIRMAR-DEPRECACION" para habilitar el botón de guardado.
  ```

### Tarea 2: Contención de Foco y Tecla Escape en Modales (HALL-01) - Prioridad: Must Have
- **Corrección Técnica:** Implementar listener de teclado para interceptar `Tab` y ciclar entre el primer y último elemento interactivo, además de cerrar con `Escape`.
- **Criterio de Aceptación (Gherkin):**
  ```gherkin
  Dado que el modal de confirmación SemVer Major se encuentra visible
  Cuando el usuario presiona la tecla "Tab" encontrándose en el último botón
  Entonces el foco se transfiere automáticamente al primer elemento interactivo del modal
  Y al presionar la tecla "Escape" el modal se cierra devolviendo el foco al botón de apertura.
  ```

### Tarea 3: Mapeo Accesible de Errores RFC 7807 (HALL-06) - Prioridad: Must Have
- **Corrección Técnica:** Vincular las propiedades del objeto ProblemDetails (`invalid-params`) con los IDs de los inputs y contenedores de error mediante `aria-errormessage`.
- **Criterio de Aceptación (Gherkin):**
  ```gherkin
  Dado que el backend responde con un error HTTP 422 estructurado según RFC 7807
  Cuando la interfaz procesa la respuesta
  Entonces los campos infractores reciben el atributo "aria-invalid=true"
  Y el foco se desplaza al primer campo con error anunciando la causa de validación.
  ```

### Tarea 4: Semántica ARIA en Carga de Contratos OpenAPI (HALL-03) - Prioridad: Should Have
- **Corrección Técnica:** Asociar elemento de ayuda con `aria-describedby` en inputs de carga de archivo y selección de versión.
- **Criterio de Aceptación (Gherkin):**
  ```gherkin
  Dado que un usuario con lector de pantalla enfoca el input de carga de archivo de contrato
  Cuando el control recibe el foco
  Entonces el lector anuncia "Seleccionar especificación OpenAPI, botón, formatos admitidos: YAML o JSON".
  ```

### Tarea 5: Región Viva en Sandbox API (HALL-04) - Prioridad: Should Have
- **Corrección Técnica:** Envolver el área de salida del Sandbox en un contenedor con `role="status"` y `aria-live="polite"`.
- **Criterio de Aceptación (Gherkin):**
  ```gherkin
  Dado que se ejecuta una petición de prueba en el Sandbox interactivo
  Cuando la llamada HTTP simulada finaliza
  Entonces la región con aria-live anuncia el código HTTP obtenido y el resumen del payload.
  ```

### Tarea 6: Corrección de Contraste en Badges HTTP (HALL-02) - Prioridad: Could Have
- **Corrección Técnica:** Actualizar clases CSS con colores certificados con ratio $\ge 4.5:1$.
- **Criterio de Aceptación (Gherkin):**
  ```gherkin
  Dado que se renderizan los badges de métodos HTTP (GET, POST, PUT, DELETE)
  Cuando se analiza el color del texto frente al fondo con un analizador de contraste
  Entonces la relación de contraste resultante es igual o superior a 4.5:1 en todos los casos.
  ```
