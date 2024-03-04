<?php

declare(strict_types=1);

namespace Paul\CustomPhpstanRules\Architecture;

use PhpParser\Node;
use PhpParser\Node\Stmt\Return_;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Type\ArrayType;
use PHPStan\Type\IntersectionType;
use PHPStan\Type\NullType;
use PHPStan\Type\UnionType;

/**
 * @implements Rule<Return_>
 */
class NoNullOrArrayReturnRule implements Rule
{
    public function getNodeType(): string
    {
        return Return_::class;
    }

    /**
     * @param Return_ $node
     * @param Scope $scope
     * @return array<string>
     */
    public function processNode(Node $node, Scope $scope): array
    {
        if ($node instanceof Node\Stmt\Return_ && $node->expr !== null) {

            $classMethodNode = $node->getAttribute('parent');
            if ($classMethodNode instanceof Node\Stmt\ClassMethod) {
                if(!$classMethodNode->isPublic()){
                    return [];
                }
            }

            $returnType = $scope->getType($node->expr);

            if ($returnType instanceof NullType ) {
                return ['Returning null from a method is not allowed. Use Null Object Pattern'];
            }

            if ($returnType instanceof ArrayType) {
                return ['Returning array from a method is not allowed. Use a Collection or a Value Object instead.'];
            }

            // Union types exists since 8.0
            // What about intersection types of 8.1?
            // I think we can skip intersection types because
            // they cannot be null AND another type
            if ($returnType instanceof UnionType || $returnType instanceof IntersectionType) {

                foreach ($returnType->getTypes() as $type) {
                    if ($type instanceof NullType ) {
                        return ['Returning null from a method is not allowed. Use Null Object Pattern'];
                    }

                    if ($type instanceof ArrayType) {
                        return ['Returning array from a method is not allowed. Use a Collection or a Value Object instead.'];
                    }
                }

                return [];
            }
        }
    
        return [];
    }
}
