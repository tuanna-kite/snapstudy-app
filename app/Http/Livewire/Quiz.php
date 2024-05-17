<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Quiz extends Component
{
    public $orderType = ['A', 'B', 'C', 'D'];
    public $data = [
        [
            'ques' =>
                'Which of the following correctly describes vision statement and mission statement, respectively?',
            'choices' => [
                'The mission statement describes what the organization intends to be or become and answers the question, “Who are we?” The mission statement guides subsequently the development of the vision statement. The vision statement describes what the organization is committed to do or how it will act and answers the question, “What do we do?”',
                'The vision statement describes what the organization intends to be or become and answers the question, “Who are we?” The vision statement guides subsequently the development of the mission statement. The mission statement describes what the organization is committed to do or how it will act and answers the question, “What do we do?”',
                'The vision statement describes what the organization intends to be or become and answers the question, “What do we do?” The vision statement guides subsequently the development of the mission statement. The mission statement describes what the organization is committed to do or how it will act and answers the question, “Who are we?”',
                'The mission statement describes what the organization is committed to do or how it will act and answers the question, “Who are we?” The mission statement guides subsequently the development of the vision statement. The vision statement describes what the organization intends to be or become and answers the question, “What do we do?”',
            ],
            'ans' => 0,
        ],
        [
            'ques' =>
                'Which of the following correctly describes an example of following the differentiation strategy?',
            'choices' => [
                'A company focuses its advertisements on how its product costsny focuses its  less than similar products sold by competitors.',
                'A company focuses its advertisements on hny focuses its ow its product is s product is s product is higher quality than similar products sold by competitors.',
                'A company chooses not to advertise its product as a way tls products innyls products innyo cut costs.',
                'A company focuses its advertisements on how it sells products inny focuses its  one industry segment and is therefore an expert in that segment.',
            ],
            'ans' => 1,
        ],
        [
            'ques' =>
                'Which of the following correctly describes an example of following the differentiation strategy?',
            'choices' => [
                'A company focuses its advertisements on how its product costs less than similar products sold by competitors.',
                'A company focuses its advertisements on how its product is higher quality than similar products sold by competitors.',
                'A company chooses not to advertise its product as a way to cut costs.',
                'A company focuses its advertisements on how it sells products in one industry segment and is therefore an expert in that segment.',
            ],
            'ans' => 1,
        ],
        [
            'ques' =>
                'Which of the following correctly describes vision statement and mission statement, respectively?',
            'choices' => [
                'The mission statement describes what the organization intends to be or become and answers the question, “Who are we?” The mission statement guides subsequently the development of the vision statement. The vision statement describes what the organization is committed to do or how it will act and answers the question, “What do we do?”',
                'The vision statement describes what the organization intends to be or become and answers the question, “Who are we?” The vision statement guides subsequently the development of the mission statement. The mission statement describes what the organization is committed to do or how it will act and answers the question, “What do we do?”',
                'The vision statement describes what the organization intends to be or become and answers the question, “What do we do?” The vision statement guides subsequently the development of the mission statement. The mission statement describes what the organization is committed to do or how it will act and answers the question, “Who are we?”',
                'The mission statement describes what the organization is committed to do or how it will act and answers the question, “Who are we?” The mission statement guides subsequently the development of the vision statement. The vision statement describes what the organization intends to be or become and answers the question, “What do we do?”',
            ],
            'ans' => 0,
        ],
    ];

    public $answers = [];

    public function btnClick()
    {
        dd("ABC");
    }

    public function render()
    {
        return view('livewire.quiz');
    }

}
