<?php

declare(strict_types=1);

namespace Rules\Architecture;

use Parijke\CustomPhpstanRules\Architecture\NoEmptyFunctionRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(NoEmptyFunctionRule::class)]
class NoEmptyFunctionRuleTest extends RuleTestCase
{

    protected function getRule(): Rule
    {
        return new NoEmptyFunctionRule();
    }

    
    public function testRule(): void
    {
        $this->analyse([__DIR__ . '/data/usage-of-empty.php'], [
                [
                    'Using "empty()" function is not allowed.',
                    04,
                ],
            ]
        );
    }
}
