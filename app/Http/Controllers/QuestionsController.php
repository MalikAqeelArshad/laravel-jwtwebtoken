<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Models\QuestionComment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class QuestionsController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->middleware('auth.jwt');
        $this->user = $this->guard()->user();
        $this->authorizeResource(Question::class, null, [
            'except' => ['viewAny']
        ]);

    }//end __construct()


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return response()->json(Question::allByRole()->with('user')->get()->toArray(), 200);

        return response()->json(
            Question::allByRole()->with('user')
            ->whereLike(request('name'))
            ->status(request('status'))
            ->get()->toArray(), 200);

    }//end index()


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'title'  => 'required|string',
                'status' => 'required|between:1,3',
                // 'spam'   => 'required|boolean',
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => false,
                    'errors' => $validator->errors(),
                ],
                400
            );
        }

        $question         = new Question();
        $question->title  = $request->title;
        $question->status = $request->status;
        $question->spam   = $request->spam ?? false;

        if ($this->user->questions()->save($question)) {
            return response()->json(
                [
                    'status'   => true,
                    'question' => $question,
                ]
            );
        } else {
            return response()->json(
                [
                    'status'  => false,
                    'message' => 'Oops, the question could not be saved.',
                ]
            );
        }

    }//end store()


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Question $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        return response()->json(
            [
                'status'   => true,
                'question' => $question,
            ]
        );

    }//end show()


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Question     $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        $validator = Validator::make(
            $request->all(),
            [
                // 'title'  => 'required|string',
                'status' => 'required|between:1,3',
                // 'spam'   => 'required|boolean',
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => false,
                    'errors' => $validator->errors(),
                ],
                400
            );
        }

        $question->title  = $request->title ?? $question->title;
        $question->status = $request->status ?? $question->status;
        $question->spam   = $request->spam ?? $question->spam;

        if ($question->update()) {
            return response()->json(
                [
                    'status'    => true,
                    'question'  => $question,
                ]
            );
        } else {
            return response()->json(
                [
                    'status'  => false,
                    'message' => 'Oops, the question could not be updated.',
                ]
            );
        }

    }//end update()


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Question $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        if ($question->delete()) {
            return response()->json(
                [
                    'status'   => true,
                    'question' => $question,
                ]
            );
        } else {
            return response()->json(
                [
                    'status'  => false,
                    'message' => 'Oops, the question could not be deleted.',
                ]
            );
        }

    }//end destroy()


    /**
     * Comment a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function comment(Request $request, Question $question)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'message' => 'required|string',
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => false,
                    'errors' => $validator->errors(),
                ],
                400
            );
        }

        $comment         = new QuestionComment();
        $comment->message  = $request->message;
        $comment->question_id  = $question->id;

        if ($this->user->comments()->save($comment)) {
            return response()->json(
                [
                    'status'   => true,
                    'message' => 'Comment has been added successfully.',
                ]
            );
        } else {
            return response()->json(
                [
                    'status'  => false,
                    'message' => 'Oops, the question could not be saved.',
                ]
            );
        }

    }//end comment()


    protected function guard()
    {
        return Auth::guard();

    }//end guard()


}//end class
