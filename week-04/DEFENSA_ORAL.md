# Guía de Defensa Técnica Oral — ASII-24 Semana 4

**Estudiante:** Albino Sebastián Rosales Ruano  
**Módulo:** ASII-24 — Centro de documentación y manuales por rol  

---

## Preguntas Clave para la Defensa y Respuestas Justificadas

### 1. ¿Por qué se implementó el patrón Repository en lugar de consultar directamente la base de datos desde el Controlador o Caso de Uso?
**Respuesta:**
Para aplicar el **Principio de Inversión de Dependencias (DIP)**. La capa de aplicación define el contrato (`DocumentRepository`) que necesita para operar, y la capa de infraestructura lo satisface. Esto permite:
* Intercambiar el motor de persistencia (ej. migrar de SQLite a PostgreSQL o MongoDB) sin modificar una sola línea de lógica de negocio.
* Realizar pruebas unitarias ultrarrápidas y aisladas mediante el adaptador `InMemoryDocumentRepository`, sin necesidad de levantar bases de datos ni depender de I/O.

### 2. ¿Cómo se garantiza que el Controlador MVC no contenga lógica de negocio ni SQL?
**Respuesta:**
El controlador actúa estrictamente como un adaptador de transporte:
* Solo se encarga de leer el input HTTP, instanciar un DTO (`PublishDocumentInput`), llamar al caso de uso (`PublishDocument`) y traducir las excepciones de dominio a códigos de respuesta HTTP (`201`, `403`, `404`, `409`, `422`).
* Cualquier regla de negocio (como verificar si un documento puede ser leído por un rol o validar que tenga título) reside en la entidad `Document` o en el caso de uso.
* Las sentencias SQL residen exclusivamente en `PdoDocumentRepository`.

### 3. ¿Cómo se integraría este módulo con un repositorio de datos compartido en un entorno hospitalario?
**Respuesta:**
Mediante una arquitectura **federada**:
* Los datos normativos globales se almacenan en el repositorio **CENTRAL** y se replican hacia los hospitales.
* Los manuales y procedimientos locales de cada hospital se gestionan con un identificador lógico `hospital_uuid`.
* **No existen claves foráneas (FK) directas entre servidores remotos**. Esto garantiza que si la conexión con el nodo central cae, el hospital sigue funcionando de manera autónoma y tolerante a fallos.
