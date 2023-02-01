<?php

namespace App\Http\Controllers;

use App\Mail\FaltaDeAcesso;
use App\Models\Cadastro;
use App\Models\Registro;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
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

        if (Auth::check() && Auth::user()->perfil_id === 1) {
            $cadastro = new Cadastro();
            $cadastros = $cadastro->with(['Registro'])->get();
            return view('cadastro.index', compact('cadastros'));
        } else {
            return view('cadastro.create');
        }
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
            'nome_completo' => 'required|max:255',
            'email' => 'required|email|unique:cadastros',
            'telefone' => 'required|numeric|unique:cadastros',
            'cpf' => 'required|cpf|unique:cadastros|max:11',
            'has_corretora' => 'required|boolean',
            'nome_corretora' => 'required|max:255',
            'nr_conta_corretora' => 'required|numeric|max:255',
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

        /* $dados = Array(
            'CPF' => $request->cpf,
            'Nome' => $request->nome_completo,
            'Login' => $request->nr_conta_corretora,
            'Origem_registro' => "Web",
            'Email' => $request->email,
            'Telefone' => $request->telefone,
        );

        $zenite = new Registro();

        try {
            $id = $zenite::create($dados);
            $request->merge([
                'zenitelic_id' => $id
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => json_encode($e->getMessage())]);
        } */



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

    public function email(Request $request)
    {
        if (! $request->ajax()) {
            return view('cadastros.index');
        }

        $email = $request->email;
        $assunto = $request->assunto;
        $mensagem = $request->mensagem ? $request->mensagem : 'Você não acessou';
        Mail::to($email)->send(new FaltaDeAcesso($mensagem, $assunto));

        if( count(Mail::failures()) > 0 ) {
            $error = [];
            foreach(Mail::failures() as $email_address) {
                $error[] = $email_address;
             }
            return response()->json(['error'=>json_encode($error)]);

         } else {

            return response()->json(['success'=>"Email enviado com sucesso!!!"]);
         }

    }

    public function zenitlic($id)
    {
        if (Auth::check() && Auth::user()->perfil_id === 1) {
            $cadastro = Cadastro::findOrFail($id);
            return view('cadastro.zenitlic', compact('cadastro'));
        } else {
            return view('cadastro.create');
        }
    }

    public function cadastrozenitelic(Request $request)
    {
        if(Auth::check() && Auth::user()->perfil_id === 1) {
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

            $registro = Registro::create($request->all());
            Cadastro::where('id', $request->id)->update([
                'zenitelic_id' => $registro->ID_usuario
            ]);

            return redirect()->route('cadastros.index')
                ->with('success', 'Cadastro criado com sucesso.');
        } else {
            return view('cadastro.create');
        }
    }
}
