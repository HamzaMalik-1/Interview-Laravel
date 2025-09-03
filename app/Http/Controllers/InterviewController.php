<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Interview;
use Illuminate\Support\Facades\Validator;
class InterviewController extends Controller
{
    public function getAllOrPagination(Request $request)
    {
        $page = $request->get('page', 1);
        $limit = $request->get('limit'); // no default
        $order = $request->get('order', 'desc');

        $difficultyLevel = $request->get('difficultyLevel');
        $categoryId = $request->get('category_id');

        $query = Interview::query();

        // Apply filters
        if ($difficultyLevel) {
            $query->where('difficulty_level', $difficultyLevel);
        }

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        // Apply ordering
        $query->orderBy('id', $order);

        // Check if limit is provided
        if ($limit) {
            // Use pagination
            $interviews = $query->paginate($limit, ['*'], 'page', $page);
        } else {
            // Return all records if limit is not provided
            $interviews = $query->get();
        }

        return response()->json($interviews);
    }

    public function addInterview(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'question' => 'required',
            'answer' => 'required',
            'difficultyLevel' => 'required|in:easy,medium,hard',
            'categoryId' => 'required|integer',
        ], [
            'question.required' => 'Question is required',
            'answer.required' => 'Answer is required',
            'difficultyLevel.required' => 'Difficulty level is required',
            'difficultyLevel.in' => 'Difficulty level must be easy, medium, or hard',
            'categoryId.required' => 'Category ID is required',
            'categoryId.integer' => 'Category ID must be a number',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => true,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }


        $interview = Interview::create($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Interview created successfully',
            'data' => $interview
        ], 201);

        // echo $validator;


    }

    public function deleteInterview($id)
    {
        // Check if ID is provided (Laravel ensures it's present in the route)
        if (!$id) {
            return response()->json([
                'success' => false,
                'message' => 'ID is required'
            ], 422);
        }

        $interview = Interview::find($id);

        if (!$interview) {
            return response()->json([
                'success' => false,
                'message' => 'Interview not found'
            ], 404);
        }

        $interview->delete();

        return response()->json([
            'success' => true,
            'message' => 'Interview deleted successfully'
        ], 200);
    }

   public function editInterview(Request $request)
{
    // return response($request->all());
    $validator = Validator::make($request->all(), [
        'id' => 'required|integer',
        'question' => 'required',
        'answer' => 'required',
        'difficultyLevel' => 'required|in:easy,medium,hard',
        'categoryId' => 'required|integer',
    ], [
        'id.required' => 'ID is required',
        'id.integer' => 'ID must be a number',
        'question.required' => 'Question is required',
        'answer.required' => 'Answer is required',
        'difficultyLevel.required' => 'Difficulty level is required',
        'difficultyLevel.in' => 'Difficulty level must be easy, medium, or hard',
        'categoryId.required' => 'Category ID is required',
        'categoryId.integer' => 'Category ID must be a number',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => 'Validation failed',
            'errors' => $validator->errors()
        ], 422);
    }

    // Find the interview
    $interview = Interview::find($request->id);

    if (!$interview) {
        return response()->json([
            'success' => false,
            'message' => 'Interview not found'
        ], 404);
    }

    // Update the record
    $interview->update([
        'question' => $request->question,
        'answer' => $request->answer,
        'difficulty_level' => $request->difficultyLevel,
        'category_id' => $request->categoryId,
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Interview updated successfully',
        'data' => $interview
    ]);
}


}
