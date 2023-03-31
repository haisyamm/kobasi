<?php

namespace App\Http\Controllers;
use App\Models\Positions;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function index()
    {   
        $title = "Data Position";
        $positions = Positions::orderBy('id','asc')->paginate(5);
        return view('positions.index', compact(['positions' , 'title']));
    }

    public function create()
    {
        $title = "Tambah Data Position";
        return view('positions.create', compact('title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'keterangan',
            'alias',
        ]);
        
        Positions::create($request->post());

        return redirect()->route('positions.index')->with('success','Position has been created successfully.');
    }

    public function show(Positions $position)
    {
        return view('positions.show',compact('position'));
    }

    public function edit(Positions $position)
    {
        return view('positions.edit',compact('position'));
    }

    public function update(Request $request, Positions $position)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'address' => 'required',
        ]);
        
        $company->fill($request->post())->save();

        return redirect()->route('positions.index')->with('success','Company Has Been updated successfully');
    }

    public function destroy(Positions $position)
    {
        $company->delete();
        return redirect()->route('positions.index')->with('success','Company has been deleted successfully');
    }

}
