<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/ContractDTO.php';
require_once __DIR__ . '/../src/ProblemDetails.php';

use Week07\Src\ContractDetailResponse;
use Week07\Src\ProblemDetails;
use Week07\Src\PublishContractCommand;

echo "=== ASII-24 Semana 7: Suite de Pruebas de Componentes y DTOs ===\n\n";

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

echo "--- 1. Pruebas de Contratos de Entrada (DTOs) ---\n";

it('Instancia PublishContractCommand con datos validos', function () {
    $cmd = new PublishContractCommand(
        'Manual UCI',
        '1.0.0',
        'Guia de cuidados intensivos',
        'Contenido...',
        'CENTRAL',
        null,
        ['Medico', 'Enfermera']
    );
    assertTrue($cmd->title === 'Manual UCI');
    assertTrue($cmd->version === '1.0.0');
});

it('Rechaza version invalida que no cumpla formato SemVer', function () {
    try {
        new PublishContractCommand('Manual UCI', 'v1-beta', 'Resumen', 'Contenido', 'CENTRAL', null, ['Medico']);
        throw new RuntimeException('Debió fallar por version SemVer invalida');
    } catch (InvalidArgumentException $e) {
        assertTrue(str_contains($e->getMessage(), 'SemVer'));
    }
});

it('Rechaza alcance HOSPITAL sin hospitalUuid', function () {
    try {
        new PublishContractCommand('Manual UCI', '1.0.0', 'Resumen', 'Contenido', 'HOSPITAL', null, ['Medico']);
        throw new RuntimeException('Debió fallar por falta de hospitalUuid');
    } catch (InvalidArgumentException $e) {
        assertTrue(str_contains($e->getMessage(), 'hospitalUuid'));
    }
});

echo "\n--- 2. Pruebas de Contratos de Salida y Errores RFC 7807 ---\n";

it('Serializa ContractDetailResponse correctamente a estructura JSON', function () {
    $res = new ContractDetailResponse('id-1', 'Manual UCI', '1.0.0', 'PUBLISHED', 'CENTRAL', ['Medico']);
    $arr = $res->toArray();
    assertTrue($arr['status'] === 'PUBLISHED');
    assertTrue($arr['id'] === 'id-1');
});

it('Mapea excepcion de acceso denegado a ProblemDetails RFC 7807 (403)', function () {
    $e = new RuntimeException('Acceso no autorizado para este rol');
    $problem = ProblemDetails::fromException($e, '/api/v1/api-contracts/1');
    assertTrue($problem->status === 403);
    assertTrue($problem->title === 'Acceso Denegado por Rol');
    assertTrue($problem->code === 'ERR_HTTP_403');
});

it('Mapea excepcion de validacion a ProblemDetails RFC 7807 (422)', function () {
    $e = new InvalidArgumentException('Datos incompletos');
    $problem = ProblemDetails::fromException($e, '/api/v1/api-contracts');
    assertTrue($problem->status === 422);
    assertTrue($problem->title === 'Error de Validacion de Datos');
});

echo "\n=======================================================\n";
echo "RESULTADOS FINALES: {$passed} superadas, {$failed} fallidas.\n";
echo "=======================================================\n";

if ($failed > 0) {
    exit(1);
}
