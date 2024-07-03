<?php

declare(strict_types=1);

namespace Parijke\CustomPhpstanRules\Architecture;

use PhpParser\Node;
use PhpParser\Node\Stmt\Throw_;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Type\ObjectType;

class NoGenericExceptionRule implements Rule
{

    public function getNodeType(): string
    {
        return Throw_::class;
    }

        public function processNode(Node $node, Scope $scope): array
    {
        $exprType = $scope->getType($node->expr);

        if ($exprType instanceof ObjectType) {
            $className = $exprType->getClassName();
            if ($className === \Exception::class) {
                return [
                    'Generic Exception is not allowed. Use a dedicated exception class instead.'
                ];
            }
        }

        return [];
    }
}
