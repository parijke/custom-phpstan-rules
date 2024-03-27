<?php

declare(strict_types=1);

namespace Parijke\CustomPhpstanRules\Architecture;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;

class InvokableControllerRule implements Rule
{
    public function getNodeType(): string
    {
        return Class_::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        assert($node instanceof Class_);

        if (!str_ends_with((string) $node->namespacedName, 'Controller')) {
            return [];
        }

        $publicMethods = array_filter($node->getMethods(), fn(ClassMethod $method) => $method->isPublic());
        $publicMethodNames = array_map(fn(ClassMethod $method) => $method->name->toString(), $publicMethods);

        if (count($publicMethods) > 2 || (count($publicMethods) === 2 && !in_array('__construct', $publicMethodNames, true))) {
            return [sprintf('Controller "%s" should only have at most two public methods: __construct and __invoke.', $node->namespacedName)];
        }

        if (count($publicMethods) === 1 && !in_array('__invoke', $publicMethodNames, true)) {
            return [sprintf('Controller "%s" should have a public __invoke method.', $node->namespacedName)];
        }

        return [];
    }
}
