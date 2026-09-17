<?php
/**
 * Suite de validacion automatizada de usabilidad y accesibilidad - Semana 9
 * Modulo: ASII-24 - Centro de Documentacion y Manuales por Rol
 * Autor: Albino Sebastian Rosales Ruano (codsebas)
 */

declare(strict_types=1);

final class AccessibilityValidationSuite
{
    private int $passed = 0;
    private int $failed = 0;

    public function run(): int
    {
        echo "=== INICIANDO VALIDACION USABILIDAD Y ACCESIBILIDAD SEMANA 9 (ASII-24) ===" . PHP_EOL . PHP_EOL;

        $baseDir = dirname(__DIR__);
        $this->testFileStructure($baseDir);
        $this->testChecklistContents($baseDir);
        $this->testSixFindings($baseDir);
        $this->testPrioritizedBacklog($baseDir);
        $this->testPlantUmlDiagrams($baseDir);

        echo PHP_EOL . "=======================================================" . PHP_EOL;
        echo sprintf("Resultado final: %d exitosas, %d fallidas" . PHP_EOL, $this->passed, $this->failed);
        echo "=======================================================" . PHP_EOL;

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
        echo "--- Verificando Estructura de Entregables Semana 9 ---" . PHP_EOL;
        $files = [
            'README.md',
            'INFORME.md',
            'DEFENSA_ORAL.md',
            'DECLARACION_IA.md',
            'docs/CHECKLIST_USABILIDAD_WCAG.md',
            'docs/HALLAZGOS_ACCESIBILIDAD.md',
            'docs/BACKLOG_PRIORIZADO.md',
            'docs/diagrams/source/accessibility-focus-flow.puml'
        ];

        foreach ($files as $file) {
            $path = $baseDir . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $file);
            $this->assert(file_exists($path), "Archivo requerido existe: {$file}");
        }
    }

    private function testChecklistContents(string $baseDir): void
    {
        echo PHP_EOL . "--- Verificando Checklist de Nielsen y WCAG 2.1 AA ---" . PHP_EOL;
        $path = $baseDir . DIRECTORY_SEPARATOR . 'docs' . DIRECTORY_SEPARATOR . 'CHECKLIST_USABILIDAD_WCAG.md';
        $content = file_exists($path) ? (string)file_get_contents($path) : '';

        $heuristics = ['Visibilidad', 'Correspondencia', 'Control y libertad', 'Consistencia', 'Prevención de errores'];
        foreach ($heuristics as $h) {
            $this->assert(mb_stripos($content, $h) !== false, "Checklist contiene heuristica de Nielsen: {$h}");
        }

        $wcagCriteria = ['1.3.1', '1.4.3', '2.1.1', '2.1.2', '2.4.7', '3.3.1', '3.3.4', '4.1.3'];
        foreach ($wcagCriteria as $crit) {
            $this->assert(strpos($content, $crit) !== false, "Checklist evalua criterio WCAG: {$crit}");
        }
    }

    private function testSixFindings(string $baseDir): void
    {
        echo PHP_EOL . "--- Verificando los 6 Hallazgos Obligatorios ---" . PHP_EOL;
        $path = $baseDir . DIRECTORY_SEPARATOR . 'docs' . DIRECTORY_SEPARATOR . 'HALLAZGOS_ACCESIBILIDAD.md';
        $content = file_exists($path) ? (string)file_get_contents($path) : '';

        $findings = ['HALL-01', 'HALL-02', 'HALL-03', 'HALL-04', 'HALL-05', 'HALL-06'];
        foreach ($findings as $id) {
            $this->assert(strpos($content, $id) !== false, "Hallazgo documentado: {$id}");
        }

        $dimensions = ['Teclado', 'Contraste', 'Etiquetas', 'aria-live', 'Prevención de Errores', 'RFC 7807'];
        foreach ($dimensions as $dim) {
            $this->assert(mb_stripos($content, $dim) !== false, "Dimension técnica evaluada: {$dim}");
        }
    }

    private function testPrioritizedBacklog(string $baseDir): void
    {
        echo PHP_EOL . "--- Verificando Backlog Priorizado MoSCoW y Criterios Verificables ---" . PHP_EOL;
        $path = $baseDir . DIRECTORY_SEPARATOR . 'docs' . DIRECTORY_SEPARATOR . 'BACKLOG_PRIORIZADO.md';
        $content = file_exists($path) ? (string)file_get_contents($path) : '';

        $priorities = ['Must Have', 'Should Have', 'Could Have'];
        foreach ($priorities as $p) {
            $this->assert(strpos($content, $p) !== false, "Matriz MoSCoW contempla prioridad: {$p}");
        }

        $this->assert(strpos($content, 'Dado') !== false && strpos($content, 'Cuando') !== false && strpos($content, 'Entonces') !== false, "Backlog incluye criterios de aceptacion en formato Gherkin");
        $this->assert(strpos($content, 'OpenAPI') !== false && strpos($content, 'Postman') !== false, "Backlog vincula impacto en OpenAPI y Postman");
    }

    private function testPlantUmlDiagrams(string $baseDir): void
    {
        echo PHP_EOL . "--- Verificando Diagrama PlantUML de Accesibilidad ---" . PHP_EOL;
        $puml = $baseDir . DIRECTORY_SEPARATOR . 'docs' . DIRECTORY_SEPARATOR . 'diagrams' . DIRECTORY_SEPARATOR . 'source' . DIRECTORY_SEPARATOR . 'accessibility-focus-flow.puml';
        $content = file_exists($puml) ? (string)file_get_contents($puml) : '';

        $this->assert(strpos($content, '@startuml') !== false && strpos($content, '@enduml') !== false, "Diagrama PlantUML de Flujo de Foco es sintacticamente valido");
        $this->assert(strpos($content, 'Focus Trap') !== false || strpos($content, 'FocusMgr') !== false, "Diagrama modela gestion accesible de foco y teclado");
    }
}

$suite = new AccessibilityValidationSuite();
exit($suite->run());
