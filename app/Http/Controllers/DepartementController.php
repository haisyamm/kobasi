<?php

namespace App\Http\Controllers;
use App\Models\Departements;
use App\Models\User;
use Illuminate\Http\Request;

class DepartementController extends Controller
{
    public function index()
    {   
        $title = "Data Departement";
        $departements = Departements::orderBy('id','asc')->paginate(5);
        return view('departements.index', compact(['departements' , 'title']));
    }

    public function create()
    {
        $title = "Tambah Data Departement";
        $managers = User::where('position', '1')->orderBy('id','asc')->get();
        return view('departements.create', compact('title', 'managers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'keterangan',
            'alias',
        ]);
        
        Departements::create($request->post());

        return redirect()->route('departements.index')->with('success','Departement has been created successfully.');
    }

    public function show(Departements $departement)
    {
        return view('departements.show',compact('Departement'));
    }

    public function edit(Departements $departement)
    {
        $title = "Edit Data Departement";
        $managers = User::where('position', '1')->orderBy('id','asc')->get();
        return view('departements.edit',compact('departement' , 'title', 'managers'));
    }

    public function update(Request $request, Departements $departement)
    {
        $request->validate([
            'name' => 'required',
            'location' => 'required',
            'manager_id' => 'required',
        ]);
        
        $departement->fill($request->post())->save();

        return redirect()->route('departements.index')->with('success','Departement Has Been updated successfully');
    }

    public function destroy(Departements $position)
    {
        $position->delete();
        return redirect()->route('departements.index')->with('success','Departement has been deleted successfully');
    }

}