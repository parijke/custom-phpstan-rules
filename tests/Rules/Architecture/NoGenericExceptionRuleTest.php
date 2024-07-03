<?php

declare(strict_types=1);

namespace Rules\Architecture;

use Parijke\CustomPhpstanRules\Architecture\NoGenericExceptionRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(NoGenericExceptionRule::class)]
class NoGenericExceptionRuleTest extends RuleTestCase
{

    protected function getRule(): Rule
    {
        return new NoGenericExceptionRule();
    }

    public function testRule(): void
    {
        $this->analyse([__DIR__ . '/data/IllegalExceptionUsed.php'], [
                [
                    'Generic Exception is not allowed. Use a dedicated exception class instead.',
                    14,
                ],
            ]
        );
    }
}
