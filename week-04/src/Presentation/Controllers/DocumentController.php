<?php

declare(strict_types=1);

namespace Week04\Presentation\Controllers;

use Throwable;
use Week04\Application\DTO\PublishDocumentInput;
use Week04\Application\UseCases\GetDocumentById;
use Week04\Application\UseCases\ListDocumentsByRole;
use Week04\Application\UseCases\PublishDocument;
use Week04\Domain\Exceptions\DocumentNotFoundException;
use Week04\Domain\Exceptions\DomainRuleViolation;
use Week04\Domain\Exceptions\DuplicateDocumentException;

final class DocumentController
{
    public function __construct(
        private readonly PublishDocument $publishDocument,
        private readonly GetDocumentById $getDocumentById,
        private readonly ListDocumentsByRole $listDocumentsByRole
    ) {
    }

    /**
     * @param array<string, mixed> $payload
     * @return array{status: int, body: array<string, mixed>}
     */
    public function publish(array $payload): array
    {
        try {
            $input = new PublishDocumentInput(
                id: (string) ($payload['id'] ?? uniqid('doc_', true)),
                code: (string) ($payload['code'] ?? ''),
                title: (string) ($payload['title'] ?? ''),
                summary: (string) ($payload['summary'] ?? ''),
                content: (string) ($payload['content'] ?? ''),
                ownerScope: (string) ($payload['owner_scope'] ?? 'CENTRAL'),
                hospitalUuid: isset($payload['hospital_uuid']) && $payload['hospital_uuid'] !== '' ? (string) $payload['hospital_uuid'] : null,
                authorizedRoles: is_array($payload['authorized_roles'] ?? null) ? $payload['authorized_roles'] : []
            );

            $documentData = $this->publishDocument->execute($input);

            return [
                'status' => 201,
                'body' => [
                    'success' => true,
                    'data' => $documentData->toArray(),
                ],
            ];
        } catch (DuplicateDocumentException $e) {
            return [
                'status' => 409,
                'body' => [
                    'success' => false,
                    'error' => 'DUPLICATE_DOCUMENT',
                    'message' => $e->getMessage(),
                ],
            ];
        } catch (DomainRuleViolation $e) {
            return [
                'status' => 422,
                'body' => [
                    'success' => false,
                    'error' => 'VALIDATION_FAILED',
                    'message' => $e->getMessage(),
                ],
            ];
        } catch (Throwable $e) {
            return [
                'status' => 500,
                'body' => [
                    'success' => false,
                    'error' => 'INTERNAL_SERVER_ERROR',
                    'message' => 'Error interno al procesar el documento.',
                ],
            ];
        }
    }

    /**
     * @return array{status: int, body: array<string, mixed>}
     */
    public function get(string $id, string $requestingRole): array
    {
        try {
            $documentData = $this->getDocumentById->execute($id, $requestingRole);

            return [
                'status' => 200,
                'body' => [
                    'success' => true,
                    'data' => $documentData->toArray(),
                ],
            ];
        } catch (DocumentNotFoundException $e) {
            return [
                'status' => 404,
                'body' => [
                    'success' => false,
                    'error' => 'NOT_FOUND',
                    'message' => $e->getMessage(),
                ],
            ];
        } catch (DomainRuleViolation $e) {
            return [
                'status' => 403,
                'body' => [
                    'success' => false,
                    'error' => 'FORBIDDEN',
                    'message' => $e->getMessage(),
                ],
            ];
        } catch (Throwable $e) {
            return [
                'status' => 500,
                'body' => [
                    'success' => false,
                    'error' => 'INTERNAL_SERVER_ERROR',
                    'message' => 'Error interno al consultar el documento.',
                ],
            ];
        }
    }

    /**
     * @return array{status: int, body: array<string, mixed>}
     */
    public function listByRole(string $requestingRole): array
    {
        $documents = $this->listDocumentsByRole->execute($requestingRole);

        return [
            'status' => 200,
            'body' => [
                'success' => true,
                'data' => array_map(static fn ($doc) => $doc->toArray(), $documents),
                'meta' => [
                    'count' => count($documents),
                    'requesting_role' => $requestingRole,
                ],
            ],
        ];
    }
}
