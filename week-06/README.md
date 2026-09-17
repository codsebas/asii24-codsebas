# ASII-24 — Semana 6: Primera Evaluación Parcial y Defensa Arquitectónica

**Estudiante:** Albino Sebastián Rosales Ruano
**GitHub:** [`codsebas`](https://github.com/codsebas)
**Módulo Oficial:** Contratos API: OpenAPI/Postman y documentación técnica
**Adaptación Académica:** Centro de documentación y manuales por rol
**Repositorio Personal:** [`asii24-codsebas`](https://github.com/codsebas/asii24-codsebas)
**Evaluación:** Primer Parcial — Defensa de Arquitectura y Cambio Práctico

---

## 1. Propósito de la Evaluación

Consolidar, justificar y defender formalmente la arquitectura de software construida para el módulo **ASII-24** a lo largo de las Semanas 1 a 5, evidenciando:
1. **Hilo conductor continuo:** Desde la captura de casos de uso y requerimientos hasta la persistencia desacoplada y contratos OpenAPI 3.0 / Postman.
2. **Matriz Decisión → Evidencia:** Justificación de cada patrón aplicado frente a criterios de calidad ISO/IEC 25010.
3. **Respuesta ante Cambio Práctico:** Demostración de extensibilidad ante el ciclo de vida documental (`DRAFT`, `PUBLISHED`, `DEPRECATED`) y el rol `AuditorExterno`.
4. **Verificación automatizada:** Script nativo de validación de consistencia de artefactos.

---

## 2. Estructura de Entregables

```text
week-06/
├── README.md                           # Ficha ejecutiva de la evaluación parcial
├── INFORME.md                          # Presentación formal (8 diapositivas estructuradas)
├── DEFENSA_ORAL.md                     # Cuestionario y argumentación para examen oral
├── DECLARACION_IA.md                   # Declaración institucional de uso de IA
├── docs/
│   ├── MATRIZ_DECISION_EVIDENCIA.md    # Matriz trazable: Requisito -> Decisión -> Código
│   ├── CAMBIO_PRACTICO.md              # Especificación y diseño del cambio práctico
│   └── diagrams/source/
│       ├── traceability-architecture.puml # Trazabilidad integral E2E
│       └── practical-change-impact.puml   # Impacto del cambio en contratos y roles
└── scripts/
    └── run-validation.php              # Suite de validación de consistencia E2E
```

---

## 3. Instrucciones de Validación

Para ejecutar la verificación automatizada de trazabilidad y consistencia:

```bash
php docs/asii-24/week-06/scripts/run-validation.php
```
