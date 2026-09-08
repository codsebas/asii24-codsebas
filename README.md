# ASII-24 — Contratos API y Documentación Técnica

Repositorio personal de evidencia académica correspondiente a la **Asignación ASII-24** del curso de **Análisis de Sistemas II** (Universidad Mariano Gálvez de Guatemala).

Este repositorio concentra y preserva de forma evolutiva los artefactos de diseño, análisis de requerimientos, principios SOLID, micro-monolito vanilla, arquitectura en capas MVC con Repository y la interfaz Cliente-Servidor REST con especificación formal **OpenAPI 3.0** y pruebas en **Postman**, correspondientes al flujo de **publicación y consulta de documentación y manuales diferenciados por rol**.

---

## Información del Estudiante y Módulo

| Campo | Detalle |
|---|---|
| **Estudiante** | **Albino Sebastián Rosales Ruano** |
| **GitHub** | [`codsebas`](https://github.com/codsebas) |
| **Asignación Oficial** | **ASII-24** |
| **Módulo Oficial** | **Contratos API: OpenAPI/Postman y documentación técnica** |
| **Adaptación Académica** | **Centro de documentación y manuales por rol** |
| **Repositorio Personal** | [`asii24-codsebas`](https://github.com/codsebas/asii24-codsebas) |
| **Rama Principal** | `main` |
| **Repositorio Grupal SHI** | [`sistema-hospitalario-integrado-SistenasII-2026`](https://github.com/compilations-teams/sistema-hospitalario-integrado-SistenasII-2026) |

---

## Estructura General del Portafolio

```text
.
├── README.md                           # Portafolio general y tabla de navegación
├── DECLARACION_IA.md                   # Declaración institucional de uso de IA
├── week-01/                            # Semana 1: Delimitación, actores y UML inicial
│   ├── README.md
│   ├── 01-scope-actors-use-cases.md
│   ├── 02-activity-sequence-traceability.md
│   ├── diagrams/                       # SVGs renderizados
│   └── diagrams-code/                  # PlantUML editables
├── week-02/                            # Semana 2: RF/RNF, Criterios y SOLID DIP
│   ├── README.md
│   ├── 01-requirements-and-acceptance-criteria.md
│   └── 02-solid-dependency-inversion.md
├── week-03/                            # Semana 3: Micro-HIS Educativo PHP 8.2+ Vanilla
│   ├── README.md
│   ├── INFORME.md
│   ├── DEFENSA_ORAL.md
│   ├── DECLARACION_IA.md
│   ├── src/                            # Capas Presentation, Application, Domain, Persistence
│   ├── database/                       # Esquema y semillas SQLite
│   └── scripts/run-tests.php           # Pruebas unitarias nativas
├── week-04/                            # Semana 4: Arquitectura en Capas y Patrón Repository
│   ├── README.md
│   ├── INFORME.md
│   ├── DEFENSA_ORAL.md
│   ├── DECLARACION_IA.md
│   ├── src/                            # Capas limpias y controlador delgado (Thin Controller)
│   ├── database/                       # Esquema relacional
│   ├── docs/diagrams/source/           # Diagramas PlantUML de capas y repositorio
│   └── scripts/run-tests.php           # 9/9 Pruebas superadas (InMemory y PDO)
└── week-05/                            # Semana 5: Cliente-Servidor, OpenAPI 3.0, Postman y ADR
    ├── README.md
    ├── INFORME.md
    ├── DEFENSA_ORAL.md
    ├── DECLARACION_IA.md
    ├── contracts/openapi.yaml          # Contrato canónico OpenAPI 3.0.3
    ├── postman/                        # Colección de pruebas de integración y ambientes
    ├── docs/ADR-001-*.md               # Decisión arquitectónica sobre microservicios
    ├── docs/diagrams/source/           # Diagramas de secuencia y frontera de microservicio
    └── scripts/run-tests.php           # 6/6 Pruebas de consistencia de contratos
```

---

## Matriz de Entregables por Semana

| Semana | Tema Académico | Entregables Principales | Estado |
| :---: | :--- | :--- | :---: |
| **Semana 1** | Modelado de Negocio y UML | Casos de uso (`UC-01` a `UC-10`), Diagramas de Actividad y Secuencia, Trazabilidad. | ✅ **Completo** (Mergeado PR #38 en SHI) |
| **Semana 2** | Principios SOLID y Requerimientos | `RF-01` a `RF-10`, `RNF-01` a `RNF-08`, Criterios Dado/Cuando/Entonces, SOLID DIP. | ✅ **Completo** (Mergeado PR #46 en SHI) |
| **Semana 3** | Arquitectura y Micro-Monolito Vanilla | Micro-HIS en PHP 8.2+ vanilla, 4 capas, PDO con sentencias preparadas, tests. | ✅ **Completo** |
| **Semana 4** | Arquitectura en Capas y Patrón Repository | MVC con controlador delgado, interfaz `DocumentRepository`, adaptadores InMemory y PDO, análisis de repositorio compartido. | ✅ **Completo** (9/9 tests pasando) |
| **Semana 5** | Cliente-Servidor, API REST y Contratos | Contrato OpenAPI 3.0, colección Postman automatizada, ADR frontera de microservicio, seguridad JWT y Tenant. | ✅ **Completo** (6/6 tests pasando) |

---

## Reproducibilidad y Validación

Cada semana contiene su propia suite automatizada de pruebas y fuentes editables de diagramas en formato PlantUML:

* **Ejecutar pruebas de Semana 3:** `php week-03/scripts/run-tests.php`
* **Ejecutar pruebas de Semana 4:** `php week-04/scripts/run-tests.php`
* **Ejecutar pruebas de Semana 5:** `php week-05/scripts/run-tests.php`

---

## Autoría y Responsabilidad

**Albino Sebastián Rosales Ruano**  
Estudiante de Ingeniería en Sistemas — Universidad Mariano Gálvez de Guatemala  
GitHub: [`codsebas`](https://github.com/codsebas)
