<?php
/**
 * Suite de validacion automatizada de especificaciones UX - Semana 8
 * Modulo: ASII-24 - Centro de Documentacion y Manuales por Rol
 * Autor: Albino Sebastian Rosales Ruano (codsebas)
 */

declare(strict_types=1);

final class UxValidationSuite
{
    private int $passed = 0;
    private int $failed = 0;

    public function run(): int
    {
        echo "=== INICIANDO VALIDACION UX SEMANA 8 (ASII-24) ===" . PHP_EOL . PHP_EOL;

        $baseDir = dirname(__DIR__);
        $this->testFileStructure($baseDir);
        $this->testRequiredRoles($baseDir);
        $this->testUxStates($baseDir);
        $this->testDataProtectionRules($baseDir);
        $this->testPlantUmlDiagrams($baseDir);

        echo PHP_EOL . "===============================================" . PHP_EOL;
        echo sprintf("Resultado final: %d exitosas, %d fallidas" . PHP_EOL, $this->passed, $this->failed);
        echo "===============================================" . PHP_EOL;

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
        echo "--- Verificando Estructura de Entregables ---" . PHP_EOL;
        $files = [
            'README.md',
            'INFORME.md',
            'DEFENSA_ORAL.md',
            'DECLARACION_IA.md',
            'docs/USER_FLOW_ROLES.md',
            'docs/WIREFRAMES_ANOTADOS.md',
            'docs/diagrams/source/ux-user-flow.puml',
            'docs/diagrams/source/wireframes-navigation.puml'
        ];

        foreach ($files as $file) {
            $path = $baseDir . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $file);
            $this->assert(file_exists($path), "Archivo requerido existe: {$file}");
        }
    }

    private function testRequiredRoles(string $baseDir): void
    {
        echo PHP_EOL . "--- Verificando Cobertura de Roles Autorizados ---" . PHP_EOL;
        $userFlowPath = $baseDir . DIRECTORY_SEPARATOR . 'docs' . DIRECTORY_SEPARATOR . 'USER_FLOW_ROLES.md';
        $content = file_exists($userFlowPath) ? (string)file_get_contents($userFlowPath) : '';

        $requiredRoles = ['Administrador', 'Médico', 'Enfermería', 'Auditor', 'Desarrollador'];
        foreach ($requiredRoles as $role) {
            $this->assert(mb_stripos($content, $role) !== false, "Flujo UX contempla rol: {$role}");
        }
    }

    private function testUxStates(string $baseDir): void
    {
        echo PHP_EOL . "--- Verificando Estados Obligatorios en Wireframes ---" . PHP_EOL;
        $wireframesPath = $baseDir . DIRECTORY_SEPARATOR . 'docs' . DIRECTORY_SEPARATOR . 'WIREFRAMES_ANOTADOS.md';
        $content = file_exists($wireframesPath) ? (string)file_get_contents($wireframesPath) : '';

        $states = ['INITIAL', 'LOADING', 'EMPTY', 'SUCCESS', 'RECOVERABLE_ERROR'];
        foreach ($states as $state) {
            $this->assert(strpos($content, $state) !== false, "Wireframes definen formalmente estado: {$state}");
        }
    }

    private function testDataProtectionRules(string $baseDir): void
    {
        echo PHP_EOL . "--- Verificando Politicas de Proteccion de Datos ---" . PHP_EOL;
        $wireframesPath = $baseDir . DIRECTORY_SEPARATOR . 'docs' . DIRECTORY_SEPARATOR . 'WIREFRAMES_ANOTADOS.md';
        $content = file_exists($wireframesPath) ? (string)file_get_contents($wireframesPath) : '';

        $this->assert(strpos($content, 'Bearer') !== false && strpos($content, '***') !== false, "Enmascaramiento de tokens de autenticacion documentado");
        $this->assert(strpos($content, 'REDACTED') !== false || strpos($content, 'SYNTH') !== false, "Anonimizacion y redaccion de datos clinicos (PII) implementada");
        $this->assert(strpos($content, 'RFC 7807') !== false || strpos($content, 'ProblemDetails') !== false, "Estandar de error RFC 7807 integrado en la experiencia de recuperacion");
    }

    private function testPlantUmlDiagrams(string $baseDir): void
    {
        echo PHP_EOL . "--- Verificando Diagramas de Soporte PlantUML ---" . PHP_EOL;
        $flowPuml = $baseDir . DIRECTORY_SEPARATOR . 'docs' . DIRECTORY_SEPARATOR . 'diagrams' . DIRECTORY_SEPARATOR . 'source' . DIRECTORY_SEPARATOR . 'ux-user-flow.puml';
        $navPuml = $baseDir . DIRECTORY_SEPARATOR . 'docs' . DIRECTORY_SEPARATOR . 'diagrams' . DIRECTORY_SEPARATOR . 'source' . DIRECTORY_SEPARATOR . 'wireframes-navigation.puml';

        $flowContent = file_exists($flowPuml) ? (string)file_get_contents($flowPuml) : '';
        $navContent = file_exists($navPuml) ? (string)file_get_contents($navPuml) : '';

        $this->assert(strpos($flowContent, '@startuml') !== false && strpos($flowContent, '@enduml') !== false, "Diagrama PlantUML de User Flow valido");
        $this->assert(strpos($navContent, '@startuml') !== false && strpos($navContent, '@enduml') !== false, "Diagrama PlantUML de Navegacion y Estados valido");
    }
}

$suite = new UxValidationSuite();
exit($suite->run());
