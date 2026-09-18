# Mapa de Navegación y Transición de Estados - ASII-24

Este documento define la arquitectura de navegación, árbol de rutas y flujo de estados del prototipo interactivo (`prototype/index.html`).

---

## 1. Árbol de Rutas y Transiciones

El prototipo implementa una máquina de estados determinista gobernada por roles y contexto de conectividad:

```mermaid
graph TD
    A[Inicio: Header Común] --> B{Selector de Rol}
    B -->|Médico / Enfermería| C[Vista: Manuales Clínicos]
    B -->|Auditor / Desarrollador| D[Vista: API Explorer & Sandbox]
    B -->|Admin / Publisher| E[Vista: Publicador SemVer]

    C --> C1[Búsqueda Contextual / Filtros]
    C1 --> C2[Lector de Procedimiento]
    C2 --> C3{Estado de Red}
    C3 -->|Online| C4[Contenido Servidor]
    C3 -->|Offline| C5[Contenido Caché Local]

    D --> D1[Seleccionar Endpoint OpenAPI]
    D1 --> D2[Probar Endpoint Try It Out]
    D2 --> D3{Validar Red}
    D3 -->|Online| D4[HTTP 200 OK: ContractDTO Sanitizado]
    D3 -->|Offline| D5[HTTP 504 Timeout: RFC 7807 + Retry]

    E --> E1[Cargar Contrato y Changelog]
    E1 --> E2{Incremento SemVer}
    E2 -->|Patch / Minor| E3[Publicación Directa]
    E2 -->|Major Breaking| E4[Bottom Sheet Error 422: Confirmación Crítica]
    E4 -->|Confirmar V3.0.0| E5[Éxito: Contrato Publicado]
    E4 -->|Cancelar| E1
```

---

## 2. Matriz de Estados de la Interfaz

| Estado UI | Evento Detonador | Componente Visual | Retroalimentación Accesible |
| :--- | :--- | :--- | :--- |
| **`INITIAL`** | Carga inicial de la aplicación | Hub renderizado según rol activo | Título de página anunciado al lector de pantalla |
| **`LOADING`** | Pulsación de "Try It Out" | Caja de estado con indicador animado | Región `aria-live="polite"` anuncia "Ejecutando..." |
| **`SUCCESS`** | Simulación de endpoint exitosa | Contenedor verde con JSON formateado | Badge HTTP 200 OK y botón de copia rápida |
| **`CRITICAL_ERROR`** | Intento de publicar Major sin texto | Bottom Sheet emergente con RFC 7807 | Atributo `aria-invalid="true"`, foco en input y `role="alert"` |
| **`OFFLINE`** | Caída de conexión simulada | Píldora ámbar `[ ▲ MODO OFFLINE ]` | Transición a copia local en Service Worker cache |
