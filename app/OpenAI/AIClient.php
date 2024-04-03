<?php

namespace App\OpenAI;

interface AIClient
{
    public function retreiveAssistant(string $assistantId);

    public function createAssistant(array $config = []);

    public function messages(string $threadId);

    public function uploadFile(string $file, string $assistantId);

    public function createThread(array $parameters = []);

    public function createMessage(string $message, string $threadId);
    
    public function run(string $threadId, string $assistantId);
}