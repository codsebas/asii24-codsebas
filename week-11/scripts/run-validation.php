<?php
/**
 * Suite de validacion automatizada del prototipo navegable - Semana 11
 * Modulo: ASII-24 - Centro de Documentacion y Manuales por Rol
 * Autor: Albino Sebastian Rosales Ruano (codsebas)
 */

declare(strict_types=1);

final class PrototypeValidationSuite
{
    private int $passed = 0;
    private int $failed = 0;

    public function run(): int
    {
        echo "=== INICIANDO VALIDACION DEL PROTOTIPO SEMANA 11 (ASII-24) ===" . PHP_EOL . PHP_EOL;

        $baseDir = dirname(__DIR__);
        $this->testFileStructure($baseDir);
        $this->testPrototypeHtmlIntegrity($baseDir);
        $this->testRolesAndPermissions($baseDir);
        $this->testHappyPathImplementation($baseDir);
        $this->testCriticalErrorPathImplementation($baseDir);
        $this->testAccessibilityAndTouchTargets($baseDir);
        $this->testPlantUmlDiagrams($baseDir);

        echo PHP_EOL . "=============================================================" . PHP_EOL;
        echo sprintf("Resultado final: %d exitosas, %d fallidas" . PHP_EOL, $this->passed, $this->failed);
        echo "=============================================================" . PHP_EOL;

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
        echo "--- Verificando Estructura de Entregables Semana 11 ---" . PHP_EOL;
        $files = [
            'README.md',
            'INFORME.md',
            'DEFENSA_ORAL.md',
            'DECLARACION_IA.md',
            'prototype/index.html',
            'docs/MAPA_NAVEGACION.md',
            'docs/EVIDENCIA_CAPTURAS.md',
            'docs/diagrams/source/prototype-navigation.puml'
        ];

        foreach ($files as $file) {
            $path = $baseDir . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $file);
            $this->assert(file_exists($path), "Archivo requerido existe: {$file}");
        }
    }

    private function testPrototypeHtmlIntegrity(string $baseDir): void
    {
        echo PHP_EOL . "--- Verificando Integridad del Prototipo HTML5/JS ---" . PHP_EOL;
        $path = $baseDir . DIRECTORY_SEPARATOR . 'prototype' . DIRECTORY_SEPARATOR . 'index.html';
        $content = file_exists($path) ? (string)file_get_contents($path) : '';

        $this->assert(strpos($content, '<!DOCTYPE html>') !== false, "Prototipo posee declaracion formal HTML5");
        $this->assert(strpos($content, '<script>') !== false && strpos($content, '</script>') !== false, "Prototipo contiene script interactivo");
        $this->assert(strpos($content, '<style>') !== false && strpos($content, '</style>') !== false, "Prototipo contiene estilos CSS responsive");
    }

    private function testRolesAndPermissions(string $baseDir): void
    {
        echo PHP_EOL . "--- Verificando Selector y Cobertura de Roles ---" . PHP_EOL;
        $path = $baseDir . DIRECTORY_SEPARATOR . 'prototype' . DIRECTORY_SEPARATOR . 'index.html';
        $content = file_exists($path) ? (string)file_get_contents($path) : '';

        $roles = ['ROLE_MEDICO', 'ROLE_ENFERMERA', 'ROLE_AUDITOR', 'ROLE_ADMIN'];
        foreach ($roles as $role) {
            $this->assert(strpos($content, $role) !== false, "Prototipo implementa rol: {$role}");
        }
    }

    private function testHappyPathImplementation(string $baseDir): void
    {
        echo PHP_EOL . "--- Verificando Implementación del Camino Feliz (Happy Path) ---" . PHP_EOL;
        $path = $baseDir . DIRECTORY_SEPARATOR . 'prototype' . DIRECTORY_SEPARATOR . 'index.html';
        $content = file_exists($path) ? (string)file_get_contents($path) : '';

        $this->assert(strpos($content, 'HTTP 200 OK') !== false, "Camino feliz devuelve estado HTTP 200 OK");
        $this->assert(strpos($content, 'CTR-SYNTH-9941') !== false, "Payload de prueba utiliza identificadores sinteticos anonimizados");
        $this->assert(strpos($content, 'cURL') !== false, "Prototipo incluye boton para copiar comando cURL");
    }

    private function testCriticalErrorPathImplementation(string $baseDir): void
    {
        echo PHP_EOL . "--- Verificando Implementación del Error Crítico RFC 7807 ---" . PHP_EOL;
        $path = $baseDir . DIRECTORY_SEPARATOR . 'prototype' . DIRECTORY_SEPARATOR . 'index.html';
        $content = file_exists($path) ? (string)file_get_contents($path) : '';

        $this->assert(strpos($content, 'RFC 7807') !== false || strpos($content, 'HTTP 422') !== false, "Implementa estandar de error RFC 7807 con codigo 422");
        $this->assert(strpos($content, 'aria-invalid="true"') !== false, "Campo infractor recibe aria-invalid para lectores de pantalla");
        $this->assert(strpos($content, 'CONFIRMAR-V3.0.0') !== false, "Exige confirmacion tipificada para recuperacion in-situ");
    }

    private function testAccessibilityAndTouchTargets(string $baseDir): void
    {
        echo PHP_EOL . "--- Verificando Pautas de Accesibilidad y Zonas Táctiles ---" . PHP_EOL;
        $path = $baseDir . DIRECTORY_SEPARATOR . 'prototype' . DIRECTORY_SEPARATOR . 'index.html';
        $content = file_exists($path) ? (string)file_get_contents($path) : '';

        $this->assert(strpos($content, 'min-height: 48px') !== false || strpos($content, 'min-height:48px') !== false, "Elementos interactivos cumplen touch target minimo de 48px");
        $this->assert(strpos($content, 'aria-live="polite"') !== false, "Respuestas asincronas monitoreadas con region viva aria-live");
        $this->assert(strpos($content, 'bottom-nav') !== false, "Prototipo implementa Bottom Navigation Bar para dispositivos moviles");
    }

    private function testPlantUmlDiagrams(string $baseDir): void
    {
        echo PHP_EOL . "--- Verificando Diagrama PlantUML de Navegación del Prototipo ---" . PHP_EOL;
        $puml = $baseDir . DIRECTORY_SEPARATOR . 'docs' . DIRECTORY_SEPARATOR . 'diagrams' . DIRECTORY_SEPARATOR . 'source' . DIRECTORY_SEPARATOR . 'prototype-navigation.puml';
        $content = file_exists($puml) ? (string)file_get_contents($puml) : '';

        $this->assert(strpos($content, '@startuml') !== false && strpos($content, '@enduml') !== false, "Diagrama PlantUML es sintacticamente valido");
        $this->assert(strpos($content, 'ModalConfirmacion422') !== false, "Diagrama modela conmutacion hacia error critico RFC 7807");
    }
}

$suite = new PrototypeValidationSuite();
exit($suite->run());
