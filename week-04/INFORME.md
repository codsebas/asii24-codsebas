# Informe Técnico — ASII-24 Semana 4: Arquitectura en Capas y Patrón Repositorio

## 1. Portada y Datos Generales

* **Institución:** Universidad Mariano Gálvez de Guatemala
* **Facultad:** Ingeniería en Sistemas de Información y Ciencias de la Computación
* **Curso:** Análisis de Sistemas II
* **Ciclo:** Octavo Ciclo
* **Estudiante:** Albino Sebastián Rosales Ruano
* **Carné / Usuario:** `codsebas`
* **Módulo Asignado:** ASII-24 — Contratos API: OpenAPI/Postman y documentación técnica
* **Adaptación Académica:** Centro de documentación y manuales por rol
* **Repositorio Oficial:** `https://github.com/codsebas/asii24-codsebas.git`
* **Ruta de Evidencia:** `week-04/`

---

## 2. Índice

1. Portada y Datos Generales
2. Índice
3. Introducción y Contexto
4. Objetivos Técnicos
5. Arquitectura en 4 Capas (Presentation, Application, Domain, Infrastructure)
6. Patrón Repository: Límite, Contrato y Adaptadores
7. Diseño MVC y Controlador Delgado (Thin Controller)
8. Análisis de Integración con un Repositorio de Datos Compartido
9. Diagramas UML de Arquitectura y Persistencia
10. Implementación Técnica y Buenas Prácticas
11. Resultados de la Suite Automatizada de Pruebas
12. Declaración de Uso de Inteligencia Artificial
13. Conclusiones
14. Bibliografía

---

## 3. Introducción y Contexto

Durante las semanas previas se definió el catálogo de casos de uso (Semana 1), la formulación de requisitos funcionales/no funcionales con principios SOLID (Semana 2), y el primer prototipo de micro-monolito en PHP vanilla (Semana 3).

La **Semana 4** exige dar un salto cualitativo hacia una **arquitectura en capas empresarial**, adoptando el patrón **Repository** para desacoplar el almacenamiento de las reglas de negocio, estructurar la entrada bajo el modelo **MVC** mediante controladores delgados, y analizar el impacto arquitectónico de un **repositorio de datos compartido** en un ecosistema hospitalario federado.

---

## 4. Objetivos Técnicos

* Diseñar e implementar una separación estricta en cuatro capas: `Presentation`, `Application`, `Domain` e `Infrastructure`.
* Definir el puerto formal `DocumentRepository` en la capa de aplicación, implementando adaptadores desacoplados para `InMemory` y `PDO`.
* Garantizar que el controlador MVC actúe como un coordinador de transporte HTTP, **eliminando cualquier sentencia SQL o regla de negocio** de su cuerpo.
* Utilizar sentencias preparadas (Prepared Statements) y transacciones para proteger la integridad de los datos contra inyecciones SQL.
* Modelar conceptualmente la integración del módulo con el repositorio central del Sistema Hospitalario Integrado (SHI) respetando el aislamiento entre sedes (CENTRAL vs HOSPITAL).

---

## 5. Arquitectura en 4 Capas

La solución implementa Clean Architecture adaptada a microservicios/módulos:

| Capa | Namespace | Responsabilidad Primaria | Dependencias Permitidas |
| :--- | :--- | :--- | :--- |
| **Domain** | `Week04\Domain` | Entidades (`Document`), Value Objects (`OwnerScope`), excepciones de negocio y validación de invariantes. | **Cero dependencias externas**. PHP Puro. |
| **Application** | `Week04\Application` | Casos de uso (`PublishDocument`, `GetDocumentById`, `ListDocumentsByRole`), DTOs e interfaz `DocumentRepository`. | Depende únicamente de `Domain`. |
| **Infrastructure** | `Week04\Infrastructure` | Adaptadores técnicos de persistencia: `InMemoryDocumentRepository` y `PdoDocumentRepository`. | Depende de `Application` y `Domain`, así como de extensiones del sistema (PDO, SQLite). |
| **Presentation** | `Week04\Presentation` | `DocumentController` y Front Controller (`index.php`): deserialización de requests, mapeo a DTOs y formateo de respuestas JSON. | Depende de `Application` y `Domain`. |

---

## 6. Patrón Repository: Límite, Contrato y Adaptadores

### El Puerto (`DocumentRepository.php`)
Ubicado en el límite de la capa de aplicación, el contrato expone únicamente operaciones de dominio:

```php
interface DocumentRepository
{
    public function save(Document $document): void;
    public function findById(string $id): ?Document;
    public function existsCode(string $code): bool;
    public function findByRole(string $role): array;
}
```

### Los Adaptadores:
1. **`InMemoryDocumentRepository`**: Almacena las entidades en un arreglo asociativo en memoria. Proporciona determinismo absoluto, ejecución en milisegundos y cero efectos secundarios para pruebas unitarias.
2. **`PdoDocumentRepository`**: Utiliza sentencias preparadas de PDO, transacciones ACID para operaciones multitabla (`documents` y `document_roles`) y mapeo a entidades de dominio inmutables.

