<?php

declare(strict_types=1);

namespace Week04\Domain;

enum OwnerScope: string
{
    case CENTRAL = 'CENTRAL';
    case HOSPITAL = 'HOSPITAL';
}
