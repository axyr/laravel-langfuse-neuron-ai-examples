<?php

declare(strict_types=1);

namespace App\Ai\Agents;

use App\Ai\Tools\Calculator;
use App\Ai\Tools\SearchWeb;
use NeuronAI\Agent\Agent;
use NeuronAI\Laravel\Facades\AIProvider;
use NeuronAI\Providers\AIProviderInterface;

class ResearchAssistant extends Agent
{
    protected function provider(): AIProviderInterface
    {
        /** @var AIProviderInterface */
        return AIProvider::driver('anthropic');
    }

    protected function instructions(): string
    {
        return <<<'INSTRUCTIONS'
        You are a research assistant with access to web search and a calculator.
        Use the search tool to find information and the calculator for any
        mathematical computations. Provide well-researched, accurate answers.
        INSTRUCTIONS;
    }

    protected function tools(): array
    {
        return [
            SearchWeb::make(),
            Calculator::make(),
        ];
    }
}
