<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Question;
use App\Models\QuestionComment;
use Illuminate\Database\Seeder;

class QuestionCommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$faker = \Faker\Factory::create();
    	// QuestionComment::factory(rand(1, 10))->create();

    	Question::each(function ($question) use ($faker) {
    		$question->comments()->create(
    			[
    				// 'question_id' => $question->id,
    				'user_id' => User::whereRole('support')->get()->random()->id,
    				'message' => $faker->paragraph,
    				'read_at' => $faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now'),
    			]
    		);
    	});
    }
}
