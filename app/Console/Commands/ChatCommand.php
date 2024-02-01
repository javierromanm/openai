<?php

namespace App\Console\Commands;

use App\OpenAI\Chat;
use Illuminate\Console\Command;
use function Laravel\Prompts\{text, info, outro, spin};

class ChatCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chat {--assistant=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ask questions to OpenAI';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $chat = new Chat();

        if($this->option('assistant')){
            $chat->assistant($this->option('assistant'));
        }

        while($question = text('Ask OpenAI')){
            $response = spin(fn() => $chat->say($question), 'Thinking...');
            info($response);
        };

        outro('Conversation over');
    }
}
