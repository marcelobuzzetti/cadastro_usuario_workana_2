<?php

namespace App\Http\Controllers;

use App\Mail\Ativacao;
use App\Models\Cadastro;
use App\Models\Config;
use App\Models\Registro;
use App\Http\Requests\StoreRegistroRequest;
use App\Http\Requests\UpdateRegistroRequest;
use App\Mail\FaltaDeAcesso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class RegistroController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if(Auth::user()->status === 2) return redirect()->route('inativo');
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $registros = NULL;
        if (Auth::user()->perfil_id === 1) {
            $registros = Registro::all();
        }

        if (Auth::user()->perfil_id === 2) {

            $registros = DB::select('SELECT * FROM ZeniteLic, users
            WHERE users.email = ZeniteLic.Origem_registro
            AND users.email =  ?', [Auth::user()->email]);
        }

        if (Auth::user()->perfil_id === 3) {

            $emails = DB::select('SELECT email FROM users WHERE usuario_criador_id = ?', [Auth::id()]);

            $registros = DB::select("SELECT DISTINCT ID_usuario, CPF, Nome, Login, Data_inicial, Data_limite, Data_ult_ent, Contador, Origem_registro, Cod_admin, Email, Telefone FROM ZeniteLic
            WHERE ZeniteLic.Origem_registro IN (SELECT email FROM users WHERE usuario_criador_id = ? OR ZeniteLic.Origem_registro = ?)"
            , [Auth::id(), Auth::user()->email]);
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

        $registro = Registro::create($request->all() /* + ['IP' => $ipAddress] + ['usuario' => Auth::id()] */);

        $mensagem = Config::latest()->first();
        $mensagem->corpo_email = str_replace("[nome]", $registro->Nome , $mensagem->corpo_email);
        $mensagem->corpo_email = str_replace("[login]", $registro->Login , $mensagem->corpo_email);
        $mensagem->corpo_email = str_replace("[cpf]", $registro->CPF , $mensagem->corpo_email);
        $mensagem->corpo_email = str_replace("[data_inicial]",date('d/m/Y - H:i:s', strtotime($registro->Data_inicial)), $mensagem->corpo_email);
        $mensagem->corpo_email = str_replace("[data_limite]",date('d/m/Y - H:i:s', strtotime($registro->Data_limite)), $mensagem->corpo_email);
        $mensagem->corpo_email = str_replace("[data_ult_ent]",date('d/m/Y - H:i:s', strtotime($registro->Data_ult_ent)), $mensagem->corpo_email);

        Mail::to($request->Email, $request->Nome)->cc($mensagem->email)->send(new Ativacao($mensagem->corpo_email, "Ativação de Conta"));

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

        $criador_usuario = DB::select("SELECT criador.id FROM users, users AS criador
            WHERE users.usuario_criador_id = criador.id
            AND users.email = ?", [$registro->Origem_registro]);
        $criador = DB::select("SELECT usuario_criador_id FROM users
        WHERE users.email = ?", [$registro->Origem_registro]);

        if (Auth::user()->email === $registro->Origem_registro || Auth::user()->perfil_id === 1 || $criador[0]->usuario_criador_id === $criador_usuario[0]->id) {
            return view('registros.show', compact('registro'));
        } else {
            return redirect()->route('registros.index')
                ->with('error', 'Você não tem permissão para ver este registro.');
        }
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

        $criador_usuario = DB::select("SELECT criador.id FROM users, users AS criador
            WHERE users.usuario_criador_id = criador.id
            AND users.email = ?", [$registro->Origem_registro]);
        $criador = DB::select("SELECT usuario_criador_id FROM users
        WHERE users.email = ?", [$registro->Origem_registro]);

        if (Auth::user()->email === $registro->Origem_registro || Auth::user()->perfil_id === 1 || $criador[0]->usuario_criador_id === $criador_usuario[0]->id) {
            $registro->update($request->all());
        } else {
            return redirect()->route('registros.index')
                ->with('error', 'Você não tem permissão para editar este registro.');
        }

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
        $logs = DB::select("SELECT count(ID_usuario) AS count FROM Log
            WHERE ID_usuario = ?", [$registro->ID_usuario]);

        if($logs[0]->count > 0) {
            return redirect()->route('registros.index')
            ->with('error', 'Este registro possui logs, não é possível excluí-lo.');
         }

        $criador_usuario = DB::select("SELECT criador.id FROM users, users AS criador
            WHERE users.usuario_criador_id = criador.id
            AND users.email = ?", [$registro->Origem_registro]);
        $criador = DB::select("SELECT usuario_criador_id FROM users
        WHERE users.email = ?", [$registro->Origem_registro]);

        if (Auth::user()->email === $registro->Origem_registro || Auth::user()->perfil_id === 1 || $criador[0]->usuario_criador_id === $criador_usuario[0]->id) {
            $registro->delete();
            $cadastro = Cadastro::where('zenitelic_id', '=', $registro->ID_usuario)->first();
            if($cadastro){
                $cadastro->delete();
            }
        } else {
            return redirect()->route('registros.index')
                ->with('error', 'Você não tem permissão para deletar este registro.');
        }

        return redirect()->route('registros.index')
            ->with('success', 'Registro apagado com sucesso');
    }

    /*public function acessos()
    {
        $acessos = NULL;
        $acessos = Registro::whereNotNull('Data_ult_ent')->get(['ID_usuario','Nome','Email']);
        return view('registros.acessos')->with('acessos', $acessos);
    }*/

    public function email(Request $request)
    {
        if (! $request->ajax()) {
            return view('registros.index');
        }

        $registro = Registro::findOrFail($request->id);
        $email = $registro->Email;
        $nome = $registro->Nome;
        $assunto = $request->assunto;
        $mensagem = $request->mensagem ? $request->mensagem : 'Você não acessou';
        Mail::to($email, $nome)->send(new FaltaDeAcesso($mensagem, $assunto));

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
}
