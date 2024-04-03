<?php

namespace App\OpenAI;

use OpenAI\Laravel\Facades\OpenAI;

class OpenAIClient implements AIClient
{

    public function retreiveAssistant(string $assistantId)
    {
        return OpenAI::assistants()->retrieve($assistantId);
        
    }

    public function createAssistant(array $config = [])
    {
        return OpenAI::assistants()->create($config);
    }

    public function messages(string $threadId)
    {
        return OpenAI::threads()->messages()->list($threadId);
    }

    public function uploadFile(string $file, string $assistantId)
    {
        $file = OpenAI::files()->upload([
            'purpose' => 'assistants',
            'file' => fopen($file, 'rb')
        ]);

        return OpenAI::assistants()
            ->files()
            ->create($assistantId, ['file_id' => $file->id]);
        
    }

    public function createThread(array $parameters = [])
    {
        return OpenAI::threads()->create($parameters);
        
    }

    public function createMessage(string $message, string $threadId)
    {
        return OpenAI::threads()->messages()->create($threadId, [
            'role' => 'user',
            'content' => $message
        ]);        
    }

    public function run(string $threadId, string $assistantId)
    {
        $run = OpenAI::threads()->runs()->create($threadId, [
            'assistant_id' => $assistantId
        ]);
            
        while ($this->runStatus($run)) {
            sleep(1);
        }    
        
        return $this->messages($threadId);   
    }

    protected function runStatus($run): bool
    {
        $run = OpenAI::threads()->runs()->retrieve(
            threadId: $run->threadId,
            runId: $run->id
        );

        return $run->status !== 'completed';  
    }

}