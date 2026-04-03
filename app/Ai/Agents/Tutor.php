<?php

declare(strict_types=1);

namespace App\Ai\Agents;

use NeuronAI\Agent\Agent;
use NeuronAI\Laravel\Facades\AIProvider;
use NeuronAI\Providers\AIProviderInterface;

class Tutor extends Agent
{
    protected function provider(): AIProviderInterface
    {
        /** @var AIProviderInterface */
        return AIProvider::driver('anthropic');
    }

    protected function instructions(): string
    {
        return <<<'INSTRUCTIONS'
        You are a patient, knowledgeable tutor. Explain concepts clearly and
        build on previous messages in the conversation. Ask follow-up questions
        to check understanding. Adapt your explanations based on the student's
        level of knowledge shown in prior exchanges.
        INSTRUCTIONS;
    }
}
