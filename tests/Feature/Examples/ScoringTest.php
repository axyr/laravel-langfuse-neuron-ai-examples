<?php

declare(strict_types=1);

use Axyr\Langfuse\LangfuseFacade as Langfuse;

it('creates a trace with scores attached', function () {
    if (! config('services.openai.api_key')) {
        $this->markTestSkipped('OpenAI API key not configured');
    }

    $fake = Langfuse::fake();

    $this->artisan('example:scoring')->assertSuccessful();

    $fake->assertTraceCreated('scoring-example')
        ->assertScoreCreated('relevance')
        ->assertScoreCreated('conciseness')
        ->assertScoreCreated('quality');
});
