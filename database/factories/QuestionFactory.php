<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Question::class;


    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            // 'user_id'    => User::first()->id,
            'user_id'    => User::whereRole('customer')->get()->random()->id,
            'title'      => $this->faker->sentence,
            'spam'       => (bool) $this->faker->boolean(),
            'status'     => (int) rand(1, 3),
        ];

    }//end definition()


}//end class
