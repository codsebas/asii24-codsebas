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
├── week-05/                            # Semana 5: Cliente-Servidor, OpenAPI 3.0, Postman y ADR
│   ├── README.md
│   ├── INFORME.md
│   ├── DEFENSA_ORAL.md
│   ├── DECLARACION_IA.md
│   ├── contracts/openapi.yaml          # Contrato canónico OpenAPI 3.0.3
│   ├── postman/                        # Colección de pruebas de integración y ambientes
│   ├── docs/ADR-001-*.md               # Decisión arquitectónica sobre microservicios
│   ├── docs/diagrams/source/           # Diagramas de secuencia y frontera de microservicio
│   └── scripts/run-tests.php           # 6/6 Pruebas de consistencia de contratos
├── week-06/                            # Semana 6: Primer Parcial: Defensa y Cambio Práctico
├── week-07/                            # Semana 7: Diseño de Componentes y Refactorización
├── week-08/                            # Semana 8: Diseño de Experiencia de Usuario (UX)
│   ├── README.md
│   ├── INFORME.md
│   ├── DEFENSA_ORAL.md
│   ├── DECLARACION_IA.md
│   ├── docs/USER_FLOW_ROLES.md         # User flows por rol (Admin, Médico, Auditor)
│   ├── docs/WIREFRAMES_ANOTADOS.md     # 5 Wireframes anotados con ciclo de 5 estados
│   ├── docs/diagrams/source/           # Diagramas PlantUML de actividades y navegación
│   └── scripts/run-validation.php      # 23/23 Pruebas automatizadas superadas
├── week-09/                            # Semana 9: Evaluación de Usabilidad y Accesibilidad WCAG
│   ├── README.md
│   ├── INFORME.md
│   ├── DEFENSA_ORAL.md
│   ├── DECLARACION_IA.md
│   ├── docs/CHECKLIST_USABILIDAD_WCAG.md # Checklist de Nielsen y WCAG 2.1 AA
│   ├── docs/HALLAZGOS_ACCESIBILIDAD.md   # 6 Hallazgos técnicos de accesibilidad
│   ├── docs/BACKLOG_PRIORIZADO.md        # Backlog MoSCoW con criterios Gherkin
│   ├── docs/diagrams/source/             # PlantUML (flujo de foco accesible)
│   └── scripts/run-validation.php        # 40/40 Pruebas automatizadas superadas
├── week-10/                            # Semana 10: Diseño para Movilidad en Salud
│   ├── README.md
│   ├── INFORME.md
│   ├── DEFENSA_ORAL.md
│   ├── DECLARACION_IA.md
│   ├── docs/RESPONSIVE_BREAKPOINTS_SPEC.md # Breakpoints 320-430px y Thumb Zone
│   ├── docs/PANTALLAS_MOVILES_ANOTADAS.md  # 4 Pantallas móviles táctiles
│   ├── docs/ESCENARIOS_MOVILES_DECISIONES.md # 2 Escenarios offline y red degradada
│   ├── docs/diagrams/source/               # PlantUML (arquitectura de navegación móvil)
│   └── scripts/run-validation.php          # 25/25 Pruebas automatizadas superadas
└── week-11/                            # Semana 11: Prototipo Navegable Móvil/Web
    ├── README.md
    ├── INFORME.md
    ├── DEFENSA_ORAL.md
    ├── DECLARACION_IA.md
    ├── prototype/index.html            # Prototipo interactivo SPA HTML5/CSS3/JS
    ├── docs/MAPA_NAVEGACION.md         # Árbol de navegación y matriz de estados
    ├── docs/EVIDENCIA_CAPTURAS.md      # Evidencia desktop/móvil Happy & Error Path
    ├── docs/diagrams/source/           # PlantUML (grafo de navegación del prototipo)
    └── scripts/run-validation.php      # 26/26 Pruebas automatizadas superadas
