<?php

namespace App\Rules;

use App\OpenAI\Chat;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use OpenAI\Laravel\Facades\OpenAI;

class SpamFree implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $response = (new Chat)
            ->assistant('You are a forum moderator designed to always output json')
            ->say(<<<EOT
                Can you tell me if the following text is spam?

                {$value}
                Expected response example:
                {"is_spam": true|false}
                EOT);
    
        if(json_decode($response)?->is_spam){
            $fail('Spam was detected');
        }
    }
}
