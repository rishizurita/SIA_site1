<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserJob;

use Illuminate\Http\Response;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use DB;

class UserController extends Controller
{
    private $request;

    public function __construct(Request $request){
        $this->request = $request;
    }

    /* Helper method to return a successful JSON response */
    protected function successResponse($data, $code = Response::HTTP_OK){
        return response()->json(['data' => $data], $code);
    }

    /* Helper method to return an error JSON response */
    protected function errorResponse($message, $code){
        return response()->json(['error' => $message, 'code' => $code], $code);
    }

    /* Return the list of users */
    public function index(){
        $users = User::all();
        return $this->successResponse($users);
    }

    /* Get all users */
    public function getUsers(){
        $users = User::all();
        return $this->successResponse($users);
    }

    /*Add a new user*/
    public function add(Request $request)
{
    // Validation rules for the request
    $rules = [
        'username' => 'required|max:20',
        'password' => 'required|max:20',
        'gender' => 'required|in:Male,Female',
        'jobid' => 'nullable|numeric|min:1|exists:tbluserjob,jobid',  // Allow jobid to be nullable and check if it exists
    ];

    // Validate incoming request data
    $this->validate($request, $rules);

    // If jobid is provided, check if it exists in tbluserjob
    if ($request->has('jobid')) {
        $userjob = UserJob::find($request->jobid);
        if (!$userjob) {
            return $this->errorResponse('Job ID does not exist in the job table', Response::HTTP_NOT_FOUND);
        }
    }

    // Create the user record
    $user = User::create([
        'username' => $request->username,
        'password' => $request->password,
        'gender' => $request->gender,
        'jobid' => $request->jobid,  // Include jobid if provided
    ]);

    // Return a successful response
    return $this->successResponse($user, Response::HTTP_CREATED);
}


    /*Show details of a single user*/
    public function show($id){
        $user = User::find($id);

        if (!$user) {
            return $this->errorResponse('User ID does not exist', Response::HTTP_NOT_FOUND);
        }

        return $this->successResponse($user);
    }

    /*Update an existing user*/
    public function update(Request $request, $id){
        $rules = [
            'username' => 'max:20',
            'password' => 'max:20',
            'gender' => 'in:Male,Female',
            'jobid' => 'required|numeric|min:1|not_in:0',
        ];

        $this->validate($request, $rules);
        $userjob = UserJob::findOrFail($request->jobid);
        $user = User::findOrFail($id);

        $user->fill($request->all());

        if (!$user) {
            return $this->errorResponse('User ID does not exist', Response::HTTP_NOT_FOUND);
        }

        $user->fill($request->all());

        if ($user->isClean()) {
            return $this->errorResponse('At least one value must change', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user->save();
        return $this->successResponse($user);
    }

    /* Delete a user */
    public function delete($id)
    {
        $user = User::find($id);

        if (!$user) {
            return $this->errorResponse('User ID does not exist', Response::HTTP_NOT_FOUND);
        }

        $user->delete();
        return $this->successResponse(['message' => 'User deleted successfully']);
    }
}