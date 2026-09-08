<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/Domain/OwnerScope.php';
require_once __DIR__ . '/../src/Domain/Exceptions/DomainRuleViolation.php';
require_once __DIR__ . '/../src/Domain/Exceptions/DocumentNotFoundException.php';
require_once __DIR__ . '/../src/Domain/Exceptions/DuplicateDocumentException.php';
require_once __DIR__ . '/../src/Domain/Document.php';
require_once __DIR__ . '/../src/Application/Contracts/DocumentRepository.php';
require_once __DIR__ . '/../src/Application/DTO/PublishDocumentInput.php';
require_once __DIR__ . '/../src/Application/DTO/DocumentData.php';
require_once __DIR__ . '/../src/Application/UseCases/PublishDocument.php';
require_once __DIR__ . '/../src/Application/UseCases/GetDocumentById.php';
require_once __DIR__ . '/../src/Application/UseCases/ListDocumentsByRole.php';
require_once __DIR__ . '/../src/Infrastructure/Repositories/InMemoryDocumentRepository.php';
require_once __DIR__ . '/../src/Infrastructure/Repositories/PdoDocumentRepository.php';
require_once __DIR__ . '/../src/Presentation/Controllers/DocumentController.php';

use Week04\Application\DTO\PublishDocumentInput;
use Week04\Application\UseCases\GetDocumentById;
use Week04\Application\UseCases\ListDocumentsByRole;
use Week04\Application\UseCases\PublishDocument;
use Week04\Domain\Document;
use Week04\Domain\Exceptions\DomainRuleViolation;
use Week04\Domain\Exceptions\DuplicateDocumentException;
use Week04\Domain\OwnerScope;
use Week04\Infrastructure\Repositories\InMemoryDocumentRepository;
use Week04\Infrastructure\Repositories\PdoDocumentRepository;
use Week04\Presentation\Controllers\DocumentController;

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

echo "=== ASII-24 Semana 4: Suite de Pruebas Unitarias y de Integracion ===\n\n";

echo "--- 1. Pruebas de Dominio ---\n";

it('Crea entidad Document con datos validos para alcance CENTRAL', function () {
    $doc = new Document('d1', 'DOC-01', 'Guia Clinica', 'Resumen', 'Contenido', OwnerScope::CENTRAL, null, ['Medico', 'Admin']);
    assertEquals('d1', $doc->id());
    assertEquals('DOC-01', $doc->code());
    assertEquals('CENTRAL', $doc->ownerScope()->value);
    assertTrue($doc->isAccessibleBy('Medico'));
    assertTrue($doc->isAccessibleBy('Admin'));
    assertFalse($doc->isAccessibleBy('TecnicoLab'));
});

it('Rechaza documento con alcance HOSPITAL sin hospitalUuid', function () {
    try {
        new Document('d2', 'DOC-02', 'Guia', 'Resumen', 'Contenido', OwnerScope::HOSPITAL, null, ['Enfermera']);
        throw new RuntimeException('Debio fallar por hospitalUuid nulo');
    } catch (DomainRuleViolation $e) {
        assertTrue(str_contains($e->getMessage(), 'hospitalUuid es obligatorio'));
    }
});

it('Rechaza documento sin roles autorizados', function () {
    try {
        new Document('d3', 'DOC-03', 'Guia', 'Resumen', 'Contenido', OwnerScope::CENTRAL, null, []);
        throw new RuntimeException('Debio fallar por lista de roles vacia');
    } catch (DomainRuleViolation $e) {
        assertTrue(str_contains($e->getMessage(), 'al menos un rol autorizado'));
    }
});

echo "\n--- 2. Pruebas de Repositorio InMemory y Casos de Uso ---\n";

it('Publica un documento y lo almacena mediante InMemoryDocumentRepository', function () {
    $repo = new InMemoryDocumentRepository();
    $useCase = new PublishDocument($repo);

    $input = new PublishDocumentInput(
        id: 'doc-100',
        code: 'SOP-01',
        title: 'Procedimiento de Admision',
        summary: 'Resumen operativo',
        content: 'Detalle del procedimiento',
        ownerScope: 'CENTRAL',
        hospitalUuid: null,
        authorizedRoles: ['Recepcionista', 'Admin']
    );

    $result = $useCase->execute($input);
    assertEquals('doc-100', $result->id);
    assertEquals('SOP-01', $result->code);
    assertEquals(1, $repo->count());
    assertTrue($repo->existsCode('SOP-01'));
});

