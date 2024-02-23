<?php

declare(strict_types=1);

namespace Paul\CustomPhpstanRules\Architecture;

use PhpParser\Node\Stmt\Interface_;
use PHPStan\Rules\Rule;
use PhpParser\Node;
use PHPStan\Analyser\Scope;

class InterfaceNameRule implements Rule
{
    public function getNodeType(): string
    {
        return Interface_::class;
    }

    /**
     * @param Interface_ $node
     * @param Scope $scope
     * @return string[] errors
     */
    public function processNode(Node $node, Scope $scope): array
    {
        if (! str_ends_with($node->name->toString(), 'Interface')) {
            return [sprintf('Interface %s should end with "Interface".', $node->name->toString())];
        }

        return [];
    }
}
