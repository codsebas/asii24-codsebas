# Especificación de Breakpoints y Diseño Adaptativo - ASII-24

Matriz técnica de adaptabilidad para el Centro de Documentación y Manuales por Rol.

---

## 1. Matriz de Breakpoints y Comportamiento de Layout

| Identificador | Rango de Viewport | Dispositivos Objetivo | Comportamiento del Layout |
| :--- | :---: | :--- | :--- |
| **`mobile-compact`** | **320px – 430px** | iPhone SE, iPhone 13 mini, Galaxy A series | 1 columna, 100% ancho, márgenes 12px, Bottom Bar de 56px, Data Cards |
| **`mobile-regular`** | **431px – 767px** | iPhone 15 Pro Max, Galaxy S24 Ultra | 1 columna amplia, márgenes 16px, acordeones dobles |
| **`tablet-split`** | **768px – 1023px** | iPad 10th gen, Galaxy Tab A8 | 2 columnas (35% menú / 65% visor de manual o contrato) |
| **`desktop-full`** | **1024px+** | Monitores de enfermería y PCs de escritorio | 3 columnas (Sidebar, explorador de schemas, sandbox interactivo) |

---

## 2. Especificación de Ergonomía Táctil Móvil (320–430 px)

### 2.1. Zonas de Toque (Touch Targets)
- **Dimensión mínima:** Todos los botones, enlaces interactivos, selectores y controles de acordeón poseen un área táctil mínima de **$48 \times 48\text{ px}$** (cumpliendo WCAG 2.5.5 Nivel AAA y Apple Human Interface Guidelines).
- **Zona del Pulgar (Thumb Zone):** Disposición de controles críticos en el tercio inferior de la pantalla para garantizar alcance con una sola mano.
- **Separación entre controles:** Margen mínimo de **8 px** entre botones adyacentes para erradicar activaciones involuntarias.

### 2.2. Escala Tipográfica Móvil
- **Títulos principales (H1):** `20px / 1.25rem`, negrita, interlineado compacto.
- **Subtítulos y Headers de Sección (H2):** `16px / 1.0rem`, seminegrita.
- **Texto de párrafo y contenido de manuales:** `15px - 16px` para garantizar legibilidad a 30 cm de distancia y prevenir zoom automático en inputs móviles.
- **Etiquetas de métodos HTTP y metadatos:** `12px / 0.75rem`, mayúsculas sostenidas, fuente monoespaciada de alto contraste.

---

## 3. Patrones de Navegación Móvil

1. **Bottom Navigation Bar Fija:** Altura de 56px, anclada en la base con `z-index: 1000`. Dispone de 4 accesos directos: `[ Inicio ]`, `[ Manuales ]`, `[ API Explorer ]` y `[ Perfil ]`.
2. **Bottom Sheet Modal:** Cubre entre el 50% y el 80% del viewport inferior, con un control táctil superior (*drag handle*) y botón de cierre accesible.
3. **Píldora de Estado de Red (*Network Pill*):** Indicador visual superior derecho de 24px de altura con texto conciso y color semántico.
