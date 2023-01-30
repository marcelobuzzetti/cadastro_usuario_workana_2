<?php

namespace App\Http\Controllers;

use App\Models\Cadastro;
use Exception;
use Illuminate\Http\Request;

class CadastroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cadastros = Cadastro::all();
        return view('cadastro.index', compact('cadastros'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cadastro.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'nome_completo' => 'required',
            'email' => 'required|email',
            'telefone' => 'required',
            'has_corretora' => 'required',
            /* 'nome_corretora' => 'required|exists:marcas,id', */
            /* 'nr_conta_corretora' => 'required|exists:status,id', */
            'use_metatrader' => 'required',
            'has_auth_use_metatrader' => 'required',
            'mercado' => 'required',
        ]);

        $nome_completo = $request->old('nome_complet0');
        $email = $request->old('email');
        $telefone = $request->old('telefone');
        $has_corretora = $request->old('has_corretora');
        $nome_corretora = $request->old('nome_corretora');
        $nr_conta_corretora = $request->old('nr_conta_corretora');
        $use_metatrader = $request->old('use_metatrader');
        $has_auth_use_metatrader = $request->old('has_auth_use_metatrader');
        $mercado = $request->old('mercado');

        try {
            $cadastro = Cadastro::create($request->all());
            $cadastroId = $cadastro->id;
            $message = [
                "type" => "success",
                "message" => "Cadastro nº $cadastroId foi criado com sucesso!!!."
            ];
        } catch (Exception $e) {
            $message = [
                "type" => "error",
                "message" => $e->getMessage()
            ];
        }

        return redirect()->route('cadastros.create')
                        ->with('message', $message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
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
