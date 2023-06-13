<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\RAB;
use App\Models\RABDetail;
use Illuminate\Http\Request;

class RABController extends Controller
{
    public function index()
    {   
        $title = "Data RAB";
        $rabs = RAB::orderBy('id','asc')->paginate(5);
        return view('rabs.index', compact(['rabs' , 'title']));
    }

    public function create()
    {
        $title = "Tambah Data RAB";
        $managers = User::where('position', '1')->orderBy('id','asc')->get();
        return view('rabs.create', compact('title', 'managers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_trx' => 'required'
        ]);

        $rab = [
            'no_trx' => $request->no_trx,
            'penyusun' => $request->penyusun,
            'tgl_rab' => $request->tgl_rab,
            'total' => $request->total,
        ];
        if($result = RAB::create($rab)){
            for ($i=1; $i <= $request->jml; $i++) { 
                $details = [
                    'no_trx' => $request->no_trx,
                    'id_product' => $request['id_product'.$i],
                    'price' => $request['price'.$i],
                    'qty' => $request['qty'.$i],
                    'sub_total' => $request['sub_total'.$i],
                ];
                RABDetail::create($details);
            }
            
        }
        return redirect()->route('positions.index')->with('success','Position has been created successfully.');
    }

    public function show(RAB $rab)
    {
        return view('rabs.show',compact('Departement'));
    }

    public function edit(RAB $rab)
    {
        $title = "Edit Data RAB";
        $managers = User::where('position', '1')->orderBy('id','asc')->get();
        $detail = RABDetail::where('no_trx', $rab->no_trx)->orderBy('id','asc')->get();
        return view('rabs.edit',compact('rab' , 'title', 'managers', 'detail'));
    }

    public function update(Request $request, RAB $rab)
    {
        $rabs = [
            'no_trx' => $rab->no_trx,
            'penyusun' => $request->penyusun,
            'tgl_rab' => $request->tgl_rab,
            'total' => $request->total,
        ];
        if($rab->fill($rabs)->save()){
            RABDetail::where('no_trx', $rab->no_trx)->delete();
            for ($i=1; $i <= $request->jml; $i++) { 
                $details = [
                    'no_trx' => $rab->no_trx,
                    'id_product' => $request['productId'.$i],
                    'product_name' => $request['productName'.$i],
                    'price' => $request['price'.$i],
                    'qty' => $request['qty'.$i],
                    'sub_total' => $request['sub_total'.$i],
                ];
                RABDetail::create($details);
            }
        }           

        return redirect()->route('rabs.index')->with('success','Departement Has Been updated successfully');
    }

    public function destroy(RAB $rab)
    {
        $rab->delete();
        return redirect()->route('rabs.index')->with('success','Departement has been deleted successfully');
    }

}
