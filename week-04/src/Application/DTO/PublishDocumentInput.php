<?php

declare(strict_types=1);

namespace Week04\Application\DTO;

final class PublishDocumentInput
{
    /**
     * @param list<string> $authorizedRoles
     */
    public function __construct(
        public readonly string $id,
        public readonly string $code,
        public readonly string $title,
        public readonly string $summary,
        public readonly string $content,
        public readonly string $ownerScope,
        public readonly ?string $hospitalUuid,
        public readonly array $authorizedRoles
    ) {
    }
}
