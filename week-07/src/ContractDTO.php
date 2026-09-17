<?php

declare(strict_types=1);

namespace Week07\Src;

final class PublishContractCommand
{
    public function __construct(
        public readonly string $title,
        public readonly string $version,
        public readonly string $summary,
        public readonly string $content,
        public readonly string $ownerScope,
        public readonly ?string $hospitalUuid,
        public readonly array $allowedRoles
    ) {
        if (trim($this->title) === '') {
            throw new \InvalidArgumentException('El titulo del contrato no puede estar vacio.');
        }
        if (!preg_match('/^\d+\.\d+\.\d+$/', $this->version)) {
            throw new \InvalidArgumentException("La version '{$this->version}' no cumple el formato SemVer (X.Y.Z).");
        }
        if ($this->ownerScope === 'HOSPITAL' && empty($this->hospitalUuid)) {
            throw new \InvalidArgumentException('Para alcance HOSPITAL es obligatorio especificar hospitalUuid.');
        }
        if (empty($this->allowedRoles)) {
            throw new \InvalidArgumentException('Debe asignarse al menos un rol autorizado al contrato.');
        }
    }
}

final class ContractDetailResponse
{
    public function __construct(
        public readonly string $id,
        public readonly string $title,
        public readonly string $version,
        public readonly string $status,
        public readonly string $ownerScope,
        public readonly array $allowedRoles
    ) {}

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'version' => $this->version,
            'status' => $this->status,
            'ownerScope' => $this->ownerScope,
            'allowedRoles' => $this->allowedRoles,
        ];
    }
}
