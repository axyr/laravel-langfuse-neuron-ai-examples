<?php

declare(strict_types=1);

namespace App\Ai\Agents;

use NeuronAI\Agent\Agent;
use NeuronAI\Laravel\Facades\AIProvider;
use NeuronAI\Providers\AIProviderInterface;

class RagAnswerer extends Agent
{
    public function __construct(
        private readonly string $context,
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
        You are a knowledgeable assistant that answers questions based strictly
        on the provided context. If the answer is not in the context, say so.
        Be precise and cite relevant parts of the context.

        Context:
        {$this->context}
        INSTRUCTIONS;
    }
}
