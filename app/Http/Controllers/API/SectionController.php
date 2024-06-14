<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Cookie;


class SectionController extends Controller
{
    /**
     * Section Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function create_section(Request $request): JsonResponse
    {
        $randomString = '';
        for ($i = 0; $i < 4; $i++) {
            // Generate a random ASCII value for uppercase letters (65 to 90)
            $randomAscii = rand(65, 90);
            // Convert the ASCII value to a character and append it to the string
            $randomString .= chr($randomAscii);
        }

        $validator = Validator::make($request->all(), [
            'admin_id' => 'required',
            'section_name' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        // Find the admin by admin_id
        $admin = User::find($request->admin_id);
        if (!$admin) {
            return $this->sendError('Admin not found.');
        }

        // Create the section
        $input = $request->all();
        $input['pin_password'] = date("YmdHis") . $randomString;
        $section = Section::create($input);

        // Prepare success response
        $success['admin_name'] = $admin->name; // Include admin's name in the response
        $success['admin_id'] = $section->admin_id;
        $success['task_ids_created'][] = $section->task_id;
        $success['section_name'] = $section->section_name;
        $success['pin_password'] = $input['pin_password']; // Include the pin_password in the response
        $success['section_created'] = $section->created_at;

        return response()->json(['success!' => $success], 201);
    }

    // Define the sendError method to handle error responses
    protected function sendError($message, $errors = [], $code = 404)
    {
        $response = [
            'message' => $message,
        ];

        if (!empty($errors)) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $code);
    }

    public function section_all(): JsonResponse
    {
        $section = Section::all();
        if (!$section)
        {
            return response()->json(['message' => 'No Section Found'], 404);
        }

        return response()->json($section, 200);
    }

    public function delete_section($section_id): JsonResponse
    {
        $section = Section::find($section_id);
        if (!$section)
        {
            return response()->json(['message' => 'Section not found'], 404);
        }
        $section->delete();
        return response()->json(['message' => 'Section deleted successfully'], 200);
    }

    public function section_id($section_id)
    {
        $sections = Section::where('admin_id', $section_id)->get();
        return response()->json($sections);
    }


// START VIEW ONLY SECTION


    // Start View Only Login
    public function login_section(Request $request): JsonResponse
        {
            // Validate the request
            $validator = Validator::make($request->all(), [
                'pin_password' => 'required|string',
            ]);

            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());
            }

            // Find the section by pin_password
            $section = Section::where('pin_password', $request->pin_password)->first();

            if ($section) {
                // Retrieve the admin's ID associated with the section
                $adminId = $section->admin_id;

                // Find the admin by admin ID
                $admin = User::where('admin_id', $adminId)->first();

                // Authentication successful, set section data in a cookie
                $sectionData = [
                    'section_id' => $section->section_id,
                    'section_name' => $section->section_name,
                ];
                $cookie = Cookie::forever('section_data', json_encode($sectionData)); // Store indefinitely

                // Return success response including admin's details
                return response()->json([
                    'sectionName' => $section->section_name,
                    'sectionID' => $section->section_id,
                    'adminID' => $section->admin_id,
                    'adminName' => $admin ? $admin->name : 'Not Found',
                ])->withCookie($cookie);
            } else {
                // Authentication failed
                return response()->json(['error' => 'Invalid Section Credentials'], 401);
            }
        }


    // End View Only Login

    // Start Leave Section View Only
    public function leave_section(): JsonResponse
    {
        // Delete the section data cookie
        $cookie = Cookie::forget('section_data');

        // Return a response indicating success
        return response()->json(['message' => 'Left the section successfully'])->withCookie($cookie);
    }
    // End Leave Section View Only


// END VIEW ONLY SECTION
}
