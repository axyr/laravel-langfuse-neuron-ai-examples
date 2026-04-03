<?php

declare(strict_types=1);

namespace App\Ai\Agents;

use NeuronAI\Agent\Agent;
use NeuronAI\Laravel\Facades\AIProvider;
use NeuronAI\Providers\AIProviderInterface;

class Researcher extends Agent
{
    protected function provider(): AIProviderInterface
    {
        return AIProvider::driver('anthropic');
    }

    protected function instructions(): string
    {
        return <<<'INSTRUCTIONS'
        You are a thorough researcher. Given a topic, produce well-organized
        bullet-point research notes covering the key facts, statistics, and
        insights. Focus on accuracy and breadth of coverage. Keep your
        response structured and scannable.
        INSTRUCTIONS;
    }
}
