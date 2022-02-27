<?php

namespace App\Http\Controllers;

use App\Models\CoursePlan;
use App\Models\Enrolment;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EnrolmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('hasPortal:enrolments');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $enrolments = Enrolment::with(['student', 'course', 'classroom', 'plan', 'teacher'])->get();

        return response([
            'hasPortal' => true,
            'enrolments' => $enrolments
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|numeric|exists:students,id',
            'course_id' => 'required|numeric|exists:courses,id',
            'classroom_id' => 'required|numeric|exists:classrooms,id',
            'plan_id' => 'required|numeric|exists:plans,id',
        ]);

        $required_amount = CoursePlan::where('course_id', $request->course_id)
            ->where('plan_id', $request->plan_id)->first()->price;

        $enrolment = Enrolment::create([
            'student_id' => $request->student_id,
            'course_id' => $request->course_id,
            'classroom_id' => $request->classroom_id,
            'plan_id' => $request->plan_id,
            'required_amount' => $required_amount,
            'created_by' => Auth::user()->id,
        ]);

        return response([
            'hasPortal' => true,
            'enrolment' => $this->show($enrolment->id)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $enrolment = Enrolment::with(['student', 'course', 'classroom', 'plan', 'teacher', 'createdBy', 'updatedBy'])->find($id);

        return response([
            'hasPortal' => true,
            'enrolment' => $enrolment
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'classroom_id' => 'required|numeric|exists:classrooms,id',
            'plan_id' => 'required|numeric|exists:plans,id',
        ]);

        $required_amount = CoursePlan::where('course_id', $request->course_id)
            ->where('plan_id', $request->plan_id)
            ->first()->price;

        Enrolment::where('id', $id)->update([
            'classroom_id' => $request->classroom_id,
            'plan_id' => $request->plan_id,
            'required_amount' => $required_amount,
            'updated_by' => Auth::user()->id,
        ]);

        return response([
            'hasPortal' => true,
            'enrolment' => $this->show($id)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            Enrolment::where('id', $id)->update([
                'deleted_by' => Auth::user()->id,
            ]);
            Subscription::where('enrolment_id', $id)->update([
                'deleted_by' => Auth::user()->id,
            ]);

            Subscription::where('enrolment_id', $id)->delete();
            Enrolment::destroy($id);

            DB::commit();
            return response([
                'hasPortal' => true,
                'message' => 'record has been deleted'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response([
                'hasPortal' => true,
                'message' => 'Error: delete operation is failed'
            ]);
        }
    }
}
