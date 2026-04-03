<?php

declare(strict_types=1);

namespace App\Ai\Agents;

use NeuronAI\Agent\Agent;
use NeuronAI\Laravel\Facades\AIProvider;
use NeuronAI\Providers\AIProviderInterface;

class Summarizer extends Agent
{
    protected function provider(): AIProviderInterface
    {
        /** @var AIProviderInterface */
        return AIProvider::driver('anthropic');
    }

    protected function instructions(): string
    {
        return <<<'INSTRUCTIONS'
        You are a concise summarizer. Given any text, produce a clear summary
        that captures the key points in 2-3 sentences. Focus on the most
        important information and omit unnecessary details.
        INSTRUCTIONS;
    }
}
