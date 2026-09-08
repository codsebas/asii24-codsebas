<?php

declare(strict_types=1);

namespace Week04\Infrastructure\Repositories;

use Week04\Application\Contracts\DocumentRepository;
use Week04\Domain\Document;

final class InMemoryDocumentRepository implements DocumentRepository
{
    /**
     * @var array<string, Document>
     */
    private array $storage = [];

    public function save(Document $document): void
    {
        $this->storage[$document->id()] = $document;
    }

    public function findById(string $id): ?Document
    {
        return $this->storage[$id] ?? null;
    }

    public function existsCode(string $code): bool
    {
        foreach ($this->storage as $document) {
            if (strcasecmp($document->code(), $code) === 0) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return list<Document>
     */
    public function findByRole(string $role): array
    {
        $result = [];

        foreach ($this->storage as $document) {
            if ($document->isAccessibleBy($role)) {
                $result[] = $document;
            }
        }

        return array_values($result);
    }

    public function count(): int
    {
        return count($this->storage);
    }
}
