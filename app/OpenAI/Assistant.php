<?php

namespace App\OpenAI;

use OpenAI\Laravel\Facades\OpenAI;

class Assistant
{
    protected $assistant;
    protected string $threadId;
    protected OpenAIClient $client;

    public function __construct(string $assistantId, ?AIClient $client = null)
    {
        $this->client = $client ?? new OpenAIClient();
        $this->assistant = $this->client->retreiveAssistant($assistantId);        
    }

    public static function create(array $config = [])
    {
        $client = new Client();

        $defaultConfig = [
            'name' => 'Programming teacher',
            'instructions' => 'You are a programming teacher',
            'model' => 'gpt-4-turbo-preview',
            'tools' => [
                ['type' => 'retrieval']
            ]
        ];

        $assistant = $client->createAssistant(array_merge_recursive($defaultConfig, $config));

        return new static($assistant->id);
    }

    public function messages()
    {
        return $this->client->messages($this->threadId);
    }

    public function upload(string $file): static
    {
        $this->client->uploadFile($file, $this->assistant->id);

        return $this;
    }

    public function createThread(array $parameters = []): static
    {
        $thread = $this->client->createThread($parameters);

        $this->threadId = $thread->id;

        return $this;
    }

    public function say(string $message): static
    {
        $this->client->createMessage($message, $this->threadId);

        return $this;
    }

    public function run()
    {
        return $this->client->run($this->threadId, $this->assistant->id);
    }
}