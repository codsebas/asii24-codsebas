<?php

declare(strict_types=1);

namespace Week04\Domain\Exceptions;

use RuntimeException;

final class DuplicateDocumentException extends RuntimeException
{
    public static function forCode(string $code): self
    {
        return new self(sprintf('Ya existe un documento registrado con el codigo "%s".', $code));
    }
}
