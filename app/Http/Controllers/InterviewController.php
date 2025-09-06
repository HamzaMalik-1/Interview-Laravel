<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Interview;
use Illuminate\Support\Facades\Validator;

class InterviewController extends Controller
{
    public function getAllOrPagination(Request $request)
    {
        try {
            $page = $request->get('page', 1);
            $limit = $request->get('limit'); // no default
            $order = $request->get('order', 'desc');

            $difficultyLevel = $request->get('difficultyLevel');
            $categoryId = $request->get('categoryId');

            $query = Interview::query();

            // Use correct column names (camelCase)
            if ($difficultyLevel) {
                $query->where('difficultyLevel', $difficultyLevel);
            }

            if ($categoryId) {
                $query->where('categoryId', $categoryId);
            }

            $query->orderBy('id', $order);

            if ($limit) {
                $interviews = $query->paginate($limit, ['*'], 'page', $page);
            } else {
                $interviews = $query->get();
            }

            return response()->json([
                'success' => true,
                'data' => $interviews
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function addInterview(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'question' => 'required',
                'answer' => 'required',
                'difficultyLevel' => 'required|in:easy,medium,hard',
                'categoryId' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $interview = Interview::create([
                'question' => $request->question,
                'answer' => $request->answer,
                'difficultyLevel' => $request->difficultyLevel, // use camelCase
                'categoryId' => $request->categoryId,           // use camelCase
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Interview created successfully',
                'data' => $interview
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteInterview($id)
    {
        try {
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
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function editInterview(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer',
                'question' => 'required',
                'answer' => 'required',
                'difficultyLevel' => 'required|in:easy,medium,hard',
                'categoryId' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $interview = Interview::find($request->id);

            if (!$interview) {
                return response()->json([
                    'success' => false,
                    'message' => 'Interview not found'
                ], 404);
            }

            $interview->update([
                'question' => $request->question,
                'answer' => $request->answer,
                'difficultyLevel' => $request->difficultyLevel, // camelCase
                'categoryId' => $request->categoryId,           // camelCase
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Interview updated successfully',
                'data' => $interview
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
