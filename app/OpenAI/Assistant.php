<?php

namespace App\OpenAI;

use OpenAI\Laravel\Facades\OpenAI;

class Assistant
{
    protected $assistant;
    protected string $threadId;

    public function __construct(string $assistantId)
    {
        $this->assistant = OpenAI::assistants()->retrieve($assistantId);        
    }

    public static function create(array $config = [])
    {
        $assistant = OpenAI::assistants()->create(array_merge_recursive([
            'name' => 'Programming teacher',
            'instructions' => 'You are a programming teacher',
            'model' => 'gpt-4-turbo-preview',
            'tools' => [
                ['type' => 'retrieval']
            ]
        ], $config));

        return new static($assistant->id);
    }

    public function messages()
    {
        return OpenAI::threads()->messages()->list($this->threadId);
    }

    public function upload(string $file): static
    {
        $file = OpenAI::files()->upload([
            'purpose' => 'assistants',
            'file' => fopen($file, 'rb')
        ]);

        OpenAI::assistants()->files()->create($this->assistant->id, ['file_id' => $file->id]);

        return $this;
    }

    public function createThread(array $parameters = []): static
    {
        $thread = OpenAI::threads()->create($parameters);

        $this->threadId = $thread->id;

        return $this;
    }

    public function say(string $message): static
    {
        OpenAI::threads()->messages()->create($this->threadId, [
            'role' => 'user',
            'content' => $message
        ]);

        return $this;
    }

    public function run()
    {
        $run = OpenAI::threads()->runs()->create($this->threadId, [
            'assistant_id' => $this->assistant->id
        ]);

        do {
            sleep(1);
            $run = OpenAI::threads()->runs()->retrieve(
                threadId: $this->threadId,
                runId: $run->id
            );
        } while ($run->status !== 'completed');
    
        return $this->messages();    
    }

}