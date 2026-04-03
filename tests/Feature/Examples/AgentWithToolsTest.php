<?php

declare(strict_types=1);

use Axyr\Langfuse\LangfuseFacade as Langfuse;

it('runs the agent with tools command successfully', function () {
    if (! config('services.openai.api_key')) {
        $this->markTestSkipped('OpenAI API key not configured');
    }

    Langfuse::fake();

    $this->artisan('example:agent-with-tools')->assertSuccessful();

    Langfuse::assertTraced();
});
