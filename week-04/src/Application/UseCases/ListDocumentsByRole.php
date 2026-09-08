<?php

declare(strict_types=1);

namespace Week04\Application\UseCases;

use Week04\Application\Contracts\DocumentRepository;
use Week04\Application\DTO\DocumentData;

final class ListDocumentsByRole
{
    public function __construct(
        private readonly DocumentRepository $repository
    ) {
    }

    /**
     * @return list<DocumentData>
     */
    public function execute(string $requestingRole): array
    {
        $documents = $this->repository->findByRole($requestingRole);

        return array_map(
            static fn ($doc) => DocumentData::fromEntity($doc),
            $documents
        );
    }
}
