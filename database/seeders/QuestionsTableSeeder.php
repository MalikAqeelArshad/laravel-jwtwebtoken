<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Question;
use App\Models\QuestionComment;
use Illuminate\Database\Seeder;

class QuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$faker = \Faker\Factory::create();
    	
    	Question::factory(rand(5, 10))->create()
    	->each(function ($question) use ($faker) {
    		$question->comments()->create(
    			[
    				// 'question_id'=> $question->id,
    				'user_id' 	 => $question->user_id,
    				'message'    => $faker->paragraph,
    				'read_at'    => $faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now'),
    			]
    		);
    	});
    }
}
