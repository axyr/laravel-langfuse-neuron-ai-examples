<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Ai\Agents\StoryTeller;
use App\Console\Commands\Concerns\FormatsExampleOutput;
use Axyr\Langfuse\LangfuseFacade as Langfuse;
use Illuminate\Console\Command;
use NeuronAI\Chat\Messages\UserMessage;

class StreamingCommand extends Command
{
    use FormatsExampleOutput;

    protected $signature = 'example:streaming';

    protected $description = 'Example 4: Streaming with automatic Langfuse tracing';

    public function handle(): int
    {
        $this->header(
            'Example 4: Streaming',
            'Note: Neuron AI streaming may differ from Laravel AI. Complete text is captured in Langfuse.',
        );

        $prompt = 'Write a short story about a developer who discovers their Laravel application has become sentient.';

        $this->line("  <fg=gray>Prompt: {$prompt}</>");
        $this->newLine();
        $this->output->write('  ');

        // Note: Neuron AI streaming implementation may differ
        // For now, we'll get the complete response
        $response = (new StoryTeller())->chat(new UserMessage($prompt))->getMessage()->getContent();

        // Simulate streaming output
        $this->output->write($response);

        $this->newLine();

        Langfuse::flush();

        $this->langfuseReminder();

        return self::SUCCESS;
    }
}
