<?php

namespace App\Observers;

use App\Models\Plan;
use Illuminate\Support\Str;

class PlanObserver
{
    /**
     * Handle the Plan "created" event.
     *
     * @param  \App\Models\Models\Plan  $plan
     * @return void
     */
    public function created(Plan $plan)
    {
        //
    }

    /**
     * Handle the Plan "updated" event.
     *
     * @param  \App\Models\Models\Plan  $plan
     * @return void
     */
    public function updated(Plan $plan)
    {
        //
    }

    /**
     * Handle the Plan "deleted" event.
     *
     * @param  \App\Models\Models\Plan  $plan
     * @return void
     */
    public function deleted(Plan $plan)
    {
        //
    }

    /**
     * Handle the Plan "creating" event.
     *
     * @param  \App\Models\Models\Plan  $plan
     * @return void
     */
    public function creating(Plan $plan)
    {
        $plan->url = Str::kebab($plan->name);
    }

    /**
     * Handle the Plan "updating" event.
     *
     * @param  \App\Models\Models\Plan  $plan
     * @return void
     */
    public function updating(Plan $plan)
    {
        $plan->url = Str::kebab($plan->name);
    }
}
