<?php

declare(strict_types=1);

namespace Week04\Domain;

use DateTimeImmutable;
use Week04\Domain\Exceptions\DomainRuleViolation;

final class Document
{
    /**
     * @param list<string> $authorizedRoles
     */
    public function __construct(
        private readonly string $id,
        private readonly string $code,
        private readonly string $title,
        private readonly string $summary,
        private readonly string $content,
        private readonly OwnerScope $ownerScope,
        private readonly ?string $hospitalUuid,
        private readonly array $authorizedRoles,
        private readonly string $status = 'PUBLISHED',
        private readonly ?DateTimeImmutable $publishedAt = null
    ) {
        $this->assertValid();
    }

    public function id(): string
    {
        return $this->id;
    }

    public function code(): string
    {
        return $this->code;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function summary(): string
    {
        return $this->summary;
    }

    public function content(): string
    {
        return $this->content;
    }

    public function ownerScope(): OwnerScope
    {
        return $this->ownerScope;
    }

    public function hospitalUuid(): ?string
    {
        return $this->hospitalUuid;
    }

    /**
     * @return list<string>
     */
    public function authorizedRoles(): array
    {
        return $this->authorizedRoles;
    }

    public function status(): string
    {
        return $this->status;
    }

    public function publishedAt(): DateTimeImmutable
    {
        return $this->publishedAt ?? new DateTimeImmutable();
    }

    public function isAccessibleBy(string $role): bool
    {
        if (strcasecmp($role, 'Admin') === 0) {
            return true;
        }

        foreach ($this->authorizedRoles as $authorizedRole) {
            if (strcasecmp($authorizedRole, $role) === 0) {
                return true;
            }
        }

        return false;
    }

    private function assertValid(): void
    {
        if (trim($this->id) === '') {
            throw new DomainRuleViolation('El identificador de documento no puede estar vacio.');
        }

        if (trim($this->code) === '') {
            throw new DomainRuleViolation('El codigo de documento es obligatorio.');
        }

        if (trim($this->title) === '') {
            throw new DomainRuleViolation('El titulo del documento es obligatorio.');
        }

        if (trim($this->summary) === '') {
            throw new DomainRuleViolation('El resumen del documento es obligatorio.');
        }

        if (trim($this->content) === '') {
            throw new DomainRuleViolation('El contenido del documento no puede estar vacio.');
        }

        if (count($this->authorizedRoles) === 0) {
            throw new DomainRuleViolation('Debe especificarse al menos un rol autorizado para el documento.');
        }

        if ($this->ownerScope === OwnerScope::HOSPITAL && ($this->hospitalUuid === null || trim($this->hospitalUuid) === '')) {
            throw new DomainRuleViolation('Cuando el alcance es HOSPITAL, el hospitalUuid es obligatorio.');
        }

        if ($this->ownerScope === OwnerScope::CENTRAL && $this->hospitalUuid !== null) {
            throw new DomainRuleViolation('Cuando el alcance es CENTRAL, el hospitalUuid debe ser nulo.');
        }
    }
}
