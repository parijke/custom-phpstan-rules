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
    private array $allowedMethods = ['__construct', '__invoke'];

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

        if ($this->exceedsAllowedPublicMethods($publicMethods, $publicMethodNames)) {
            return [sprintf('Controller "%s" should only have at most two public methods: __construct and __invoke.', $node->namespacedName)];
        }

        if ($this->missingInvokeMethod($publicMethods, $publicMethodNames)) {
            return [sprintf('Controller "%s" should have a public __invoke method.', $node->namespacedName)];
        }

        return [];
    }

    private function exceedsAllowedPublicMethods(array $publicMethods, array $publicMethodNames): bool
    {
        return count($publicMethods) > 2 || (count($publicMethods) === 2 && array_diff($this->allowedMethods, $publicMethodNames));
    }

    private function missingInvokeMethod(array $publicMethods, array $publicMethodNames): bool
    {
        return count($publicMethods) === 1 && !in_array('__invoke', $publicMethodNames, true);
    }
}
