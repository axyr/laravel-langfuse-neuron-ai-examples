<?php

declare(strict_types=1);

use Axyr\Langfuse\LangfuseFacade as Langfuse;

it('creates a prompt and a manually traced generation', function () {
    if (! config('services.openai.api_key')) {
        $this->markTestSkipped('OpenAI API key not configured');
    }

    $fake = Langfuse::fake();

    $this->artisan('example:prompt-management')->assertSuccessful();

    $fake->assertPromptCreated('topic-explainer')
        ->assertTraceCreated('prompt-management-example');
});
