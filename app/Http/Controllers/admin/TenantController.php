<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateTenant;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TenantController extends Controller
{
    protected $repository;

    public function __construct(Tenant $tenant)
    {
        $this->repository = $tenant;
        $this->middleware(['can:tenants']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tenants = $this->repository->latest()->paginate();
        return view('admin.pages.tenants.index', compact('tenants'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View('admin.pages.tenants.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\StoreUpdateTenant  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdateTenant $request)
    {
        $data = $request->all();

        $this->repository->create($data);

        return redirect()->route('tenants.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tenant = $this->repository->with('plan')->find($id);

        if (!$tenant) {
            return redirect()->back();
        }
        return View('admin.pages.tenants.show', compact('tenant'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tenant = $this->repository->where('id', $id)->first();

        if (!$tenant) {
            return redirect()->back();
        }
        return view(
            'admin.pages.tenants.edit',
            compact('tenant')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\StoreUpdateTenant  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdateTenant $request, $id)
    {
        $tenant = $this->repository->where('id', $id)->first();
        if (!$tenant) {
            return redirect()->back();
        }

        $data = $request->all();

        if ($request->hasFile('logo') && $request->logo->isValid()) {
            if (Storage::exists($tenant->logo)) {
                Storage::delete($tenant->logo);
            }
            $data['logo'] = $request->logo->store("tenant/{$tenant->uuid}tenants");
        }


        $tenant->update($data);

        return  redirect()->route('tenants.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tenant = $this->repository->where('id', $id)->first();

        if (!$tenant) {
            return redirect()->back();
        }

        if ($tenant->logo && Storage::exists($tenant->logo)) {
            Storage::delete($tenant->logo);
        }

        $tenant->delete();

        return  redirect()->route('tenants.index');
    }

    public function search(Request $request)
    {
        $filters = $request->all();
        $tenant = $this->repository->where(function ($query) use ($request) {
            if ($request->filter) {
                $query->orWhere('cnpj', "{$request->filter}");
                $query->orWhere('name', 'LIKE', "%{$request->filter}%");
            }
        })->latest()->paginate();

        return view(
            'admin.pages.tenants.index',
            [
                'tenants' => $tenant,
                'filters' => $filters
            ]
        );
    }
}
