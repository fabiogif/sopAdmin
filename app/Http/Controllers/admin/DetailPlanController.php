<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DetailPlan;
use App\Models\Plan;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUpdateDetailPlan;

class DetailPlanController extends Controller
{
    protected $repository, $plan;


    public function __construct(DetailPlan $detailPlan, Plan $plan)
    {
        $this->repository = $detailPlan;
        $this->plan = $plan;
        $this->middleware(['can:plans']);
    }
    public function create($idPlan)
    {
        $plan = $this->plan->where('id', $idPlan)->first();

        if (!$plan) {
            return redirect()->back();
        }

        return view('admin.pages.plans.details.create', ['plan' => $plan]);
    }

    public function store(StoreUpdateDetailPlan $request, $idPlan)
    {
        $plan = $this->plan->where('id', $idPlan)->first();

        if (!$plan) {
            return redirect()->back();
        }
        $plan->details()->create($request->all());

        return redirect()->route('details.plans.index', $plan->id)->with('messageSuccess', 'Adicionado com sucesso');
    }


    public function index($idPlan)
    {
        $plan = $this->plan->where('id', $idPlan)->first();

        if (!$plan) {
            return redirect()->back();
        }

        $details = $plan->details()->paginate();

        return view('admin.pages.plans.details.index', [
            'plan' => $plan,
            'details' => $details
        ]);
    }


    public function edit($idPlan, $idDetails)
    {
        $plan = $this->plan->where('id', $idPlan)->first();
        $details = $this->repository->find($idDetails);

        if (!$plan || !$details) {
            return redirect()->back();
        }

        return view('admin.pages.plans.details.edit', ['plan' => $plan, 'details' => $details]);
    }


    public function update(StoreUpdateDetailPlan $request, $idPlan, $idDetails)
    {
        $plan = $this->plan->where('id', $idPlan)->first();
        $details = $this->repository->find($idDetails);

        if (!$plan || !$details) {
            return redirect()->back();
        }

        $details->update($request->all());

        return redirect()->route('details.plans.index', $plan->id)->with('messageSuccess', 'Alterado com sucesso');
    }

    public function show($idPlan, $idDetails)
    {
        $plan = $this->plan->where('id', $idPlan)->first();
        $details = $this->repository->find($idDetails);

        if (!$plan || !$details) {
            return redirect()->back();
        }

        return view('admin.pages.plans.details.show', ['plan' => $plan, 'details' => $details]);
    }

    public function destroy($idPlan, $idDetails)
    {
        $plan = $this->plan->where('id', $idPlan)->first();
        $details = $this->repository->find($idDetails);

        if (!$plan || !$details) {
            return redirect()->back();
        }
        $details->delete();

        return redirect()->route('details.plans.index', $plan->id)->with('messageDanger', 'Excluido com sucesso');
    }
}