---

## 7. Diseño MVC y Controlador Delgado (Thin Controller)

El controlador `DocumentController` cumple estrictamente con el principio de responsabilidad única:
* **Entrada:** Recibe arreglos asociativos simulando el cuerpo de la petición.
* **Coordinación:** Instancia DTOs tipados e invoca al caso de uso correspondiente.
* **Transformación:** Atrapa excepciones de dominio y las traduce a códigos de estado HTTP estandarizados:
  - `201 Created`: Publicación exitosa.
  - `200 OK`: Consulta o listado exitoso.
  - `403 Forbidden`: Intento de consulta por un rol no autorizado.
  - `404 Not Found`: Identificador inexistente.
  - `409 Conflict`: Código de documento duplicado.
  - `422 Unprocessable Entity`: Violación de invariantes de negocio.
* **Sin SQL:** No existen sentencias `SELECT`, `INSERT` ni acoplamiento al motor de base de datos.

---

## 8. Análisis de Integración con un Repositorio de Datos Compartido

En el contexto del Sistema Hospitalario Integrado (SHI), coexisten dos niveles de autoridad de datos:
1. **CENTRAL:** Repositorio de metadatos globales, políticas normativas, contratos API y gobernanza.
2. **HOSPITAL:** Repositorio local clínico y operativo de cada hospital.

### Reglas de Integración Federada:
* **Identificadores Lógicos (UUID):** El módulo ASII-24 utiliza `hospital_uuid` como identificador lógico. **Está prohibido el uso de Foreign Keys físicas remotas** a través de la red, ya que introducirían un punto único de fallo y acoplamiento distribuido.
* **Aislamiento Multitenant:** Los documentos de alcance `HOSPITAL` solo pueden ser consultados por personal asignado a ese hospital específico. Los documentos normativos de alcance `CENTRAL` son compartidos y replicados de forma asíncrona.
* **Tolerancia a Particiones de Red:** Si la red central se desconecta, el repositorio local del hospital continúa operando y atendiendo consultas locales sin bloquear la atención médica.

---

## 9. Diagramas UML de Arquitectura y Persistencia

Las fuentes editables PlantUML se encuentran disponibles en:
* `docs/diagrams/source/layers-architecture.puml`: Vista general de las cuatro capas y flujo de llamadas.
* `docs/diagrams/source/repository-pattern.puml`: Diagrama de clases con la interfaz y sus dos adaptadores concretos.
* `docs/diagrams/source/shared-data-repository.puml`: Diagrama de secuencia y arquitectura que ilustra la integración con el repositorio de datos compartido federado.

---

## 10. Resultados de la Suite Automatizada de Pruebas

Se ejecutó la suite mediante el comando `php week-04/scripts/run-tests.php`, obteniendo un 100% de éxito:

```text
=== ASII-24 Semana 4: Suite de Pruebas Unitarias y de Integracion ===

--- 1. Pruebas de Dominio ---
  [PASS] Crea entidad Document con datos validos para alcance CENTRAL
  [PASS] Rechaza documento con alcance HOSPITAL sin hospitalUuid
  [PASS] Rechaza documento sin roles autorizados

--- 2. Pruebas de Repositorio InMemory y Casos de Uso ---
  [PASS] Publica un documento y lo almacena mediante InMemoryDocumentRepository
  [PASS] Impide registrar documentos con codigo duplicado
  [PASS] Consulta documento por ID validando autorizacion del rol

--- 3. Pruebas de Persistencia PDO con Sentencias Preparadas ---
  [PASS] Persiste y recupera un documento en base de datos SQLite con PDO

--- 4. Pruebas del Controlador MVC (Sin SQL ni reglas de negocio) ---
  [PASS] El controlador procesa publicacion y retorna respuesta HTTP 201 estructurada
  [PASS] El controlador maneja denegacion de acceso retornando 403

=======================================================
RESULTADOS FINALES: 9 superadas, 0 fallidas.
=======================================================
```

---

## 11. Conclusiones

1. La separación de responsabilidades en 4 capas desacopla totalmente las reglas de negocio del mecanismo de persistencia y del framework de transporte.
2. El patrón Repository permite intercambiar implementaciones de persistencia (InMemory para testing, PDO/PostgreSQL para producción) sin modificar una sola línea de lógica de aplicación.
3. El diseño del controlador MVC delgado previene el anti-patrón de "Fat Controller" y garantiza mantenibilidad a largo plazo ante futuras migraciones o actualizaciones de versión de Laravel/PHP.

---

## 12. Bibliografía

* Martin, R. C. (2018). *Clean Architecture: A Craftsman's Guide to Software Structure and Design*. Prentice Hall.
* Evans, E. (2004). *Domain-Driven Design: Tackling Complexity in the Heart of Software*. Addison-Wesley.
* Fowler, M. (2002). *Patterns of Enterprise Application Architecture*. Addison-Wesley.
* The PHP Group. (2024). *PHP Data Objects (PDO) Documentation*. https://www.php.net/manual/es/book.pdo.php
