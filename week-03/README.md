# ASII-24 - Semana 3

**Estudiante:** Albino Sebastian Rosales Ruano
**GitHub:** [`codsebas`](https://github.com/codsebas)
**Modulo oficial:** Contratos API: OpenAPI/Postman y documentacion tecnica
**Adaptacion academica:** Centro de documentacion y manuales por rol
**Integracion SHI:** [PR #72 (MERGED)](https://github.com/compilations-teams/sistema-hospitalario-integrado-SistenasII-2026/pull/72)
**Rama en SHI:** `feature/asii-24-semana-03-micro-his-codsebas`

## Proposito

Implementar un micro-monolito educativo en PHP 8.2+ vanilla para publicar y consultar documentacion tecnica visible por rol.

## Alcance funcional

- publicar documentos tecnicos ficticios;
- asignar roles autorizados por documento;
- listar documentos visibles por rol;
- consultar el detalle de un documento autorizado;
- denegar accesos no autorizados;
- manejar errores de persistencia de forma segura.

## Arquitectura

El proyecto usa separacion conceptual en cuatro capas:

- `Presentation`: entrada HTTP simple y salida JSON;
- `Application`: casos de uso y coordinacion;
- `Domain`: reglas, entidad y excepciones;
- `Persistence`: repositorio PDO con sentencias preparadas.

## Estructura

```text
week-03/
├── README.md
├── INFORME.md
├── DECLARACION_IA.md
├── DEFENSA_ORAL.md
├── docs/
├── src/
├── config/
├── database/
├── public/
├── tests/
└── scripts/
```

## Requisitos

- PHP 8.2+;
- extensiones PDO y SQLite;
- servidor web o `php -S`;
- permisos para crear la base local de pruebas.

## Configuracion

1. Copiar `config/database.example.php` a `config/database.php` si se desea una configuracion local separada.
2. Ajustar la ruta de la base SQLite segun el entorno.
3. Mantener fuera del control de Git cualquier archivo SQLite generado.

## Inicializacion de base de datos

El esquema y los datos ficticios estan en:

- `database/schema.sql`
- `database/seed.sql`

Tambien se incluye `scripts/init-db.php` para crear la base local.

## Ejecucion

```bash
php -S localhost:8000 -t week-03/public
```

Flujos disponibles:

- `GET /documents?role=Medico`
- `GET /documents/1?role=Medico`
- `POST /documents`

## Pruebas

```bash
php week-03/scripts/run-tests.php
```

## Flujo implementado

El caso principal publica un documento, guarda sus roles autorizados y permite su consulta solo a roles incluidos en la regla de visibilidad.

## Limitaciones conocidas

- No hay renderizado automatico de PlantUML en este entorno porque el binario `plantuml` no esta disponible.
- La persistencia usa SQLite local para mantener el ejemplo simple.
- No se manejan usuarios reales ni datos clinicos.
