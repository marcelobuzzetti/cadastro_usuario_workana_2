<?php

namespace App\Http\Controllers;

use App\Mail\Ativacao;
use App\Mail\FaltaDeAcesso;
use App\Models\Cadastro;
use App\Models\Config;
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
            $cadastros = $cadastro->with(['Registro'])->whereNull("zenitelic_id")->get();
            return view('cadastro.index', compact('cadastros'))->with([
                "title" => "Cadastros Onlines Não Ativados"
            ]);
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
        if($request->cpf){
            $validator = Validator::make($request->all(), [
                'nome_completo' => 'required|max:255',
                'email' => 'required|email|unique:cadastros',
                'telefone' => 'required|numeric|unique:cadastros',
                'has_corretora' => 'required|boolean',
                'nome_corretora' => 'required|max:255',
                'nr_conta_corretora' => 'required|numeric|digits_between:1,20',
                'use_metatrader' => 'required|boolean',
                'has_auth_use_metatrader' => 'required|boolean',
                'mercado' => 'required|between:1,4',
                'cpf' => 'required|numeric',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'nome_completo' => 'required|max:255',
                'email' => 'required|email|unique:cadastros',
                'telefone' => 'required|numeric|unique:cadastros',
                'has_corretora' => 'required|boolean',
                'nome_corretora' => 'required|max:255',
                'nr_conta_corretora' => 'required|numeric|digits_between:1,20',
                'use_metatrader' => 'required|boolean',
                'has_auth_use_metatrader' => 'required|boolean',
                'mercado' => 'required|between:1,4',
            ]);
        }

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ]);
        }

        switch ($request->mercado) {
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

        try {
            $cadastro = Cadastro::create($request->all());
        } catch (Exception $e) {
            return response()->json(['error' => json_encode($e->getMessage())]);
        }

        $job = (new \App\Jobs\CadastroOnlineQueue("Cadastro na Radar Zenite", $request->email, $cadastro, $request->nome_completo))
            ->delay(now()->addSeconds(2));

        dispatch($job);

        $mensagem = Config::latest()->first();

        $job = (new \App\Jobs\NovoCadastroQueue("Novo Cadastro na Radar Zenite", $mensagem->email, $cadastro, $request->nome_completo))
            ->delay(now()->addSeconds(2));

        dispatch($job);

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
        if (!$request->ajax()) {
            return view('cadastros.index');
        }

        $email = $request->email;
        $assunto = $request->assunto;
        $mensagem = $request->mensagem ? $request->mensagem : 'Você não acessou';
        Mail::to($email)->send(new FaltaDeAcesso($mensagem, $assunto));

        if (count(Mail::failures()) > 0) {
            $error = [];
            foreach (Mail::failures() as $email_address) {
                $error[] = $email_address;
            }
            return response()->json(['error' => json_encode($error)]);
        } else {

            return response()->json(['success' => "Email enviado com sucesso!!!"]);
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
        if (Auth::check() && Auth::user()->perfil_id === 1) {
            $ipAddress = $request->ip();

            $request->validate([
                'Nome' => 'required',
                'CPF' => 'required',
                'Login' => 'required',
                'Data_limite' => 'required',
                'Email' => 'required',
                'Telefone' => 'required',
            ]);

            $Nome = $request->old('Nome');
            $CPF = $request->old('CPF');
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
            $mensagem = Config::latest()->first();
            $mensagem->corpo_email = str_replace("[nome]", $registro->Nome , $mensagem->corpo_email);
            $mensagem->corpo_email = str_replace("[login]", $registro->Login , $mensagem->corpo_email);
            $mensagem->corpo_email = str_replace("[cpf]", $registro->CPF , $mensagem->corpo_email);
            $mensagem->corpo_email = str_replace("[data_inicial]",date('d/m/Y - H:i:s', strtotime($registro->Data_inicial)), $mensagem->corpo_email);
            $mensagem->corpo_email = str_replace("[data_limite]",date('d/m/Y - H:i:s', strtotime($registro->Data_limite)), $mensagem->corpo_email);
            $mensagem->corpo_email = str_replace("[data_ult_ent]",date('d/m/Y - H:i:s', strtotime($registro->Data_ult_ent)), $mensagem->corpo_email);

            $job = (new \App\Jobs\AtivacaoQueue("Ativação de Conta", $request->Email, $registro, $request->nome_completo, $mensagem->corpo_email))
                ->delay(now()->addSeconds(2));

            dispatch($job);


            return redirect()->route('cadastros.index')
                ->with('success', 'Cadastro criado com sucesso.');
        } else {
            return view('cadastro.create');
        }
    }

    public function teste()
    {
        $registro = Registro::first();
        /* dd($registro->Login); */
        $mensagem = Config::latest()->first();
        $mensagem->corpo_email = str_replace("[nome]", $registro->Nome , $mensagem->corpo_email);
        $mensagem->corpo_email = str_replace("[login]", $registro->Login , $mensagem->corpo_email);
        $mensagem->corpo_email = str_replace("[cpf]", $registro->CPF , $mensagem->corpo_email);
        $mensagem->corpo_email = str_replace("[data_inicial]",date('d/m/Y - H:i:s', strtotime($registro->Data_inicial)), $mensagem->corpo_email);
        $mensagem->corpo_email = str_replace("[data_limite]",date('d/m/Y - H:i:s', strtotime($registro->Data_limite)), $mensagem->corpo_email);
        $mensagem->corpo_email = str_replace("[data_ult_ent]",date('d/m/Y - H:i:s', strtotime($registro->Data_ult_ent)), $mensagem->corpo_email);
        $mensagem->corpo_email .= "<a href=". route('cadastros.zenitlic', 1) .">Teste</a>";

        try {
            Mail::to($mensagem->email, "Marcelo")->send(new Ativacao($mensagem->corpo_email, "Teste"));
        } catch (Exception $e) {
            dd($e->getMessage());
        }
        echo "enviado";

        exit();

        $data = date('d/m/Y - H:i:s', strtotime($registro->Data_limite));
        $login = $registro->Login;
        $link = "https://mafs.website";

        $mensagem = "
        Liberamos acesso a conta [login] \n
        Acesso liberado até [data]. Poderemos renovar automaticamente. \n
        Uma vez logado no MT5 com sua conta (com dados de login e senha fornecidos pela corretora) siga o manual do Radar que consta no link abaixo. \n
        Qualquer dúvida nos avise. \n
        Link para download do manual e arquivo de instalação. \n
        Muitos relatos que a instalação .EXE tem acionado o antivírus. Então subimos também uma .RAR. Basta copiar esse .RAR no local indicado no manual e selecionar o \n arquivo com botão direito e mandar extrair aqui. Seguir o manual. Há vídeos (links) no manual. Há explicação das telas na parte final do manual. \n
        Uma vez instalado, o uso das telas está explicado no manual. Tendo dúvidas pode nos perguntar. \n
        [link]\n
        Seguimos à disposição para dúvidas etc.\n
        Att.\n
        Radar Zênite.";

        $mensagem = str_replace("[login]",$login, $mensagem);
        $mensagem = str_replace("[data]",$data, $mensagem);
        $mensagem = str_replace("[link]",$link, $mensagem);
        $config = Config::first()->get();
        /* dd($config); */

        try {
            Mail::to($config->first()->email, "Marcelo")->send(new FaltaDeAcesso($mensagem, "Teste"));
        } catch (Exception $e) {
            dd($e->getMessage());
        }
        echo "enviado";
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ativos()
    {
        if (Auth::check() && Auth::user()->perfil_id === 1) {
            /* $cadastro = new Cadastro();
            $cadastros = $cadastro->with(['Registro'])->get(); */
            $cadastro = new Cadastro();
            $cadastros = $cadastro->with(['Registro'])->whereNotNull("zenitelic_id")->get();
            return view('cadastro.index', compact('cadastros'))->with([
                "title" => "Cadastros Onlines Ativados"
            ]);
        } else {
            return view('cadastro.create');
        }
    }

}
