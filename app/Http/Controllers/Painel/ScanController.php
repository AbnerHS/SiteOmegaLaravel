<?php

namespace App\Http\Controllers\Painel;

use App\Http\Controllers\Controller;
use App\Models\Scan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        if(!Scan::where('nomeScan','=',$request->nomeScan)->exists()){
            if($request->logo->isValid()){
                $imagePath = $request->logo->store('scans');
                $data['logo'] = $imagePath;
                Auth::user()->scan()->create($data);
            } else {
                return redirect()->back('erro','Imagem inválida!');
            }
            return redirect()->route('scans.show','home');
        } else {
            return redirect()->back()->with('erro','Já existe uma Scan com esse nome!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        if($scan = Auth::user()->scan){
            return view("painel.scan.edit",compact('scan'));
        } else {
            return view("painel.scan.create");
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->except(["_token","_method","action"]);        
        if($request->hasFile('logo')){
            $imagePath = $request->logo->store('scans');
            $data['logo'] = $imagePath;
        }
        try { Auth::user()->scan()->update($data); } catch(Exception $e){
            return redirect()->back()->with('erro','Já existe uma Scan com esse nome!');
        }
        return redirect()->route('scans.show','home');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
