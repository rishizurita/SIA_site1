<?php
namespace App\Http\Controllers;

use App\Models\UserJob;
use Illuminate\Http\Response;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class UserJobController extends Controller
{
    // Use ApiResponser trait for standardized API responses
    use ApiResponser;

    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Return the list of user jobs.
     * 
     * @return Illuminate\Http\Response
     */
    public function index()
    {
        $userJobs = UserJob::all();
        return $this->successResponse($userJobs);
    }

    /**
     * Obtains and shows one user job.
     * 
     * @param int $id
     * @return Illuminate\Http\Response
     */
    public function show($id)
    {
        $userJob = UserJob::findOrFail($id); // This will return 404 if not found
        return $this->successResponse($userJob);
    }
}