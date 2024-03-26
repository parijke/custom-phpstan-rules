<?php

declare(strict_types=1);

namespace Parijke\CustomPhpstanRules\Architecture;

use PhpParser\Node;
use PhpParser\Node\Expr\Empty_;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;

class NoEmptyFunctionRule implements Rule
{
    public function getNodeType(): string
    {
        return Empty_::class;

    }

    /**
     * @param Node $node
     * @param Scope $scope
     * @return string[] errors
     */
    public function processNode(Node $node, Scope $scope): array
    {
        if ($node instanceof Empty_) {
            return ['Using "empty()" function is not allowed.'];
        }

        return [];
    }
}
