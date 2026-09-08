<?php

declare(strict_types=1);

namespace Week04\Domain\Exceptions;

use RuntimeException;

final class DocumentNotFoundException extends RuntimeException
{
    public static function forId(string $id): self
    {
        return new self(sprintf('El documento con ID "%s" no fue encontrado o no esta disponible.', $id));
    }
}
