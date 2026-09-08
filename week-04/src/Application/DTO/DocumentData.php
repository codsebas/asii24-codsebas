<?php

declare(strict_types=1);

namespace Week04\Application\DTO;

use Week04\Domain\Document;

final class DocumentData
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
        public readonly array $authorizedRoles,
        public readonly string $status,
        public readonly string $publishedAt
    ) {
    }

    public static function fromEntity(Document $document): self
    {
        return new self(
            id: $document->id(),
            code: $document->code(),
            title: $document->title(),
            summary: $document->summary(),
            content: $document->content(),
            ownerScope: $document->ownerScope()->value,
            hospitalUuid: $document->hospitalUuid(),
            authorizedRoles: $document->authorizedRoles(),
            status: $document->status(),
            publishedAt: $document->publishedAt()->format('Y-m-d H:i:s')
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'title' => $this->title,
            'summary' => $this->summary,
            'content' => $this->content,
            'owner_scope' => $this->ownerScope,
            'hospital_uuid' => $this->hospitalUuid,
            'authorized_roles' => $this->authorizedRoles,
            'status' => $this->status,
            'published_at' => $this->publishedAt,
        ];
    }
}
