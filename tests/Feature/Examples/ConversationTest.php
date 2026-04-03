<?php

declare(strict_types=1);

use Axyr\Langfuse\LangfuseFacade as Langfuse;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('creates traces grouped by session for a multi-turn conversation', function () {
    if (! config('services.openai.api_key')) {
        $this->markTestSkipped('OpenAI API key not configured');
    }

    $fake = Langfuse::fake();

    $this->artisan('example:conversation')->assertSuccessful();

    $fake->assertTraceCreated('conversation-turn-1')
        ->assertTraceCreated('conversation-turn-2')
        ->assertTraceCreated('conversation-turn-3');
});
