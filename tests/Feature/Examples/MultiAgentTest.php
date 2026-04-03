<?php

declare(strict_types=1);

use Axyr\Langfuse\LangfuseFacade as Langfuse;

it('creates a single trace with spans for both agents', function () {
    if (! config('services.openai.api_key')) {
        $this->markTestSkipped('OpenAI API key not configured');
    }

    $fake = Langfuse::fake();

    $this->artisan('example:multi-agent')->assertSuccessful();

    $fake->assertTraceCreated('researcher-writer-pipeline')
        ->assertSpanCreated('research-phase')
        ->assertSpanCreated('writing-phase');
});
