<?php

declare(strict_types=1);

namespace Rules\Architecture;

use Parijke\CustomPhpstanRules\Architecture\InvokableControllerRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(InvokableControllerRule::class)]
class InvokableControllerRuleTest extends RuleTestCase
{

    protected function getRule(): Rule
    {
        return new InvokableControllerRule();
    }

    public function testRule(): void
    {
        $this->analyse([__DIR__ . '/data/MyController.php'], [
                [
                    'Controller "Rules\Architecture\data\MyController" should have a public __invoke method.',
                    06,
                ],
            ]
        );
    }
}
