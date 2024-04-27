<?php

declare(strict_types=1);

namespace Rules\Architecture;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use Parijke\CustomPhpstanRules\Architecture\InterfaceNameRule;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(InterfaceNameRule::class)]
class InterfaceNameRuleTest extends RuleTestCase
{

    protected function getRule(): Rule
    {
        return new InterfaceNameRule();
    }

    public function testRule(): void
    {
        $this->analyse([__DIR__ . '/data/TestMe.php'], [
                [
                    'Interface TestMe should end with "Interface".',
                    03,
                ],
            ]
        );
    }
}
