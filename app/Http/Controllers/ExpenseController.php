<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExpenseController extends Controller
{
    public function __construct()
    {
        $this->middleware('hasPortal:expenses');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expenses = Expense::with(['teacher'])->get();

        return response([
            'hasPortal' => true,
            'expenses' => $expenses
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
        $request->request->add([
            'created_by' => Auth::user()->id,
        ]);
        $validated = $request->validate([
            'name' => 'required_without:teacher_id|string',
            'teacher_id' => 'required_without:name|numeric|exists:teachers,id',
            'amount' => 'required|numeric',
            'notes' => 'nullable|size:255',
            'created_by' => 'required|numeric|exists:users,id',
        ]);
        $expense = Expense::create($validated);

        return response([
            'hasPortal' => true,
            'expense' => $expense
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
        $expense = Expense::with(['teacher'])->find($id);

        return response([
            'hasPortal' => true,
            'expense' => $expense
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
        $expense = Expense::find($id);
        $request->request->add([
            'updated_by' => Auth::user()->id,
        ]);
        $validated = $request->validate([
            'name' => 'required_without:teacher_id|string',
            'teacher_id' => 'required_without:name|numeric|exists:teachers,id',
            'amount' => 'required|numeric',
            'notes' => 'nullable|size:255',
            'updated_by' => 'required|numeric|exists:users,id',
        ]);
        $expense->update($validated);

        return response([
            'hasPortal' => true,
            'expense' => $expense
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
            Expense::where('id', $id)->update([
                'deleted_by' => Auth::user()->id,
            ]);
            Expense::destroy($id);

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
