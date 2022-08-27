<?php

declare(strict_types=1);

namespace App\Http\Requests;

trait CollectsRulesFromMethods
{
    public function collectRules(): array
    {
        $rules = [];
        $methods = array_filter(
            get_class_methods($this),
            fn (string $methodName): bool => str_ends_with($methodName, 'CollectableRules')
        );

        foreach ($methods as $method) {
            $rules = [...$rules, ...$this->{$method}()];
        }

        return $rules;
    }
}
