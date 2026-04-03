<?php

declare(strict_types=1);

namespace App\Ai\Agents;

use NeuronAI\Agent\Agent;
use NeuronAI\Laravel\Facades\AIProvider;
use NeuronAI\Providers\AIProviderInterface;

class PromptDrivenAgent extends Agent
{
    public function __construct(
        private readonly string $compiledPrompt,
    ) {
        parent::__construct();
    }

    protected function provider(): AIProviderInterface
    {
        return AIProvider::driver('anthropic');
    }

    protected function instructions(): string
    {
        return $this->compiledPrompt;
    }
}
