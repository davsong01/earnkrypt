<?php

namespace App\Http\Controllers;

use App\Models\publishing_plans;
use Illuminate\Http\Request;

class PublishingPlansController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $count = 1;
        $plans = publishing_plans::with('users')->get();

        return view('backend.admin.plans.index', compact('count', 'plans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.admin.plans.create');      
    }

    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'title' => 'required|unique:publishing_plans,title',
            'amount' => 'required|numeric',
            'description' => 'required',
            'commission' => 'required|numeric',
            'return' => 'required',
            'daily_returns' => 'required',
            'payment_link' => 'required',
        ]);

        $plan = publishing_plans::create([
            'title' => $data['title'],
            'amount' => $data['amount'],
            'description' => $data['description'],
            'commission' => $data['commission'],
            'validity' => 30,
            'return' => $data['return'],
            'daily_returns' => $data['daily_returns'],
            'payment_link' => $data['payment_link'],

        ]);

        return redirect(route('plans.index'))->with('message', 'Plan has been added');
    }

    public function show(publishing_plans $publishing_plans)
    {
        //
    }

    public function edit(publishing_plans $publishing_plans, $plans)
    {
        $plan = publishing_plans::find($plans);

        return view('backend.admin.plans.update', compact('plan'));
    }

    public function update(Request $request, $plans)
    {
        $plan = publishing_plans::find($plans);

        $plan->update($request->all());

        return back()->with('message', 'Update Succesful');
    }

    public function destroy(Request $request, $plans)
    {
        $plan = publishing_plans::find($plans);
        $count_users = $plan->users->count();

        //Check if plan has users subscribed
        if($count_users > 0){
            return back()->with('error', 'You cannot delete this plan because it has '. $count_users. ' subscribers');
        }
       
        $plan->delete();

        return redirect(route('plans.index'))->with('message', 'Plan has been deleted forever');

    }
}
