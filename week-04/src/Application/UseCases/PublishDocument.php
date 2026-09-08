<?php

declare(strict_types=1);

namespace Week04\Application\UseCases;

use Week04\Application\Contracts\DocumentRepository;
use Week04\Application\DTO\DocumentData;
use Week04\Application\DTO\PublishDocumentInput;
use Week04\Domain\Document;
use Week04\Domain\Exceptions\DuplicateDocumentException;
use Week04\Domain\OwnerScope;

final class PublishDocument
{
    public function __construct(
        private readonly DocumentRepository $repository
    ) {
    }

    public function execute(PublishDocumentInput $input): DocumentData
    {
        if ($this->repository->existsCode($input->code)) {
            throw DuplicateDocumentException::forCode($input->code);
        }

        $ownerScope = OwnerScope::from($input->ownerScope);

        $document = new Document(
            id: $input->id,
            code: $input->code,
            title: $input->title,
            summary: $input->summary,
            content: $input->content,
            ownerScope: $ownerScope,
            hospitalUuid: $input->hospitalUuid,
            authorizedRoles: $input->authorizedRoles
        );

        $this->repository->save($document);

        return DocumentData::fromEntity($document);
    }
}
