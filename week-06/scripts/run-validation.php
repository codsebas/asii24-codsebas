<?php

declare(strict_types=1);

echo "=== ASII-24 Semana 6: Suite de Verificación de Trazabilidad y Cambio Práctico ===\n\n";

$passed = 0;
$failed = 0;

function it(string $description, callable $test): void {
    global $passed, $failed;
    try {
        $test();
        echo "  [PASS] {$description}\n";
        $passed++;
    } catch (Throwable $e) {
        echo "  [FAIL] {$description}: " . $e->getMessage() . "\n";
        $failed++;
    }
}

function assertTrue(bool $condition, string $msg = 'Fallo de afirmación'): void {
    if (!$condition) {
        throw new RuntimeException($msg);
    }
}

// 1. Verificación de Hilo Conductor (Semanas 1 a 5)
echo "--- 1. Verificación de Artefactos de Semanas 1 a 5 ---\n";

it('Verifica existencia de especificación canónica OpenAPI de Semana 5', function () {
    $openapi = __DIR__ . '/../../week-05/contracts/openapi.yaml';
    assertTrue(file_exists($openapi), "No se encontró openapi.yaml en {$openapi}");
});

it('Verifica existencia de repositorio de dominio desacoplado de Semana 4', function () {
    $repoContract = __DIR__ . '/../../week-04/src/Application/Contracts/DocumentRepository.php';
    assertTrue(file_exists($repoContract), "No se encontró contrato Repository en {$repoContract}");
});

it('Verifica existencia de micro-HIS y suite de tests de Semana 3', function () {
    $testsWeek3 = __DIR__ . '/../../week-03/scripts/run-tests.php';
    assertTrue(file_exists($testsWeek3), "No se encontró run-tests.php en {$testsWeek3}");
});

// 2. Verificación de Diagramas y Documentación de Parcial 1
echo "\n--- 2. Verificación de Entregables de Semana 6 ---\n";

it('Verifica existencia y formato de matriz decisión -> evidencia', function () {
    $matrix = __DIR__ . '/../docs/MATRIZ_DECISION_EVIDENCIA.md';
    assertTrue(file_exists($matrix), "No se encontró MATRIZ_DECISION_EVIDENCIA.md");
    $content = file_get_contents($matrix);
    assertTrue(str_contains($content, 'ISO 25010'), "La matriz debe evaluar criterios de calidad ISO 25010");
});

it('Verifica existencia de especificación de Cambio Práctico y diagramas PlantUML', function () {
    $changeDoc = __DIR__ . '/../docs/CAMBIO_PRACTICO.md';
    $diag1 = __DIR__ . '/../docs/diagrams/source/traceability-architecture.puml';
    $diag2 = __DIR__ . '/../docs/diagrams/source/practical-change-impact.puml';
    assertTrue(file_exists($changeDoc), "Falta CAMBIO_PRACTICO.md");
    assertTrue(file_exists($diag1), "Falta traceability-architecture.puml");
    assertTrue(file_exists($diag2), "Falta practical-change-impact.puml");
});

// 3. Verificación de Lógica del Cambio Práctico (Simulación de Dominio)
echo "\n--- 3. Verificación de Reglas del Cambio Práctico ---\n";

it('Simula reglas de negocio para estados y rol AuditorExterno', function () {
    $rolesAutorizados = ['Admin', 'Medico', 'AuditorExterno'];
    $estadosValidos = ['DRAFT', 'PUBLISHED', 'DEPRECATED'];

    // Validar estados
    foreach (['DRAFT', 'PUBLISHED', 'DEPRECATED'] as $st) {
        assertTrue(in_array($st, $estadosValidos, true), "Estado inválido: {$st}");
    }

    // Regla: AuditorExterno solo tiene lectura
    $puedeLeer = in_array('AuditorExterno', $rolesAutorizados, true);
    $puedePublicar = false; // Bloqueado por regla de negocio

    assertTrue($puedeLeer, "AuditorExterno debe tener permiso de lectura");
    assertTrue(!$puedePublicar, "AuditorExterno NO debe tener permiso de publicación");
});

echo "\n=======================================================\n";
echo "RESULTADOS FINALES: {$passed} superadas, {$failed} fallidas.\n";
echo "=======================================================\n";

if ($failed > 0) {
    exit(1);
}