```

---

## Matriz de Entregables por Semana

| Semana | Tema Académico | Entregables Principales | Estado |
| :---: | :--- | :--- | :---: |
| **Semana 1** | Modelado de Negocio y UML | Casos de uso (`UC-01` a `UC-10`), Diagramas de Actividad y Secuencia, Trazabilidad. | ✅ **Completo** (Mergeado PR #38 en SHI) |
| **Semana 2** | Principios SOLID y Requerimientos | `RF-01` a `RF-10`, `RNF-01` a `RNF-08`, Criterios Dado/Cuando/Entonces, SOLID DIP. | ✅ **Completo** (Mergeado PR #46 en SHI) |
| **Semana 3** | Arquitectura y Micro-Monolito Vanilla | Micro-HIS en PHP 8.2+ vanilla, 4 capas, PDO con sentencias preparadas, tests. | ✅ **Completo** (Mergeado PR #72 en SHI - 6/6 tests) |
| **Semana 4** | Arquitectura en Capas y Patrón Repository | MVC con controlador delgado, interfaz `DocumentRepository`, adaptadores InMemory y PDO, análisis de repositorio compartido. | ✅ **Completo** (Integrado vía PR #73 en SHI - 9/9 tests) |
| **Semana 5** | Cliente-Servidor, API REST y Contratos | Contrato OpenAPI 3.0, colección Postman automatizada, ADR frontera de microservicio, seguridad JWT y Tenant. | ✅ **Completo** (Mergeado PR #342 y #346 en SHI - 6/6 tests) |
| **Semana 6** | Primer Parcial: Defensa Arquitectónica y Cambio Práctico | Presentación de 8 slides, matriz decisión->evidencia, impacto cambio práctico, diagramas y validación E2E. | ✅ **Completo** (Mergeado PR #350 en SHI - 6/6 tests) |
| **Semana 7** | Diseño de Componentes y Refactorización | Arquitectura de componentes backend/frontend, contratos DTOs, ProblemDetails RFC 7807 y desacoplamiento Ce=2. | ✅ **Completo** (Mergeado PR #353 en SHI - 6/6 tests) |
| **Semana 8** | Diseño de Experiencia de Usuario (UX) | User flows por rol, 5 wireframes anotados con 5 estados, protección de datos y diagramas de navegación. | ✅ **Completo** (Mergeado PR #355 en SHI - 23/23 tests) |
| **Semana 9** | Evaluación de Usabilidad y Accesibilidad | Checklist Nielsen/WCAG 2.1 AA, 6 hallazgos documentados, backlog MoSCoW con criterios Gherkin. | ✅ **Completo** (Mergeado PR #357 en SHI - 40/40 tests) |
| **Semana 10** | Diseño para Movilidad en Salud | Adaptación 320–430px, 4 pantallas táctiles, touch targets $\ge 48\text{px}$, resiliencia offline. | ✅ **Completo** (Mergeado PR #488 en SHI - 25/25 tests) |
| **Semana 11** | Prototipo Navegable Móvil/Web | SPA interactiva autónoma, Happy Path (HTTP 200), Error Crítico RFC 7807 (HTTP 422), offline cache y responsive. | ✅ **Completo** (Sometido vía PR #490 en SHI - 26/26 tests) |

---

## Trazabilidad e Integración con Repositorio Grupal (SHI)

Todas las entregas individuales se integran progresivamente al repositorio grupal ([`sistema-hospitalario-integrado-SistenasII-2026`](https://github.com/compilations-teams/sistema-hospitalario-integrado-SistenasII-2026)) hacia la rama `develop` mediante Pull Requests aislados por semana creados desde ramas worktree dedicadas:

| Semana | Rama Worktree Grupal | Pull Request SHI | Estado de Integración |
| :---: | :--- | :---: | :---: |
| **Semana 1** | `feature/asii-24-contratos-api-openapi-postman-y-documentac-codsebas` | [PR #38](https://github.com/compilations-teams/sistema-hospitalario-integrado-SistenasII-2026/pull/38) | 🟢 **MERGED** (`develop`) |
| **Semana 2** | `feature/asii-24-contratos-api-openapi-postman-y-documentac-codsebas` | [PR #46](https://github.com/compilations-teams/sistema-hospitalario-integrado-SistenasII-2026/pull/46) | 🟢 **MERGED** (`develop`) |
| **Semana 3** | `feature/asii-24-semana-03-micro-his-codsebas` | [PR #72](https://github.com/compilations-teams/sistema-hospitalario-integrado-SistenasII-2026/pull/72) | 🟢 **MERGED** (`develop`) |
| **Semana 4** | `feature/asii-24-semana-04-mvc-repository-codsebas` | [PR #73](https://github.com/compilations-teams/sistema-hospitalario-integrado-SistenasII-2026/pull/73) | 🟢 **MERGED** (`develop`) |
| **Semana 5 (1/2)** | `feature/asii-24-semana-05-parte-1-openapi-postman-codsebas` | [PR #342](https://github.com/compilations-teams/sistema-hospitalario-integrado-SistenasII-2026/pull/342) | 🟢 **MERGED** (`develop`) |
| **Semana 5 (2/2)** | `feature/asii-24-semana-05-parte-2-adr-diagramas-codsebas` | [PR #346](https://github.com/compilations-teams/sistema-hospitalario-integrado-SistenasII-2026/pull/346) | 🟢 **MERGED** (`develop`) |
| **Semana 6** | `feature/asii-24-semana-06-parcial-defensa-codsebas` | [PR #350](https://github.com/compilations-teams/sistema-hospitalario-integrado-SistenasII-2026/pull/350) | 🟢 **MERGED** (`develop`) |
| **Semana 7** | `feature/asii-24-semana-07-componentes-refactor-codsebas` | [PR #353](https://github.com/compilations-teams/sistema-hospitalario-integrado-SistenasII-2026/pull/353) | 🟢 **MERGED** (`develop`) |
| **Semana 8** | `feature/asii-24-semana-08-diseno-ux-codsebas` | [PR #355](https://github.com/compilations-teams/sistema-hospitalario-integrado-SistenasII-2026/pull/355) | 🟢 **MERGED** (`develop`) |
| **Semana 9** | `feature/asii-24-semana-09-usabilidad-accesibilidad-codsebas` | [PR #357](https://github.com/compilations-teams/sistema-hospitalario-integrado-SistenasII-2026/pull/357) | 🟢 **MERGED** (`develop`) |
| **Semana 10** | `feature/asii-24-semana-10-movilidad-codsebas` | [PR #488](https://github.com/compilations-teams/sistema-hospitalario-integrado-SistenasII-2026/pull/488) | 🟢 **MERGED** (`develop`) |
| **Semana 11** | `feature/asii-24-semana-11-prototipo-codsebas` | [PR #490](https://github.com/compilations-teams/sistema-hospitalario-integrado-SistenasII-2026/pull/490) | 🟡 **ABIERTO / EN REVISIÓN** (`develop`) |

---

## Reproducibilidad y Validación

Cada semana contiene su propia suite automatizada de pruebas y fuentes editables de diagramas en formato PlantUML:

* **Ejecutar pruebas de Semana 3:** `php week-03/scripts/run-tests.php`
* **Ejecutar pruebas de Semana 4:** `php week-04/scripts/run-tests.php`
* **Ejecutar pruebas de Semana 5:** `php week-05/scripts/run-tests.php`
* **Ejecutar pruebas de Semana 6:** `php week-06/scripts/run-validation.php`
* **Ejecutar pruebas de Semana 7:** `php week-07/scripts/run-tests.php`
* **Ejecutar pruebas de Semana 8:** `php week-08/scripts/run-validation.php`
* **Ejecutar pruebas de Semana 9:** `php week-09/scripts/run-validation.php`
* **Ejecutar pruebas de Semana 10:** `php week-10/scripts/run-validation.php`
* **Ejecutar pruebas de Semana 11:** `php week-11/scripts/run-validation.php`

---

## Autoría y Responsabilidad

**Albino Sebastián Rosales Ruano**
Estudiante de Ingeniería en Sistemas — Universidad Mariano Gálvez de Guatemala
GitHub: [`codsebas`](https://github.com/codsebas)
