<?php

declare(strict_types=1);

namespace Week04\Infrastructure\Repositories;

use DateTimeImmutable;
use PDO;
use RuntimeException;
use Week04\Application\Contracts\DocumentRepository;
use Week04\Domain\Document;
use Week04\Domain\OwnerScope;

final class PdoDocumentRepository implements DocumentRepository
{
    public function __construct(
        private readonly PDO $pdo
    ) {
    }

    public function save(Document $document): void
    {
        try {
            $this->pdo->beginTransaction();

            $stmt = $this->pdo->prepare('
                INSERT INTO documents (id, code, title, summary, content, owner_scope, hospital_uuid, status, published_at)
                VALUES (:id, :code, :title, :summary, :content, :owner_scope, :hospital_uuid, :status, :published_at)
                ON CONFLICT(id) DO UPDATE SET
                    code = excluded.code,
                    title = excluded.title,
                    summary = excluded.summary,
                    content = excluded.content,
                    owner_scope = excluded.owner_scope,
                    hospital_uuid = excluded.hospital_uuid,
                    status = excluded.status,
                    published_at = excluded.published_at
            ');

            $stmt->execute([
                ':id' => $document->id(),
                ':code' => $document->code(),
                ':title' => $document->title(),
                ':summary' => $document->summary(),
                ':content' => $document->content(),
                ':owner_scope' => $document->ownerScope()->value,
                ':hospital_uuid' => $document->hospitalUuid(),
                ':status' => $document->status(),
                ':published_at' => $document->publishedAt()->format('Y-m-d H:i:s'),
            ]);

            $delStmt = $this->pdo->prepare('DELETE FROM document_roles WHERE document_id = :document_id');
            $delStmt->execute([':document_id' => $document->id()]);

            $roleStmt = $this->pdo->prepare('INSERT INTO document_roles (document_id, role_name) VALUES (:document_id, :role_name)');
            foreach ($document->authorizedRoles() as $role) {
                $roleStmt->execute([
                    ':document_id' => $document->id(),
                    ':role_name' => $role,
                ]);
            }

            $this->pdo->commit();
        } catch (\Throwable $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            throw new RuntimeException('Error de persistencia en repositorio PDO: ' . $e->getMessage(), 0, $e);
        }
    }

    public function findById(string $id): ?Document
    {
        $stmt = $this->pdo->prepare('SELECT * FROM documents WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        $rolesStmt = $this->pdo->prepare('SELECT role_name FROM document_roles WHERE document_id = :document_id');
        $rolesStmt->execute([':document_id' => $id]);
        $roles = $rolesStmt->fetchAll(PDO::FETCH_COLUMN);

        return new Document(
            id: (string) $row['id'],
            code: (string) $row['code'],
            title: (string) $row['title'],
            summary: (string) $row['summary'],
            content: (string) $row['content'],
            ownerScope: OwnerScope::from((string) $row['owner_scope']),
            hospitalUuid: $row['hospital_uuid'] !== null ? (string) $row['hospital_uuid'] : null,
            authorizedRoles: array_map('strval', $roles),
            status: (string) $row['status'],
            publishedAt: new DateTimeImmutable((string) $row['published_at'])
        );
    }

    public function existsCode(string $code): bool
    {
        $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM documents WHERE LOWER(code) = LOWER(:code)');
        $stmt->execute([':code' => $code]);

        return ((int) $stmt->fetchColumn()) > 0;
    }

    /**
     * @return list<Document>
     */
    public function findByRole(string $role): array
    {
        if (strcasecmp($role, 'Admin') === 0) {
            $stmt = $this->pdo->query('SELECT id FROM documents WHERE status = "PUBLISHED" ORDER BY published_at DESC');
            $ids = $stmt->fetchAll(PDO::FETCH_COLUMN);
        } else {
            $stmt = $this->pdo->prepare('
                SELECT DISTINCT d.id
                FROM documents d
                INNER JOIN document_roles dr ON d.id = dr.document_id
                WHERE d.status = "PUBLISHED" AND LOWER(dr.role_name) = LOWER(:role)
                ORDER BY d.published_at DESC
            ');
            $stmt->execute([':role' => $role]);
            $ids = $stmt->fetchAll(PDO::FETCH_COLUMN);
        }

        $result = [];
        foreach ($ids as $id) {
            $doc = $this->findById((string) $id);
            if ($doc !== null) {
                $result[] = $doc;
            }
        }

        return $result;
    }
}
