<?php

namespace App\OpenAI;

use Illuminate\Support\Facades\Http;
use OpenAI\Laravel\Facades\OpenAI;

class Chat
{

    protected array $messages = [];

    public function __construct(array $messages = [])
    {
        $this->messages = $messages;
    }

    public function messages()
    {
        return $this->messages;
    }

    protected function addMessage(string $message, string $role = 'user'): self
    {
        $this->messages[] = [
            'role' => $role,
            'content' => $message
        ];

        return $this;
    }

    public function assistant(string $message): static
    {
        $this->addMessage($message, 'system');

        return $this;
    }

    public function say(string $message, bool $speech = false): ?string
    {
        $this->addMessage($message);

        $response = OpenAI::chat()->create(
            [
                "model" => "gpt-3.5-turbo-1106",
                "messages" => $this->messages
            ])->choices[0]->message->content;
        
        if ($response) {
            $this->addMessage($response, 'assistant');
        }        

        return $speech ? $this->speech($response) : $response;

    }

    public function speech(string $message): string
    {
        return OpenAI::audio()->speech([
            'model' => 'tts-1',
            'voice' => 'echo',
            'input' => $message
        ]);
    }

    public function visualize(string $description, array $options = []): string
    {  
        $this->addMessage($description);

        $description = collect($this->messages)->where('role', 'user')->pluck('content')->implode(' ');

        $options = array_merge([
            'prompt' => $description,
            'model' => 'dall-e-3'
        ], $options);

        $url = OpenAI::images()->create($options)->data[0]->url;

        $this->addMessage($url, 'assistant');

        return $url;
    }
    
}
