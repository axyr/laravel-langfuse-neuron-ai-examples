<?php

declare(strict_types=1);

namespace App\Ai\Tools;

use NeuronAI\Tools\PropertyType;
use NeuronAI\Tools\Tool;
use NeuronAI\Tools\ToolInterface;
use NeuronAI\Tools\ToolProperty;

class Calculator
{
    public static function make(): ToolInterface
    {
        return Tool::make(
            'calculator',
            'Evaluate a mathematical expression and return the result.',
        )
            ->addProperty(
                new ToolProperty(
                    name: 'expression',
                    type: PropertyType::STRING,
                    description: 'The mathematical expression to evaluate, e.g. "2 + 2" or "sqrt(16)"',
                    required: true,
                ),
            )
            ->setCallable(function (?string $expression): string {
                // Validate input
                $sanitized = $expression ? preg_replace('/[^0-9+\-*\/().%\s]/', '', $expression) : null;

                if (! $sanitized) {
                    return json_encode(['error' => 'Invalid expression', 'expression' => $expression], JSON_THROW_ON_ERROR);
                }

                try {
                    $result = eval("return (float)({$sanitized});");

                    return json_encode([
                        'expression' => $expression,
                        'result' => $result,
                    ], JSON_THROW_ON_ERROR);
                } catch (\Throwable) {
                    return json_encode([
                        'expression' => $expression,
                        'error' => 'Could not evaluate expression',
                    ], JSON_THROW_ON_ERROR);
                }
            });
    }
}
