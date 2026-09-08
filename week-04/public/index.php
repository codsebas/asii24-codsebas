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
require_once __DIR__ . '/../src/Infrastructure/Repositories/PdoDocumentRepository.php';
require_once __DIR__ . '/../src/Presentation/Controllers/DocumentController.php';

use Week04\Application\UseCases\GetDocumentById;
use Week04\Application\UseCases\ListDocumentsByRole;
use Week04\Application\UseCases\PublishDocument;
use Week04\Infrastructure\Repositories\PdoDocumentRepository;
use Week04\Presentation\Controllers\DocumentController;

header('Content-Type: application/json; charset=UTF-8');

$dbPath = __DIR__ . '/../database/database.sqlite';
if (!file_exists($dbPath)) {
    require_once __DIR__ . '/../scripts/init-db.php';
}

$pdo = new PDO('sqlite:' . $dbPath);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$repository = new PdoDocumentRepository($pdo);
$publishUseCase = new PublishDocument($repository);
$getUseCase = new GetDocumentById($repository);
$listUseCase = new ListDocumentsByRole($repository);

$controller = new DocumentController($publishUseCase, $getUseCase, $listUseCase);

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$role = $_GET['role'] ?? 'Medico';

if ($method === 'GET' && preg_match('#^/documents/([a-zA-Z0-9_-]+)$#', $uri, $matches)) {
    $response = $controller->get($matches[1], (string) $role);
    http_response_code($response['status']);
    echo json_encode($response['body'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

if ($method === 'GET' && ($uri === '/documents' || $uri === '/')) {
    $response = $controller->listByRole((string) $role);
    http_response_code($response['status']);
    echo json_encode($response['body'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

if ($method === 'POST' && $uri === '/documents') {
    $rawInput = file_get_contents('php://input');
    $payload = json_decode($rawInput, true) ?? [];
    $response = $controller->publish($payload);
    http_response_code($response['status']);
    echo json_encode($response['body'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

http_response_code(404);
echo json_encode(['success' => false, 'error' => 'NOT_FOUND', 'message' => 'Ruta no encontrada.'], JSON_PRETTY_PRINT);
