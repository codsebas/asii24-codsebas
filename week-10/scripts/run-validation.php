<?php
/**
 * Suite de validacion automatizada de diseno para movilidad - Semana 10
 * Modulo: ASII-24 - Centro de Documentacion y Manuales por Rol
 * Autor: Albino Sebastian Rosales Ruano (codsebas)
 */

declare(strict_types=1);

final class MobileValidationSuite
{
    private int $passed = 0;
    private int $failed = 0;

    public function run(): int
    {
        echo "=== INICIANDO VALIDACION DE DISENO PARA MOVILIDAD SEMANA 10 (ASII-24) ===" . PHP_EOL . PHP_EOL;

        $baseDir = dirname(__DIR__);
        $this->testFileStructure($baseDir);
        $this->testResponsiveBreakpoints($baseDir);
        $this->testMobileScreensAnnotated($baseDir);
        $this->testMobileScenariosAndDecisions($baseDir);
        $this->testTouchTargetsAndErgonomics($baseDir);
        $this->testPlantUmlDiagrams($baseDir);

        echo PHP_EOL . "=================================================================" . PHP_EOL;
        echo sprintf("Resultado final: %d exitosas, %d fallidas" . PHP_EOL, $this->passed, $this->failed);
        echo "=================================================================" . PHP_EOL;

        return $this->failed === 0 ? 0 : 1;
    }

    private function assert(bool $condition, string $description): void
    {
        if ($condition) {
            $this->passed++;
            echo " [OK] " . $description . PHP_EOL;
        } else {
            $this->failed++;
            echo " [FAIL] " . $description . PHP_EOL;
        }
    }

    private function testFileStructure(string $baseDir): void
    {
        echo "--- Verificando Estructura de Entregables Semana 10 ---" . PHP_EOL;
        $files = [
            'README.md',
            'INFORME.md',
            'DEFENSA_ORAL.md',
            'DECLARACION_IA.md',
            'docs/RESPONSIVE_BREAKPOINTS_SPEC.md',
            'docs/PANTALLAS_MOVILES_ANOTADAS.md',
            'docs/ESCENARIOS_MOVILES_DECISIONES.md',
            'docs/diagrams/source/mobile-navigation-flow.puml'
        ];

        foreach ($files as $file) {
            $path = $baseDir . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $file);
            $this->assert(file_exists($path), "Archivo requerido existe: {$file}");
        }
    }

    private function testResponsiveBreakpoints(string $baseDir): void
    {
        echo PHP_EOL . "--- Verificando Especificacion de Breakpoints ---" . PHP_EOL;
        $path = $baseDir . DIRECTORY_SEPARATOR . 'docs' . DIRECTORY_SEPARATOR . 'RESPONSIVE_BREAKPOINTS_SPEC.md';
        $content = file_exists($path) ? (string)file_get_contents($path) : '';

        $this->assert(strpos($content, '320px') !== false && strpos($content, '430px') !== false, "Especifica rango móvil prioritario 320px - 430px");
        $this->assert(strpos($content, '768px') !== false, "Especifica breakpoint de tablet 768px");
        $this->assert(strpos($content, '1024px') !== false, "Especifica breakpoint de escritorio 1024px");
    }

    private function testMobileScreensAnnotated(string $baseDir): void
    {
        echo PHP_EOL . "--- Verificando 4 Pantallas Móviles Anotadas ---" . PHP_EOL;
        $path = $baseDir . DIRECTORY_SEPARATOR . 'docs' . DIRECTORY_SEPARATOR . 'PANTALLAS_MOVILES_ANOTADAS.md';
        $content = file_exists($path) ? (string)file_get_contents($path) : '';

        $screens = ['PM-01', 'PM-02', 'PM-03', 'PM-04'];
        foreach ($screens as $screen) {
            $this->assert(strpos($content, $screen) !== false, "Pantalla móvil documentada con layout: {$screen}");
        }

        $this->assert(strpos($content, 'Bottom Nav Bar') !== false || strpos($content, 'Bottom Sheet') !== false, "Incorpora patrones de navegación móvil (Bottom Bar / Sheet)");
        $this->assert(strpos($content, 'ONLINE') !== false || strpos($content, 'OFFLINE') !== false, "Incluye indicadores de conectividad en interfaz");
    }

    private function testMobileScenariosAndDecisions(string $baseDir): void
    {
        echo PHP_EOL . "--- Verificando 2 Escenarios Móviles y Manejo de Error ---" . PHP_EOL;
        $path = $baseDir . DIRECTORY_SEPARATOR . 'docs' . DIRECTORY_SEPARATOR . 'ESCENARIOS_MOVILES_DECISIONES.md';
        $content = file_exists($path) ? (string)file_get_contents($path) : '';

        $this->assert(mb_stripos($content, 'Escenario 1') !== false && mb_stripos($content, 'Médico') !== false, "Escenario 1 clínico formulado");
        $this->assert(mb_stripos($content, 'Escenario 2') !== false && (mb_stripos($content, 'Desarrollador') !== false || mb_stripos($content, 'Auditor') !== false), "Escenario 2 técnico/on-call formulado");
        $this->assert(strpos($content, 'Service Worker') !== false || strpos($content, 'Caché') !== false, "Manejo de almacenamiento en caché local ante caída de red");
        $this->assert(strpos($content, '504') !== false || strpos($content, 'Timeout') !== false, "Manejo de timeout de red y reconexión documentado");
    }

    private function testTouchTargetsAndErgonomics(string $baseDir): void
    {
        echo PHP_EOL . "--- Verificando Zonas Táctiles y Ergonomía Hospitalaria ---" . PHP_EOL;
        $specPath = $baseDir . DIRECTORY_SEPARATOR . 'docs' . DIRECTORY_SEPARATOR . 'RESPONSIVE_BREAKPOINTS_SPEC.md';
        $content = file_exists($specPath) ? (string)file_get_contents($specPath) : '';

        $this->assert(strpos($content, '48') !== false, "Touch target mínimo especificado en 48px");
        $this->assert(mb_stripos($content, 'Thumb Zone') !== false, "Optimización para Thumb Zone documentada");
    }

    private function testPlantUmlDiagrams(string $baseDir): void
    {
        echo PHP_EOL . "--- Verificando Diagrama PlantUML de Navegación Móvil ---" . PHP_EOL;
        $puml = $baseDir . DIRECTORY_SEPARATOR . 'docs' . DIRECTORY_SEPARATOR . 'diagrams' . DIRECTORY_SEPARATOR . 'source' . DIRECTORY_SEPARATOR . 'mobile-navigation-flow.puml';
        $content = file_exists($puml) ? (string)file_get_contents($puml) : '';

        $this->assert(strpos($content, '@startuml') !== false && strpos($content, '@enduml') !== false, "Diagrama PlantUML de Navegación Móvil válido");
        $this->assert(strpos($content, 'PM01_HubMovil') !== false && strpos($content, 'PM04_BottomSheet') !== false, "Diagrama mapea transiciones entre pantallas móviles");
    }
}

$suite = new MobileValidationSuite();
exit($suite->run());
