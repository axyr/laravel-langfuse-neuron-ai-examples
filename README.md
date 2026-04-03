# Neuron AI + Langfuse Integration Examples

How do you know your LLM calls actually work? What's the latency? The cost? Are the answers any good?

You need observability. [Langfuse](https://langfuse.com) gives you that. [laravel-langfuse](https://github.com/axyr/laravel-langfuse) makes it work with Laravel. And [Neuron AI](https://neuron-ai.dev) is a powerful PHP Agentic Framework for building production-ready AI applications.

This repo has 9 artisan commands that show how these pieces fit together. From zero-config auto-tracing to multi-agent pipelines with scoring. Each example builds on the previous one.

## Prerequisites

- PHP 8.3+
- Docker and Docker Compose
- An [Anthropic API key](https://console.anthropic.com/)

## Setup

```bash
git clone <this-repo-url>
cd neuron-ai

# Start Langfuse locally (takes 2-3 minutes on first run)
docker compose up -d

# Install PHP dependencies
composer install

# Configure environment
cp .env.example .env
php artisan key:generate
php artisan migrate

# Add your Anthropic key to .env
# ANTHROPIC_API_KEY=sk-ant-...
# ANTHROPIC_KEY=sk-ant-...  # Neuron AI also uses this
```

The `.env.example` comes pre-configured with Langfuse keys that match the `docker-compose.yml` auto-provisioned project. No manual Langfuse setup needed.

**Langfuse UI:** http://localhost:3000 (login: `admin@example.com` / `password`)

To stop Langfuse: `docker compose down`

To reset all data: `docker compose down -v`

## Examples

| # | Command | What it demonstrates |
|---|---------|---------------------|
| 1 | `php artisan example:basic-agent` | Auto-tracing with zero Langfuse code |
| 2 | `php artisan example:agent-with-tools` | Tool calls appear as Langfuse spans |
| 3 | `php artisan example:structured-output` | Structured JSON output in generations |
| 4 | `php artisan example:streaming` | Streaming with auto-tracing |
| 5 | `php artisan example:prompt-management` | Langfuse prompt management linked to generations |
| 6 | `php artisan example:scoring` | Quality scores attached to traces |
| 7 | `php artisan example:rag-pipeline` | Nested trace hierarchy for a RAG pipeline |
| 8 | `php artisan example:multi-agent` | Multiple agents sharing a single trace |
| 9 | `php artisan example:conversation` | Multi-turn conversation with session grouping |

### 1. Basic Agent

The simplest integration. Set `LANGFUSE_NEURON_AI_ENABLED=true` and every Neuron AI call is automatically traced. No Langfuse code in your application.

**In Langfuse:** Auto-created trace with generation showing model, input, output, and token usage.

### 2. Agent with Tools

Same auto-tracing, but now the agent has tools. Each tool invocation creates a span inside the trace.

**In Langfuse:** Trace with generation + `tool-SearchWeb` and `tool-Calculator` spans.

### 3. Structured Output

Agent returns structured JSON. The structured response appears in the generation output.

**In Langfuse:** Generation output shows the structured JSON with sentiment, confidence, key phrases.

### 4. Streaming

Streaming works with auto-tracing. The complete accumulated text is captured after the stream finishes.

**In Langfuse:** Complete generation with full text.

### 5. Prompt Management

Create and fetch prompts from Langfuse's prompt management. Compile them with variables and link them to generations.

**In Langfuse:** Prompt in prompt management + trace with linked generation.

### 6. Scoring

Attach numeric and categorical quality scores to traces. Useful for evaluation dashboards.

**In Langfuse:** Trace with generation + 3 scores (relevance, conciseness, quality).

### 7. RAG Pipeline

A full Retrieval-Augmented Generation pipeline with nested spans showing each step: embedding, vector search, reranking, context assembly, and answer generation.

**In Langfuse:** Nested trace tree with spans, generations, events, and scores.

### 8. Multi-Agent Pipeline

Two agents (Researcher and Writer) sharing a single trace. `setCurrentTrace()` ensures both agents' auto-traced generations nest under the same parent.

**In Langfuse:** Single trace with research and writing spans, each containing an auto-traced generation.

### 9. Conversation

Multi-turn conversation where each turn creates its own trace, all linked by a `sessionId`.

**In Langfuse:** 3 traces grouped by session in the session view.

## Running Tests

```bash
vendor/bin/pest
```

Tests use `Langfuse::fake()` to verify behavior without real API calls.

## Packages

- [neuron-core/neuron-laravel](https://github.com/neuron-core/neuron-laravel) - Official Neuron AI Laravel SDK
- [neuron-core/neuron-ai](https://github.com/neuron-core/neuron-ai) - The PHP Agentic Framework
- [axyr/laravel-langfuse](https://github.com/axyr/laravel-langfuse) - Langfuse PHP SDK for Laravel with auto-instrumentation

## Key Differences from Laravel AI

This repository demonstrates Neuron AI integration with Langfuse. If you're looking for Laravel AI examples, check out the [ai directory](../ai).

**Main differences:**

1. **Agent Creation:**
   - Laravel AI: `Agent::make()->prompt($text)`
   - Neuron AI: `(new Agent())->chat(new UserMessage($text))->getMessage()->getContent()`

2. **Tools:**
   - Laravel AI: Class implements `Tool` interface
   - Neuron AI: Fluent builder with `Tool::make()` and `setCallable()`

3. **Configuration:**
   - Laravel AI: `config/ai.php` + `LANGFUSE_LARAVEL_AI_ENABLED`
   - Neuron AI: `config/neuron.php` + `LANGFUSE_NEURON_AI_ENABLED`

Both approaches work seamlessly with the laravel-langfuse package for automatic tracing and observability!

## Author

Built by [Martijn van Nieuwenhoven](https://martijnvannieuwenhoven.com) - Laravel developer specializing in AI integrations and observability tooling.
