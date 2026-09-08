<?php

declare(strict_types=1);

$passed = 0;
$failed = 0;

function it(string $description, callable $test): void {
    try {
        $test();
        echo "  [PASS] {$description}\n";
        $GLOBALS['passed']++;
    } catch (Throwable $e) {
        echo "  [FAIL] {$description}: " . $e->getMessage() . "\n";
        $GLOBALS['failed']++;
    }
}

function assertEquals($expected, $actual, string $message = ''): void {
    if ($expected !== $actual) {
        throw new RuntimeException($message ?: "Esperado " . var_export($expected, true) . ", obtenido " . var_export($actual, true));
    }
}

function assertTrue(bool $condition, string $message = ''): void {
    if (!$condition) {
        throw new RuntimeException($message ?: "Se esperaba true, se obtuvo false");
    }
}

function assertFalse(bool $condition, string $message = ''): void {
    if ($condition) {
        throw new RuntimeException($message ?: "Se esperaba false, se obtuvo true");
    }
}

echo "=== ASII-24 Semana 5: Suite de Validacion de Contratos OpenAPI y Postman ===\n\n";

$openapiPath = __DIR__ . '/../contracts/openapi.yaml';
$postmanCollectionPath = __DIR__ . '/../postman/SHI-ASII24.postman_collection.json';
$postmanEnvPath = __DIR__ . '/../postman/SHI-ASII24.postman_environment.example.json';

echo "--- 1. Validacion de Estructura de Contrato OpenAPI 3.0 ---\n";

it('El archivo openapi.yaml existe y es legible', function () use ($openapiPath) {
    assertTrue(file_exists($openapiPath), 'El archivo openapi.yaml no existe');
    $content = file_get_contents($openapiPath);
    assertTrue(strlen($content) > 500, 'El archivo openapi.yaml parece estar vacio');
});

it('El contrato define version OpenAPI 3.0, titulo y paths clave', function () use ($openapiPath) {
    $content = file_get_contents($openapiPath);
    assertTrue(str_contains($content, 'openapi: 3.0'), 'Debe especificar version openapi 3.0.x');
    assertTrue(str_contains($content, '/api/v1/api-contracts:'), 'Debe contener la ruta /api/v1/api-contracts');
    assertTrue(str_contains($content, '/api/v1/api-contracts/{id}:'), 'Debe contener la ruta /api/v1/api-contracts/{id}');
    assertTrue(str_contains($content, 'bearerAuth:'), 'Debe documentar el esquema de seguridad Bearer JWT');
    assertTrue(str_contains($content, 'TenantId:'), 'Debe requerir el parametro X-Tenant-ID');
});

it('El contrato documenta todos los codigos HTTP obligatorios (200, 201, 400, 401, 404, 409, 422)', function () use ($openapiPath) {
    $content = file_get_contents($openapiPath);
    $requiredStatuses = ['201', '200', '400', '401', '404', '409', '422'];
    foreach ($requiredStatuses as $status) {
        assertTrue(str_contains($content, "'{$status}':") || str_contains($content, "\"{$status}\":"), "Debe documentar el estado HTTP {$status}");
    }
});

echo "\n--- 2. Validacion de Coleccion y Ambiente Postman ---\n";

it('La coleccion Postman es un JSON valido y contiene requests configuradas', function () use ($postmanCollectionPath) {
    assertTrue(file_exists($postmanCollectionPath), 'No existe el archivo de coleccion Postman');
    $json = json_decode(file_get_contents($postmanCollectionPath), true);
    assertEquals(JSON_ERROR_NONE, json_last_error(), 'El archivo de coleccion no es un JSON valido');
    assertTrue(isset($json['item']) && count($json['item']) >= 5, 'Debe contener al menos 5 peticiones documentadas');
});

it('El ambiente de Postman contiene variables parametrizadas y cero secretos reales', function () use ($postmanEnvPath) {
    assertTrue(file_exists($postmanEnvPath), 'No existe el archivo de ambiente Postman');
    $content = file_get_contents($postmanEnvPath);
    $json = json_decode($content, true);
    assertEquals(JSON_ERROR_NONE, json_last_error(), 'El ambiente no es un JSON valido');

    $keys = array_column($json['values'] ?? [], 'key');
    assertTrue(in_array('baseUrl', $keys), 'Falta variable baseUrl');
    assertTrue(in_array('tenantId', $keys), 'Falta variable tenantId');
    assertTrue(in_array('accessToken', $keys), 'Falta variable accessToken');

    assertFalse(str_contains(strtolower($content), 'password123'), 'Contiene contraseña insegura');
    assertFalse(str_contains(strtolower($content), 'admin123'), 'Contiene secreto');
});

echo "\n--- 3. Consistencia entre OpenAPI y Postman ---\n";

it('Todas las operaciones requeridas de la coleccion Postman cubren el contrato OpenAPI', function () use ($postmanCollectionPath) {
    $json = json_decode(file_get_contents($postmanCollectionPath), true);
    $requests = $json['item'] ?? [];

    $names = array_column($requests, 'name');
    $hasPublish = false;
    $hasGet = false;
    $has400 = false;
    $has401 = false;
    $has404 = false;

    foreach ($names as $name) {
        if (stripos($name, 'publish') !== false && stripos($name, 'success') !== false) $hasPublish = true;
        if (stripos($name, 'get contract') !== false && stripos($name, 'success') !== false) $hasGet = true;
        if (stripos($name, 'missing tenant') !== false || stripos($name, '400') !== false) $has400 = true;
        if (stripos($name, 'unauthorized') !== false || stripos($name, '401') !== false) $has401 = true;
        if (stripos($name, 'missing contract') !== false || stripos($name, '404') !== false) $has404 = true;
    }

    assertTrue($hasPublish, 'Falta request de publicacion exitosa');
    assertTrue($hasGet, 'Falta request de consulta por id exitosa');
    assertTrue($has400, 'Falta escenario de error 400 (Tenant faltante)');
    assertTrue($has401, 'Falta escenario de error 401 (No autorizado)');
    assertTrue($has404, 'Falta escenario de error 404 (No encontrado)');
});

echo "\n=======================================================\n";
echo "RESULTADOS FINALES: {$passed} superadas, {$failed} fallidas.\n";
echo "=======================================================\n";

if ($failed > 0) {
    exit(1);
}
