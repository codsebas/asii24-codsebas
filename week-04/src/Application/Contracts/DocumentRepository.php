<?php

declare(strict_types=1);

namespace Week04\Application\Contracts;

use Week04\Domain\Document;

interface DocumentRepository
{
    public function save(Document $document): void;

    public function findById(string $id): ?Document;

    public function existsCode(string $code): bool;

    /**
     * @return list<Document>
     */
    public function findByRole(string $role): array;
}
