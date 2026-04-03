<?php

declare(strict_types=1);

namespace App\Ai\Agents;

use NeuronAI\Agent\Agent;
use NeuronAI\Laravel\Facades\AIProvider;
use NeuronAI\Providers\AIProviderInterface;

class Writer extends Agent
{
    public function __construct(
        private readonly string $researchNotes,
    ) {
        parent::__construct();
    }

    protected function provider(): AIProviderInterface
    {
        return AIProvider::driver('anthropic');
    }

    protected function instructions(): string
    {
        return <<<INSTRUCTIONS
        You are a skilled article writer. Using the research notes provided below,
        write a clear, engaging article. Structure it with an introduction,
        body paragraphs, and conclusion. Keep it concise but informative.

        Research notes:
        {$this->researchNotes}
        INSTRUCTIONS;
    }
}
