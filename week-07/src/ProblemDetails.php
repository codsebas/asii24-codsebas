<?php

declare(strict_types=1);

namespace Week07\Src;

final class ProblemDetails
{
    public function __construct(
        public readonly string $type,
        public readonly string $title,
        public readonly int $status,
        public readonly string $detail,
        public readonly string $instance,
        public readonly string $code
    ) {}

    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'title' => $this->title,
            'status' => $this->status,
            'detail' => $this->detail,
            'instance' => $this->instance,
            'code' => $this->code,
        ];
    }

    public static function fromException(\Throwable $e, string $instance): self
    {
        $status = match (true) {
            $e instanceof \InvalidArgumentException => 422,
            str_contains($e->getMessage(), 'no autorizado') || str_contains($e->getMessage(), 'denegado') => 403,
            str_contains($e->getMessage(), 'no encontrado') => 404,
            str_contains($e->getMessage(), 'duplicado') => 409,
            default => 500
        };

        $type = match ($status) {
            403 => 'https://shi.hospital.gt/errors/forbidden',
            404 => 'https://shi.hospital.gt/errors/not-found',
            409 => 'https://shi.hospital.gt/errors/conflict',
            422 => 'https://shi.hospital.gt/errors/validation',
            default => 'https://shi.hospital.gt/errors/internal'
        };

        return new self(
            type: $type,
            title: match ($status) {
                403 => 'Acceso Denegado por Rol',
                404 => 'Recurso No Encontrado',
                409 => 'Conflicto de Version o Codigo',
                422 => 'Error de Validacion de Datos',
                default => 'Error Interno del Servidor'
            },
            status: $status,
            detail: $e->getMessage(),
            instance: $instance,
            code: "ERR_HTTP_{$status}"
        );
    }
}
