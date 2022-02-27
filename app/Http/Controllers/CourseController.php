<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseLevel;
use App\Models\CoursePlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('hasPortal:courses');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = Course::with(['teacher', 'levels'])->get();

        return response([
            'hasPortal' => true,
            'courses' => $courses
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
            'name' => 'required|unique:courses,name',
            'teacher_id' => 'required|numeric|exists:teachers,id',
            'level_id' => 'required|array',
            'level_id.*' => 'required|numeric|exists:levels,id',
            'plan_id' => 'required|array',
            'plan_id.*' => 'required|numeric|exists:plans,id',
        ]);

        DB::beginTransaction();
        try {
            $course = Course::create([
                'name' => $request->name,
                'teacher_id' => $request->teacher_id,
                'created_by' => Auth::user()->id,
            ]);

            foreach ($request->level_id as $level) {
                CourseLevel::create([
                    'course_id' => $course->id,
                    'level_id' => $level,
                    'created_by' => Auth::user()->id,
                ]);
            }

            foreach ($request->plan_id as $plan) {
                CoursePlan::create([
                    'course_id' => $course->id,
                    'plan_id' => $plan,
                    'created_by' => Auth::user()->id,
                ]);
            }
            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
        }

        return response([
            'hasPortal' => true,
            'course' => $this->show($course->id)
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
        $course = Course::with(['teacher', 'levels', 'plans', 'createdBy', 'updatedBy'])->find($id);

        return response([
            'hasPortal' => true,
            'course' => $course
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
            'name' => 'required|unique:courses,name,' . $id,
            'teacher_id' => 'required|numeric|exists:teachers,id',
            'level_id' => 'required|array',
            'level_id.*' => 'required|numeric|exists:levels,id',
            'plan_id' => 'required|array',
            'plan_id.*' => 'required|numeric|exists:plans,id',
        ]);

        DB::beginTransaction();
        try {
            Course::where('id', $id)->update([
                'name' => $request->name,
                'teacher_id' => $request->teacher_id,
                'updated_by' => Auth::user()->id,
            ]);

            foreach ($request->level_id as $level) {
                CourseLevel::where('course_id', $id)->update([
                    'course_id' => $id,
                    'level_id' => $level,
                    'updated_by' => Auth::user()->id,
                ]);
            }

            foreach ($request->plan_id as $plan) {
                CoursePlan::where('course_id', $id)->update([
                    'course_id' => $id,
                    'plan_id' => $plan,
                    'updated_by' => Auth::user()->id,
                ]);
            }
            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
        }

        return response([
            'hasPortal' => true,
            'course' => $this->show($id)
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
            Course::where('id', $id)->update([
                'deleted_by' => Auth::user()->id,
            ]);
            CourseLevel::where('course_id', $id)->update([
                'deleted_by' => Auth::user()->id,
            ]);
            CoursePlan::where('course_id', $id)->update([
                'deleted_by' => Auth::user()->id,
            ]);
            Course::destroy($id);
            CourseLevel::where('course_id', $id)->delete();
            CoursePlan::where('course_id', $id)->delete();
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
