<?php

declare(strict_types=1);

use Axyr\Langfuse\LangfuseFacade as Langfuse;

it('creates a nested trace hierarchy for the RAG pipeline', function () {
    if (! config('services.openai.api_key')) {
        $this->markTestSkipped('OpenAI API key not configured');
    }

    $fake = Langfuse::fake();

    $this->artisan('example:rag-pipeline')->assertSuccessful();

    $fake->assertTraceCreated('rag-pipeline')
        ->assertSpanCreated('retrieval')
        ->assertSpanCreated('vector-search')
        ->assertSpanCreated('reranking')
        ->assertGenerationCreated('embed-query')
        ->assertEventCreated('context-assembled')
        ->assertScoreCreated('answer-relevance');
});
