<?php

namespace App\Http\Controllers;

use App\Models\Cadastro;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

        $validator = Validator::make($request->all(), [
            'nome_completo' => 'required',
            'email' => 'required|email',
            'telefone' => 'required',
            'cpf' => 'required|cpf',
            'has_corretora' => 'required|boolean',
            'use_metatrader' => 'required|boolean',
            'has_auth_use_metatrader' => 'required|boolean',
            'mercado' => 'required|between:1,4',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ]);
        }

        switch($request->mercado){
            case 1:
                $request->merge([
                    'mercado' => "Nacional",
                ]);
                break;
            case 2:
                $request->merge([
                    'mercado' => "Internacional",
                ]);
                break;
            case 3:
                $request->merge([
                    'mercado' => "Ambos, mas Nacional por enquanto",
                ]);
                break;
            case 4:
                $request->merge([
                    'mercado' => "Ambos, mas apenas Internacional, quando possível",
                ]);
                break;
        }


        $mensagem = nl2br("Você se cadastrou na Radar Zenite
        \nDados Cadastrados:
        Nome Completo: $request->nome_completo \n
        Email: $request->email \n
        Telefone: $request->telefone \n
        Tem Corretora?". ($request->has_corretora ? "Sim" : "Não") .
        "Nome da Corretora: $request->nome_corretora
        Nr da Corretora: $request->nr_conta_corretora
        \nUsa o Metatrader 5? ". ($request->use_metatrader ? "Sim" : "Não") .
        "\nEstá com autorização da corretora para rotear pelo METATRADER 5? ". ($request->has_auth_use_metatrader ? "Sim" : "Não") .
        "\nTem interesse em qual mercado para o RADAR? ". $request->mercado);

        $job = (new \App\Jobs\CadastroOnlineQueue("Cadastro na Radar Zenite", $request->email, $mensagem, $request->nome_completo))
        ->delay(now()->addSeconds(2));

        dispatch($job);

        try {
            Cadastro::create($request->all());
        } catch (Exception $e) {
            return response()->json(['error' => json_encode($e->getMessage())]);
        }

        return response()->json(['success' => "Cadastro realizado com sucesso!!!"]);
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
