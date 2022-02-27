<?php

namespace App\Http\Controllers;

use App\Models\Enrolment;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SubscriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('hasPortal:subscriptions');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /**
         * $subscriptions = Enrolment::with(['student', 'course', 'classroom', 'plan', 'teacher', 'subscriptions'])->get();
         * return response([
         * 'hasPortal' => true,
         * 'subscriptions' => $subscriptions
         * ]);
         **/
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
            'enrolment_id' => 'required|numeric|exists:enrolments,id',
            'paid_amount' => 'required|numeric',
        ]);

        DB::beginTransaction();
        try {
            $subscription = Subscription::create([
                'enrolment_id' => $request->enrolment_id,
                'paid_amount' => $request->paid_amount,
                'created_by' => Auth::user()->id,
            ]);

            Enrolment::where('enrolment_id', $request->enrolment_id)
                ->increment('total_paid_amount', $request->paid_amount);

            DB::commit();
            $subscription = $this->show($subscription->id);

            return response([
                'hasPortal' => true,
                'subscription' => $subscription
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response([
                'hasPortal' => true,
                'message' => 'Error: operation is failed'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        /**
         * $subscription = Subscription::find($id);
         * return response([
         * 'hasPortal' => true,
         * 'subscription' => $subscription
         * ]);
         **/
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
        //
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
            $subscription = Subscription::where('id', $id)->update([
                'deleted_by' => Auth::user()->id,
            ]);
            Enrolment::where('enrolment_id', $subscription->enrolment_id)
                ->decrement('total_paid_amount', $subscription->paid_amount);

            Subscription::destroy($id);

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
