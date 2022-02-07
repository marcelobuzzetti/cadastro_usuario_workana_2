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
use Carbon\Carbon;

class RegistroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->perfil_id === 1) {
            $registros = Registro::all();
        }

        if (Auth::user()->perfil_id === 2) {

            $registros = DB::select('SELECT * FROM zenitelic, users
            WHERE users.email = zenitelic.Origem_registro
            AND users.email =  ?', [Auth::user()->email]);
        }

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
            'Data_limite' => 'required',
            'Email' => 'required',
            'Telefone' => 'required',
        ]);

        $CPF = $request->old('CPF');
        $Nome = $request->old('Nome');
        $Login = $request->old('Login');
        $Data_limite = $request->old('Data_limite');
        $Data_ult_ent = $request->old('Data_ult_ent');
        $Cod_admin = $request->old('Cod_admin');
        $Email = $request->old('Email');
        $Telefone = $request->old('Telefone');

        $request->merge([
            'Contador' => $ipAddress,
            'Data_inicial' => now(),
            'Origem_registro' => Auth::user()->email
        ]);

        Registro::create($request->all() /* + ['IP' => $ipAddress] + ['usuario' => Auth::id()] */);

        return redirect()->route('registros.index')
            ->with('success', 'Registro criado com sucesso.');
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
        return view('registros.show', compact('registro'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Registro  $registro
     * @return \Illuminate\Http\Response
     */
    public function edit(Registro $registro)
    {
        return view('registros.edit', compact('registro'));
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
            'Data_limite' => 'required',
            'Email' => 'required',
            'Telefone' => 'required',
        ]);

        $registro->update($request->all() /* + ['IP' => $ipAddress] */);

        return redirect()->route('registros.index')
            ->with('success', 'Registro atualizado com sucesso');
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
            ->with('success', 'Registro apagado com sucesso');
    }
}
