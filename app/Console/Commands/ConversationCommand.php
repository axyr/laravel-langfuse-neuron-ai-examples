<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Ai\Agents\Tutor;
use App\Console\Commands\Concerns\FormatsExampleOutput;
use Axyr\Langfuse\Dto\TraceBody;
use Axyr\Langfuse\LangfuseFacade as Langfuse;
use Illuminate\Console\Command;
use NeuronAI\Chat\Messages\UserMessage;

class ConversationCommand extends Command
{
    use FormatsExampleOutput;

    protected $signature = 'example:conversation';

    protected $description = 'Example 9: Multi-turn conversation with Langfuse session grouping';

    public function handle(): int
    {
        $this->header(
            'Example 9: Conversation',
            'Multi-turn conversation with session grouping in Langfuse.',
        );

        $sessionId = 'session-' . substr(md5((string) time()), 0, 8);

        $turns = [
            'What is dependency injection and why should I use it?',
            'Can you give me a practical example using Laravel service container?',
            'How does this relate to testing? Can you show how DI makes testing easier?',
        ];

        $tutor = new Tutor();

        foreach ($turns as $index => $question) {
            $turnNumber = $index + 1;
            $this->line("  <fg=gray>Turn {$turnNumber}: {$question}</>");

            // Create a trace per turn, linked by sessionId
            $trace = Langfuse::trace(new TraceBody(
                name: "conversation-turn-{$turnNumber}",
                sessionId: $sessionId,
                userId: 'student-1',
                input: $question,
                metadata: ['turn' => $turnNumber],
            ));
            Langfuse::setCurrentTrace($trace);

            // Note: Neuron AI conversation memory handling may differ from Laravel AI
            // This example shows basic chat without persistence
            $response = $tutor->chat(new UserMessage($question))->getMessage()->getContent();

            $trace->update(new TraceBody(output: $response));

            $this->newLine();
            $this->line("  <fg=white>Tutor: {$response}</>");
            $this->newLine();
        }

        $this->line("  <fg=gray>Session ID: {$sessionId} - all 3 turns are grouped in Langfuse.</>");

        Langfuse::flush();

        $this->langfuseReminder();

        return self::SUCCESS;
    }
}
