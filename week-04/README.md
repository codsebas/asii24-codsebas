# ASII-24 — Semana 4: Arquitectura en Capas y Patrón Repositorio

**Estudiante:** Albino Sebastián Rosales Ruano  
**GitHub:** [`codsebas`](https://github.com/codsebas)  
**Módulo Oficial:** Contratos API: OpenAPI/Postman y documentación técnica  
**Adaptación Académica:** Centro de documentación y manuales por rol  
**Repositorio Personal:** [`asii24-codsebas`](https://github.com/codsebas/asii24-codsebas)  

---

## 1. Propósito de la Entrega

Consolidar y evolucionar el **Micro-HIS Contratos API** organizando la entrada mediante el patrón **MVC**, desacoplando la persistencia mediante una interfaz **Repository** formal, implementando adaptadores para **InMemory** y **PDO** (con sentencias preparadas), garantizando un controlador delgado libre de SQL y reglas de negocio, y analizando la integración con un repositorio de datos compartido federado.

---

## 2. Estructura de Capas y Componentes

```text
week-04/
├── README.md                           # Guía general de la entrega
├── INFORME.md                          # Informe técnico formal académico
├── DECLARACION_IA.md                   # Declaración de asistencia con IA
├── DEFENSA_ORAL.md                     # Argumentación técnica para evaluación
├── config/                             # Configuración de base de datos
│   └── database.example.php
├── database/                           # Esquema relacional y datos semilla
│   ├── schema.sql
│   └── seed.sql
├── docs/                               # Diagramas y modelos editables
│   └── diagrams/source/
│       ├── layers-architecture.puml    # Arquitectura en 4 capas y MVC
│       ├── repository-pattern.puml     # Patrón Repository y desacoplamiento
│       └── shared-data-repository.puml # Integración con repositorio compartido
├── public/                             # Front controller y enrutamiento
│   └── index.php
├── scripts/                            # Utilidades operativas y pruebas
│   ├── init-db.php                     # Inicializador de base de datos SQLite
│   └── run-tests.php                   # Suite automatizada de pruebas
└── src/
    ├── Domain/                         # Reglas de negocio puras
    │   ├── Document.php                # Entidad de dominio
    │   ├── OwnerScope.php              # Enum de alcance (CENTRAL / HOSPITAL)
    │   └── Exceptions/                 # Excepciones de negocio
    │       ├── DomainRuleViolation.php
    │       ├── DocumentNotFoundException.php
    │       └── DuplicateDocumentException.php
    ├── Application/                    # Casos de uso y contratos de puerto
    │   ├── Contracts/
    │   │   └── DocumentRepository.php  # Interfaz del repositorio
    │   ├── DTO/
    │   │   ├── DocumentData.php        # DTO de salida
    │   │   └── PublishDocumentInput.php# DTO de entrada
    │   └── UseCases/
    │       ├── PublishDocument.php     # Publicación con validación
    │       ├── GetDocumentById.php     # Consulta con control de rol
    │       └── ListDocumentsByRole.php # Listado filtrado por rol
    ├── Infrastructure/                 # Adaptadores técnicos
    │   └── Repositories/
    │       ├── InMemoryDocumentRepository.php # Adaptador para testing
    │       └── PdoDocumentRepository.php      # Adaptador relacional PDO
    └── Presentation/                   # Interfaz de entrada MVC
        └── Controllers/
            └── DocumentController.php  # Controlador delgado sin SQL
```

---

## 3. Instrucciones de Inicialización y Ejecución

### Requisitos:
* PHP 8.2 o superior con extensiones `pdo` y `pdo_sqlite` habilitadas.

### Inicializar base de datos SQLite con semillas:
```bash
php week-04/scripts/init-db.php
```

### Ejecutar suite completa de pruebas:
```bash
php week-04/scripts/run-tests.php
```

### Iniciar servidor web de pruebas:
```bash
php -S localhost:8000 -t week-04/public
```

---

## 4. Evidencia de Ejecución de Pruebas

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
