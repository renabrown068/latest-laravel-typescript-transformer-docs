<?php

namespace Spatie\TypescriptTransformer\ClassPropertyProcessors;

use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\Types\Object_;
use Spatie\DataTransferObject\DataTransferObjectCollection;

class ReplaceDefaultTypesClassPropertyProcessor implements ClassPropertyProcessor
{
    use ProcessesClassProperties;

    /** @var array<string, Type> */
    private array $mapping;

    public function __construct(array $mapping)
    {
        $this->mapping = $mapping;
    }

    public function process(Type $type): Type
    {
        return $this->walk($type, function (Type $type) {
            if (! $type instanceof Object_) {
                return $type;
            }

            foreach ($this->mapping as $replacementClass => $replacementType) {
                if (ltrim($type->getFqsen(), '\\') === $replacementClass) {
                    return $replacementType;
                }
            }

            return $type;
        });
    }


}
