<?php

namespace App\Http\Controllers;

use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Incoming\Answer;

class BotManController extends Controller
{
    /**
     * Place your BotMan logic here.
     */
//    public function handle()
    public function index()
    {
        $botman = app('botman');

        $botman->hears(['hi', 'Hi'], function($botman) {

//            if ($message == 'hi' || $message == 'Hi')
//            {
                $this->askQuestion($botman);
//            }
//            else
//            {
//                $botman->reply("Start a conversation by saying hi, please.");
//            }
        });

        $botman->hears(['what is your name', 'your name'], function($botman) {
            $botman->reply('My name is Botti');
            $this->askName($botman);
        });

        $botman->fallback(function($botman) {
            $botman->reply('Sorry, I did not understand these commands. Start a conversation by saying hi, please.');
        });

//        $botman->hears('call me {name}', function ($bot, $name) {
//            $bot->reply('Your name is: '.$name);
//        });
//
//        $botman->hears('your name {name}', function ($bot, $name) {
//            $bot->reply('Your name is: '.$name);
//        });

        $botman->listen();
    }
    /**
     * Place your BotMan logic here.
     */
    public function askQuestion($botman)
    {
        $question = Question::create("You choose??");
        $question->addButtons([
            Button::create('one')->value(1),
            Button::create('two')->value(2),
            Button::create('three')->value(3),
        ]);
        $botman->ask($question, function ($answer, $conversation)
        {
            $this->say('value: ' . $answer);
            $this->myvalue = $answer->getText();

            $conversation->ask('Can you tell me your email?', function (Answer $answer, $conversation)
            {
                $this->myemail = $answer->getText();

                $this->say('Email : ' . $this->myemail);

//                $this->userStorage()->save([
//                    'email' => $email,
//                ]);

                $conversation->ask('Confirm, if the above email is correct. You can simply with yes or no!', function (Answer $answer)
                {
                    if($answer == 'yes' || $answer == 'Yes')
                    {
                        $this->say('Thanks for information. Your email: ' . $this->myemail);
                    }
                    else
                    {
                        $this->say('not good((');
                    }
                });
            });
        });




//        $botman->ask('Hello! What is your Name?', function(Answer $answer) {
//
//            $name = $answer->getText();
//
//            $this->say('Nice to meet you '.$name);
//
//        });
    }

    public function askName($botman)
    {
        $botman->ask('What is your firstname?', function(Answer $answer) {
            // Save result
            $this->firstname = $answer->getText();

            $this->say('Nice to meet you '.$this->firstname);
        });
    }

    public function askEmail($botman)
    {
        $botman->ask('Can you tell me your email?', function (Answer $answer, $conversation)
        {
            $email= $answer->getText();

            $this->say('Email : ' . $email);

            $conversation->ask('Confirm, if the above email is correct. You can simply with yes or no!', function (Answer $answer, $conversation)
            {
                $confirmEmail= $answer->getText();

                if($answer == 'yes' || $answer == 'Yes')
                {
                    $this->say('We have got your details!');
                }
                else
                {
                    $this->say('Try more.....');
                }
            });
        });
    }



    public function myRandQuote()
    {
        $quotes = [
            'When there is no desire, all things are at peace. - Laozi',
            'Simplicity is the ultimate sophistication. - Leonardo da Vinci',
            'Simplicity is the essence of happiness. - Cedric Bledsoe',
            'Smile, breathe, and go slowly. - Thich Nhat Hanh',
            'Simplicity is an acquired taste. - Katharine Gerould',
            'Well begun is half done. - Aristotle',
            'He who is contented is rich. - Laozi',
            'Very little is needed to make a happy life. - Marcus Antoninus',
            'It is quality rather than quantity that matters. - Lucius Annaeus Seneca',
            'Genius is one percent inspiration and ninety-nine percent perspiration. - Thomas Edison',
            'Computer science is no more about computers than astronomy is about telescopes. - Edsger Dijkstra',
        ];

        return $quotes[array_rand($quotes, 1)];
    }


    /*public function askName($botman)
    {
        $botman->ask('Hello! What is your Name?', function(Answer $answer, $conversation) {

            $name = $answer->getText();

            $this->say('Nice to meet you '.$name);

            $conversation->ask('Can you tell me your email?', function (Answer $answer, $conversation)
            {
                $email= $answer->getText();

                $this->say('Email : ' . $email);

                $conversation->ask('Confirm, if the above email is correct. You can simply with yes or no!', function (Answer $answer, $conversation)
                {
                    $confirmEmail= $answer->getText();

                    if($answer == 'yes' || $answer == 'Yes')
                    {
                        $this->say('We have got your details!');
                    }
                    else
                    {
                        $this->say('not good((');
                    }
                });

            });
        });
    }
     */
}