it('Impide registrar documentos con codigo duplicado', function () {
    $repo = new InMemoryDocumentRepository();
    $useCase = new PublishDocument($repo);

    $input1 = new PublishDocumentInput('d1', 'DUP-01', 'Doc 1', 'R1', 'C1', 'CENTRAL', null, ['Admin']);
    $input2 = new PublishDocumentInput('d2', 'DUP-01', 'Doc 2', 'R2', 'C2', 'CENTRAL', null, ['Medico']);

    $useCase->execute($input1);

    try {
        $useCase->execute($input2);
        throw new RuntimeException('Debio lanzar DuplicateDocumentException');
    } catch (DuplicateDocumentException $e) {
        assertTrue(str_contains($e->getMessage(), 'DUP-01'));
    }
});

it('Consulta documento por ID validando autorizacion del rol', function () {
    $repo = new InMemoryDocumentRepository();
    $publish = new PublishDocument($repo);
    $get = new GetDocumentById($repo);

    $publish->execute(new PublishDocumentInput('doc-200', 'MED-01', 'Vademecum', 'R', 'C', 'CENTRAL', null, ['Medico']));

    $doc = $get->execute('doc-200', 'Medico');
    assertEquals('doc-200', $doc->id);

    try {
        $get->execute('doc-200', 'Enfermera');
        throw new RuntimeException('Debio denegar acceso a Enfermera');
    } catch (DomainRuleViolation $e) {
        assertTrue(str_contains($e->getMessage(), 'no esta autorizado'));
    }
});

echo "\n--- 3. Pruebas de Persistencia PDO con Sentencias Preparadas ---\n";

it('Persiste y recupera un documento en base de datos SQLite con PDO', function () {
    $pdo = new PDO('sqlite::memory:');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $schema = file_get_contents(__DIR__ . '/../database/schema.sql');
    $pdo->exec($schema);

    $repo = new PdoDocumentRepository($pdo);

    $doc = new Document('pdo-1', 'CODE-PDO-1', 'Manual PDO', 'Resumen PDO', 'Contenido PDO', OwnerScope::HOSPITAL, 'hosp-01', ['TecnicoLab', 'Admin']);
    $repo->save($doc);

    $retrieved = $repo->findById('pdo-1');
    assertTrue($retrieved !== null);
    assertEquals('CODE-PDO-1', $retrieved->code());
    assertEquals('HOSPITAL', $retrieved->ownerScope()->value);
    assertEquals('hosp-01', $retrieved->hospitalUuid());
    assertTrue($retrieved->isAccessibleBy('TecnicoLab'));
    assertTrue($retrieved->isAccessibleBy('Admin'));
    assertFalse($retrieved->isAccessibleBy('Medico'));

    $byRole = $repo->findByRole('TecnicoLab');
    assertEquals(1, count($byRole));
});

echo "\n--- 4. Pruebas del Controlador MVC (Sin SQL ni reglas de negocio) ---\n";

it('El controlador procesa publicacion y retorna respuesta HTTP 201 estructurada', function () {
    $repo = new InMemoryDocumentRepository();
    $controller = new DocumentController(
        new PublishDocument($repo),
        new GetDocumentById($repo),
        new ListDocumentsByRole($repo)
    );

    $res = $controller->publish([
        'id' => 'c-1',
        'code' => 'CTRL-01',
        'title' => 'Titulo Controlador',
        'summary' => 'Resumen',
        'content' => 'Cuerpo',
        'owner_scope' => 'CENTRAL',
        'authorized_roles' => ['Medico'],
    ]);

    assertEquals(201, $res['status']);
    assertTrue($res['body']['success']);
    assertEquals('CTRL-01', $res['body']['data']['code']);
});

it('El controlador maneja denegacion de acceso retornando 403', function () {
    $repo = new InMemoryDocumentRepository();
    $repo->save(new Document('c-2', 'CTRL-02', 'T', 'S', 'C', OwnerScope::CENTRAL, null, ['Medico']));

    $controller = new DocumentController(
        new PublishDocument($repo),
        new GetDocumentById($repo),
        new ListDocumentsByRole($repo)
    );

    $res = $controller->get('c-2', 'Recepcionista');
    assertEquals(403, $res['status']);
    assertFalse($res['body']['success']);
    assertEquals('FORBIDDEN', $res['body']['error']);
});

echo "\n=======================================================\n";
echo "RESULTADOS FINALES: {$passed} superadas, {$failed} fallidas.\n";
echo "=======================================================\n";

if ($failed > 0) {
    exit(1);
}
