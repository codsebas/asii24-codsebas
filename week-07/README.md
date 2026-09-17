# ASII-24 — Semana 7: Diseño de Componentes y Refactorización

**Estudiante:** Albino Sebastián Rosales Ruano
**GitHub:** [`codsebas`](https://github.com/codsebas)
**Módulo Oficial:** Contratos API: OpenAPI/Postman y documentación técnica
**Adaptación Académica:** Centro de documentación y manuales por rol
**Repositorio Personal:** [`asii24-codsebas`](https://github.com/codsebas/asii24-codsebas)

---

## 1. Propósito de la Entrega

1. **Diseño de Componentes Backend y Frontend:** Estructurar el ecosistema del módulo ASII-24 en componentes desacoplados con responsabilidades únicas y límites bien definidos.
2. **Refactorización del Punto de Mayor Acoplamiento:** Desacoplar el controlador web respecto al esquema OpenAPI y manejo de errores, introduciendo DTOs inmutables y el estándar RFC 7807 (Problem Details for HTTP APIs).
3. **Contratos de Entrada y Salida:** Formalización de DTOs e interfaces de transporte.
4. **Verificación Automatizada:** Suite de pruebas que certifica la transformación de datos y el manejo uniforme de errores.

---

## 2. Estructura de Entregables

```text
week-07/
├── README.md                           # Ficha técnica de la entrega
├── INFORME.md                          # Informe formal de arquitectura de componentes
├── DEFENSA_ORAL.md                     # Argumentación técnica para evaluación
├── DECLARACION_IA.md                   # Declaración institucional de uso de IA
├── docs/
│   ├── CONTRATOS_ENTRADA_SALIDA.md     # Especificación de DTOs y ProblemDetails
│   └── diagrams/source/
│       ├── components-architecture.puml # Diagrama de componentes backend/frontend
│       └── refactoring-before-after.puml # Comparación visual Antes vs. Después
├── src/
│   ├── ContractDTO.php                 # DTOs de entrada y salida tipados
│   └── ProblemDetails.php              # Transformador desacoplado RFC 7807
└── scripts/
    └── run-tests.php                   # Suite de pruebas automatizadas
```

---

## 3. Instrucciones de Ejecución

Para ejecutar las pruebas de contratos y componentes:

```bash
php docs/asii-24/week-07/scripts/run-tests.php
```
