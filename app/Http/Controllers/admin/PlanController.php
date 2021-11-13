<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdatePlan;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PlanController extends Controller
{
    private $repository;

    public function __construct(Plan $plan)
    {
        $this->repository = $plan;
        $this->middleware(['can:plans']);
    }

    public function index()
    {
        $plans = $this->repository->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.pages.plans.index', ['plans' => $plans]);
    }

    public function create()
    {
        return view('admin.pages.plans.create');
    }

    public function store(StoreUpdatePlan $request)
    {
        $this->repository->create($request->all());
        return redirect()->route('plans.index');
    }

    public function show($id)
    {
        $plan = $this->repository->where('id', $id)->first();

        if (!$plan) {
            return redirect()->back();
        }

        return  view('admin.pages.plans.show', ['plan' => $plan]);
    }

    public function destroy($id)
    {
        $plan = $this->repository->with('details')->where('id', $id)->first();

        if (!$plan) {
            return redirect()->back();
        }

        if ($plan->details()->count() > 0) {
            return redirect()->back()->with('messageDanger', 'Não possui excluir o Plano, existem detalhes cadastrados');
        }

        $plan->delete();

        return  redirect()->route('plans.index');
    }


    public function search(Request $request)
    {
        $filters = $request->all();
        $plans = $this->repository->search($request->filter);

        return view(
            'admin.pages.plans.index',
            [
                'plans' => $plans,
                'filters' => $filters
            ]
        );
    }

    public function edit($id)
    {
        $plan = $this->repository->where('id', $id)->first();

        if (!$plan) {
            return redirect()->back();
        }
        return view(
            'admin.pages.plans.edit',
            ['plan' => $plan]
        );
    }

    public function update(StoreUpdatePlan $request, $id)
    {
        $plan = $this->repository->where('id', $id)->first();

        if (!$plan) {
            return redirect()->back();
        }
        $plan->update($request->all());
        return  redirect()->route('plans.index');
    }
}
