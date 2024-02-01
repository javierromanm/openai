<?php

namespace App\OpenAI;

use Illuminate\Support\Facades\Http;
use OpenAI\Laravel\Facades\OpenAI;

class Chat
{

    protected array $messages = [];

    public function messages()
    {
        return $this->messages;
    }

    public function assistant(string $message): static
    {
        $this->messages[] = [
            "role" => "system",
            "content" => $message
        ];

        return $this;
    }

    public function say(string $message): ?string
    {
        $this->messages[] = [
            "role" => "user",
            "content" => $message
        ];

        $response = OpenAI::chat()->create(
            [
                "model" => "gpt-3.5-turbo",
                "messages" => $this->messages
            ])->choices[0]->message->content;
        
        if ($response) {
            $this->messages[] = [
                "role" => "assistant",
                "content" => $response
            ];
        }        

        return $response;

    }
    
}
