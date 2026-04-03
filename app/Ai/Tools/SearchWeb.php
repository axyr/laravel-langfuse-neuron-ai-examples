<?php

declare(strict_types=1);

namespace App\Ai\Tools;

use NeuronAI\Tools\PropertyType;
use NeuronAI\Tools\Tool;
use NeuronAI\Tools\ToolInterface;
use NeuronAI\Tools\ToolProperty;

class SearchWeb
{
    public static function make(): ToolInterface
    {
        return Tool::make(
            'search_web',
            'Search the web for information on a given query. Returns relevant search results.',
        )
            ->addProperty(
                new ToolProperty(
                    name: 'query',
                    type: PropertyType::STRING,
                    description: 'The search query',
                    required: true,
                ),
            )
            ->setCallable(function (?string $query): string {
                if ($query === null) {
                    return json_encode(['error' => 'Query is required'], JSON_THROW_ON_ERROR);
                }

                // Simulated search results for demonstration purposes
                return json_encode([
                    'results' => [
                        [
                            'title' => "Result 1 for: {$query}",
                            'snippet' => "This is a relevant finding about {$query}. Studies show significant developments in this area.",
                            'url' => 'https://example.com/result-1',
                        ],
                        [
                            'title' => "Result 2 for: {$query}",
                            'snippet' => "Recent research on {$query} indicates new trends and patterns worth exploring.",
                            'url' => 'https://example.com/result-2',
                        ],
                    ],
                ], JSON_THROW_ON_ERROR);
            });
    }
}
