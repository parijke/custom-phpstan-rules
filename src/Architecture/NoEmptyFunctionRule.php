<?php

declare(strict_types=1);

namespace Parijke\CustomPhpstanRules\Architecture;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\ShouldNotHappenException;

class NoEmptyFunctionRule implements Rule
{
    public function getNodeType(): string
    {
        return \PhpParser\Node\Expr\FuncCall::class;
    }

    /**
     * @param Node $node
     * @param Scope $scope
     * @return string[] errors
     * @throws ShouldNotHappenException
     */
    public function processNode(Node $node, Scope $scope): array
    {
        assert($node instanceof Node\Expr\FuncCall);

        if (!$node->name instanceof Node\Name) {
            throw new ShouldNotHappenException();
        }

        if ((string) $node->name === 'empty') {
            return ['Using "empty()" function is not allowed.'];
        }

        return [];
    }
}
