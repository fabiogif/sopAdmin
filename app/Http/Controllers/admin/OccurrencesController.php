<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateOccurrences;
use App\Models\Occurrences;
use Illuminate\Http\Request;

class OccurrencesController extends Controller
{
    protected $repository;

    public function __construct(Occurrences $occurrences)
    {
        $this->repository = $occurrences;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $occurrences = $this->repository->paginate();
        return view('admin.pages.occurrences.index', compact('occurrences'));
    }

    public function create()
    {
        return view('admin.pages.occurrences.create');
    }

    public function store(StoreUpdateOccurrences $request)
    {

        $this->repository->create($request->all());


        return redirect()->route('occurrences.index');
    }

    public function show($id)
    {
        $occurrences = $this->repository->where('id', $id)->first();

        if (!$occurrences) {
            return redirect()->back();
        }

        return  view('admin.pages.occurrences.show', ['occurrences' => $occurrences]);
    }

    public function destroy($id)
    {
        $occurrences = $this->repository->where('id', $id)->first();

        if (!$occurrences) {
            return redirect()->back();
        }
        $occurrences->delete();

        return  redirect()->route('occurrences.index')->with('messageSuccess', 'Excluido com sucesso');
    }


    public function search(Request $request)
    {

        $filters = $request->all();

        $occurrences = $this->repository->search($request->filter);

        return view(
            'admin.pages.occurrences.index',
            [
                'occurrences' => $occurrences,
                'filters' => $filters
            ]
        );
    }

    public function edit($id)
    {
        $occurrences = $this->repository->where('id', $id)->first();

        if (!$occurrences) {
            return redirect()->back();
        }
        return view(
            'admin.pages.occurrences.edit',
            ['occurrences' => $occurrences]
        );
    }

    public function update(StoreUpdateOccurrences $request, $id)
    {
        $occurrences = $this->repository->where('id', $id)->first();

        if (!$occurrences) {
            return redirect()->back();
        }
        $occurrences->update($request->all());
        return  redirect()->route('occurrences.index');
    }
}
