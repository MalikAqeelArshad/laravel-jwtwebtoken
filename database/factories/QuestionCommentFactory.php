<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Question;
use App\Models\QuestionComment;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionCommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = QuestionComment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'    => User::all()->random()->id,
            'question_id'=> Question::all()->random()->id,
            'message'    => $this->faker->paragraph,
            'read_at'    => $this->faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now'),
        ];
    }//end definition()

}//end class
