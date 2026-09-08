<?php

declare(strict_types=1);

namespace Week04\Application\UseCases;

use Week04\Application\Contracts\DocumentRepository;
use Week04\Application\DTO\DocumentData;
use Week04\Domain\Exceptions\DocumentNotFoundException;
use Week04\Domain\Exceptions\DomainRuleViolation;

final class GetDocumentById
{
    public function __construct(
        private readonly DocumentRepository $repository
    ) {
    }

    public function execute(string $id, string $requestingRole): DocumentData
    {
        $document = $this->repository->findById($id);

        if ($document === null) {
            throw DocumentNotFoundException::forId($id);
        }

        if (!$document->isAccessibleBy($requestingRole)) {
            throw new DomainRuleViolation(sprintf('El rol "%s" no esta autorizado para consultar este documento.', $requestingRole));
        }

        return DocumentData::fromEntity($document);
    }
}
