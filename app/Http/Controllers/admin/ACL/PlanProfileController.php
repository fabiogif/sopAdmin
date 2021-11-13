<?php

namespace App\Http\Controllers\Admin\ACL;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Profile;
use Illuminate\Http\Request;

class PlanProfileController extends Controller
{
    protected $repository, $plan, $profile;

    public function __construct(Plan $plan, Profile $profile)
    {
        $this->plan = $plan;
        $this->profile = $profile;
        $this->middleware(['can:plans']);
    }



    public function profiles($idPlan)
    {
        $plan = $this->plan->find($idPlan);

        if (!$plan) {
            return redirect()->back();
        }
        $profiles = $plan->profiles()->paginate();

        return view('admin.pages.plans.profiles.profiles', compact('plan', 'profiles'));
    }

    public function plans($idProfile)
    {
        $profile = $this->profile->find($idProfile);

        if (!$profile) {
            return redirect()->back();
        }
        $plans = $profile->plans()->paginate();

        return view('admin.pages.profile.plans.plans', compact('plans', 'profile'));
    }

    public function profilesAvailable(Request $request, $idPlan)
    {

        $plan = $this->plan->find($idPlan);

        if (!$plan) {
            return redirect()->back();
        }

        $filters = $request->except('_token');

        $profiles = $plan->profilesAvailable($request->filter);

        return view('admin.pages.plans.profiles.available', compact('plan', 'profiles', 'filters'));
    }

    public function attachProfilesPlan(Request $request, $idPlan)
    {
        $plan = $this->plan->find($idPlan);

        if (!$plan) {
            return redirect()->back();
        }

        if (!$request->profiles || count($request->profiles) == 0) {
            return redirect()->back()->with('messageWarning', 'Precisa escolher pelo menos uma permissão');
        }

        $plan->profiles()->attach($request->profiles);

        return redirect()->route('plans.profiles', $plan->id)->with('messageSuccess', 'Vinculado com sucesso');
    }

    public function detachProfilePlan($idPlan, $idProfile)
    {
        $plan = $this->plan->find($idPlan);
        $profile = $this->profile->find($idProfile);

        if (!$plan || !$profile) {
            return redirect()->back()->with('messageDanger', 'Não encontrado');
        }

        $plan->profiles()->detach($profile);
        return redirect()->route('plans.profiles', $plan->id)->with('messageSuccess', 'Desvinculado com sucesso');
    }
}
