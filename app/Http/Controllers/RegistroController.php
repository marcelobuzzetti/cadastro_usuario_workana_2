<?php

namespace App\Http\Controllers;

use App\Models\Registro;
use App\Http\Requests\StoreRegistroRequest;
use App\Http\Requests\UpdateRegistroRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;

class RegistroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $registros = Registro::all();
        /* dd($registros); */

        /* $registros = DB::table('registros')
        ->leftJoin('users', 'users.id', '=', 'usuario')
        ->select(['CPF', 'ID_usuario', 'Nome', 'Login', 'Data_Inicial', 'Data_limite', 'Data_ult_ent', 'Contador', 'Origem_registro', 'Cod_Admin', 'registros.Email', 'Telefone', 'IP', 'users.name'])
        ->get(); */

        return view('registros.index')->with('registros', $registros);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('registros.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRegistroRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ipAddress = $request->ip();

        $request->validate([
            'CPF' => 'required',
            'Nome' => 'required',
            'Login' => 'required',
            'Data_inicial' => 'required',
            'Data_limite' => 'required',
            'Origem_registro' => 'required',
            'Email' => 'required',
            'Telefone' => 'required',
        ]);

        $CPF = $request->old('CPF');
        $Nome = $request->old('Nome');
        $Login = $request->old('Login');
        $Data_inicial = $request->old('Data_inicial');
        $Data_limite = $request->old('Data_limite');
        $Origem_registro = $request->old('Origem_registro');
        $Email = $request->old('Email');
        $Telefone = $request->old('Telefone');

        $request->merge([
            'Contador' => $ipAddress
        ]);

        Registro::create($request->all() /* + ['IP' => $ipAddress] + ['usuario' => Auth::id()] */);

        return redirect()->route('registros.index')
                        ->with('success','Registro criado com sucesso.');
       /*  } */
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Registro  $registro
     * @return \Illuminate\Http\Response
     */
    public function show(Registro $registro)
    {
        return view('registros.show',compact('registro'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Registro  $registro
     * @return \Illuminate\Http\Response
     */
    public function edit(Registro $registro)
    {
        return view('registros.edit',compact('registro'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRegistroRequest  $request
     * @param  \App\Models\Registro  $registro
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Registro $registro)
    {
        $ipAddress = $request->ip();

        $request->validate([
            'CPF' => 'required',
            'Nome' => 'required',
            'Login' => 'required',
            'Data_Inicial' => 'required',
            'Data_limite' => 'required',
            'Origem_registro' => 'required',
            'Email' => 'required',
            'Telefone' => 'required',
        ]);

        $registro->update($request->all() /* + ['IP' => $ipAddress] */);

        return redirect()->route('registros.index')
                        ->with('success','Registro atualizado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Registro  $registro
     * @return \Illuminate\Http\Response
     */
    public function destroy(Registro $registro)
    {
        $registro->delete();

        return redirect()->route('registros.index')
                        ->with('success','Registro apagado com sucesso');
    }
}
