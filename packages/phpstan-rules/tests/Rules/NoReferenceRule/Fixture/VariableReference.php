<?php

declare(strict_types=1);

namespace Symplify\PHPStanRules\Tests\Rules\NoReferenceRule\Fixture;

final class VariableReference
{
    public function someMethod($value3)
    {
        $value = &$value3;

        return $value;
    }
}
