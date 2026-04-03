<?php

declare(strict_types=1);

namespace App\Ai\Agents;

use NeuronAI\Agent\Agent;
use NeuronAI\Laravel\Facades\AIProvider;
use NeuronAI\Providers\AIProviderInterface;

class SentimentAnalyzer extends Agent
{
    protected function provider(): AIProviderInterface
    {
        /** @var AIProviderInterface */
        return AIProvider::driver('anthropic');
    }

    protected function instructions(): string
    {
        return <<<'INSTRUCTIONS'
        You are a sentiment analysis expert. Analyze the given text and return
        structured data about its sentiment, confidence level, key phrases,
        and a brief summary. Be precise and consistent in your analysis.

        Return your analysis in the following JSON format:
        {
            "sentiment": "positive|negative|neutral",
            "confidence": 0.0-1.0,
            "key_phrases": ["phrase1", "phrase2"],
            "summary": "Brief summary of the sentiment analysis"
        }
        INSTRUCTIONS;
    }
}
