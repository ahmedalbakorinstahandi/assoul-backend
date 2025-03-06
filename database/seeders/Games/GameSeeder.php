<?php

namespace Database\Seeders\Games;

use App\Models\Games\Answer;
use App\Models\Games\Game;
use App\Models\Games\Level;
use Illuminate\Database\Seeder;
use App\Models\Games\Question;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $games = [
            ['name' => 'يلا نختار الصح', 'image' => 'games/game_1.jpg', 'color' => '#FCAC19'],
            ['name' => 'بطل الأنسولين', 'image' => 'games/game_2.jpg', 'color' => '#0072A1'],
            ['name' => 'محطم السكر', 'image' => 'games/game_3.jpg', 'color' => '#C3205F'],
        ];

        foreach ($games as $index => $gameData) {
            $game = Game::create(array_merge($gameData, ['is_enable' => true, 'order' => $index + 1]));

            for ($levelNumber = 1; $levelNumber <= 3; $levelNumber++) {
                $level = Level::create([
                    'title' => "المستوى $levelNumber",
                    'number' => $levelNumber,
                    'status' => 'published',
                    'game_id' => $game->id,
                ]);

                $questions = $this->getQuestionsForGame($game->name, $levelNumber);
                foreach ($questions as $q) {
                    $questionData = $q;
                    unset($questionData['answers']);
                    $question = Question::create(array_merge($questionData, ['level_id' => $level->id]));
                    foreach ($q['answers'] as $answer) {
                        Answer::create(array_merge($answer, ['question_id' => $question->id]));
                    }
                }
            }
        }
    }

    private function getQuestionsForGame(string $gameName, int $levelNumber): array
    {
        $data = [
            'يلا نختار الصح' => [
                [
                    'text' => 'ما هو أكبر كوكب في المجموعة الشمسية؟',
                    'image' => 'questions/q1.jpg',
                    'points' => 10,
                    'type' => 'MCQ',
                    'answers_view' => 'text',
                    'answers' => [
                        ['text' => 'زحل', 'is_correct' => false],
                        ['text' => 'الأرض', 'is_correct' => false],
                        ['text' => 'المشتري', 'is_correct' => true],
                        ['text' => 'المريخ', 'is_correct' => false],
                    ]
                ],
                [
                    'text' => 'كم عدد ألوان قوس قزح؟',
                    'image' => 'questions/q2.jpg',
                    'points' => 10,
                    'type' => 'MCQ',
                    'answers_view' => 'image',
                    'answers' => [
                        ['image' => 'answers/a2_1.jpg', 'is_correct' => false],
                        ['image' => 'answers/a2_2.jpg', 'is_correct' => false],
                        ['image' => 'answers/a2_3.jpg', 'is_correct' => true],
                        ['image' => 'answers/a2_4.jpg', 'is_correct' => false],
                    ]
                ],
                [
                    'text' => 'رتب الحروف التالية لتكوين كلمة "كوكب"',
                    'image' => 'questions/q3.jpg',
                    'points' => 10,
                    'type' => 'LetterArrangement',
                    'answers_view' => 'text',
                    'answers' => [
                        ['text' => 'كوكب', 'is_correct' => true],
                    ]
                ],
                [
                    'text' => 'اسحب الصورة الصحيحة لتتناسب مع تعريف "المجرة"',
                    'image' => 'questions/q4.jpg',
                    'points' => 10,
                    'type' => 'DragDrop',
                    'answers_view' => 'text',
                    'answers' => [
                        ['image' => 'answers/a4_1.jpg', 'is_correct' => false],
                        ['image' => 'answers/a4_2.jpg', 'is_correct' => true],
                    ]
                ]
            ],
            'بطل الأنسولين' => [
                [
                    'text' => 'ما هو العضو المسؤول عن إنتاج الأنسولين في الجسم؟',
                    'image' => 'questions/q5.jpg',
                    'points' => 10,
                    'type' => 'MCQ',
                    'answers_view' => 'text',
                    'answers' => [
                        ['text' => 'الكبد', 'is_correct' => false],
                        ['text' => 'البنكرياس', 'is_correct' => true],
                        ['text' => 'القلب', 'is_correct' => false],
                        ['text' => 'الكلى', 'is_correct' => false],
                    ]
                ],
                [
                    'text' => 'قم بترتيب الحروف لتكوين كلمة مفيدة',
                    'image' => 'questions/q6.jpg',
                    'points' => 10,
                    'type' => 'LetterArrangement',
                    'answers_view' => 'text',
                    'answers' => [
                        ['text' => 'أنسولين', 'is_correct' => true],
                    ]
                ],
                [
                    'text' => 'اسحب الصورة التي تمثل حقنة الأنسولين',
                    'image' => 'questions/q7.jpg',
                    'points' => 10,
                    'type' => 'DragDrop',
                    'answers_view' => 'text',
                    'answers' => [
                        ['image' => 'answers/a7_1.jpg', 'is_correct' => true],
                        ['image' => 'answers/a7_2.jpg', 'is_correct' => false],
                    ]
                ]
            ],
            'محطم السكر' => [
                [
                    'text' => 'ما هو المصدر الرئيسي للطاقة في الجسم؟',
                    'image' => 'questions/q8.jpg',
                    'points' => 10,
                    'type' => 'MCQ',
                    'answers_view' => 'text',
                    'answers' => [
                        ['text' => 'البروتين', 'is_correct' => false],
                        ['text' => 'الجلوكوز (السكر)', 'is_correct' => true],
                        ['text' => 'الدهون', 'is_correct' => false],
                        ['text' => 'الماء', 'is_correct' => false],
                    ]
                ],
                [
                    'text' => 'رتب الحروف لتكوين كلمة "سكر"',
                    'image' => 'questions/q9.jpg',
                    'points' => 10,
                    'type' => 'LetterArrangement',
                    'answers_view' => 'text',
                    'answers' => [
                        ['text' => 'سكر', 'is_correct' => true],
                    ]
                ],
                [
                    'text' => 'اسحب الصورة التي تمثل مشروبًا يحتوي على نسبة سكر مرتفعة',
                    'image' => 'questions/q10.jpg',
                    'points' => 10,
                    'type' => 'DragDrop',
                    'answers_view' => 'text',
                    'answers' => [
                        ['image' => 'answers/a10_1.jpg', 'is_correct' => true],
                        ['image' => 'answers/a10_2.jpg', 'is_correct' => false],
                    ]
                ]
            ]
        ];

        return $data[$gameName] ?? [];
    }
}
