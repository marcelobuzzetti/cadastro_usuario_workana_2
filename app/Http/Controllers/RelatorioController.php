<?php

namespace App\Http\Controllers;

use App\Models\Registro;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use IntlDateFormatter;

class RelatorioController extends Controller
{
    public function index()
    {
        return view('relatorio.index');
    }

    public function search(Request $request)
    {
        if (!$request->start_date && !$request->end_date) {

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

                $registros = DB::select(
                    "SELECT DISTINCT ID_usuario, CPF, Nome, Login, Data_inicial, Data_limite, Data_ult_ent, Contador, Origem_registro, Cod_admin, Email, Telefone FROM ZeniteLic
            WHERE ZeniteLic.Origem_registro IN (SELECT email FROM users WHERE usuario_criador_id = ? OR ZeniteLic.Origem_registro = ?)",
                    [Auth::id(), Auth::user()->email]
                );
            }

            return view('relatorio.relatorio')->with([
                'registros' => $registros
            ]);

        }

        $request->validate([
            'start_date' => 'required|date|before:tomorrow',
        ]);

        if ($request->end_date) {

            $request->validate([
                'end_date'   => 'required|date|after:start_date',
            ]);

            $fim = new IntlDateFormatter(null, null, null, null, null, 'dd/MM/yyyy');
            $dataFim = $fim->format(new DateTime($request->end_date));

            if (Auth::user()->perfil_id === 1) {
                $registros = Registro::whereBetween('Data_ult_ent', [$request->start_date, $request->end_date])->get();
            }

            if (Auth::user()->perfil_id === 2) {
                $registros = DB::select('SELECT * FROM ZeniteLic, users
                WHERE users.email = ZeniteLic.Origem_registro
                AND users.email =  ?
                AND Data_ult_ent BETWEEN ? AND ?', [Auth::user()->email, $request->start_date, $request->end_date]);
            }

            if (Auth::user()->perfil_id === 3) {
                $emails = DB::select('SELECT email FROM users WHERE usuario_criador_id = ?', [Auth::id()]);

                $registros = DB::select("SELECT DISTINCT ID_usuario, CPF, Nome, Login, Data_inicial, Data_limite, Data_ult_ent, Contador, Origem_registro, Cod_admin, Email, Telefone FROM ZeniteLic
                WHERE ZeniteLic.Origem_registro IN (SELECT email FROM users WHERE usuario_criador_id = ? OR ZeniteLic.Origem_registro = ?)
                AND Data_ult_ent BETWEEN ? AND ?", [Auth::id(), Auth::user()->email, $request->start_date, $request->end_date]);
            }

        } else {

            if (Auth::user()->perfil_id === 1) {
                $registros = Registro::where('Data_ult_ent', ">=", $request->start_date)->get();
            }

            if (Auth::user()->perfil_id === 2) {
                $registros = DB::select('SELECT * FROM ZeniteLic, users
                WHERE users.email = ZeniteLic.Origem_registro
                AND users.email =  ?
                AND Data_ult_ent >= ?', [Auth::user()->email, $request->start_date]);
            }

            if (Auth::user()->perfil_id === 3) {
                $emails = DB::select('SELECT email FROM users WHERE usuario_criador_id = ?', [Auth::id()]);

                $registros = DB::select("SELECT DISTINCT ID_usuario, CPF, Nome, Login, Data_inicial, Data_limite, Data_ult_ent, Contador, Origem_registro, Cod_admin, Email, Telefone FROM ZeniteLic
                WHERE ZeniteLic.Origem_registro IN (SELECT email FROM users WHERE usuario_criador_id = ? OR ZeniteLic.Origem_registro = ?)
                AND Data_ult_ent >= ?", [Auth::id(), Auth::user()->email, $request->start_date]);
            }
        }

        $start_date = $request->old('start_date');
        $end_date = $request->old('end_date');

        $inicio = new IntlDateFormatter(null, null, null, null, null, 'dd/MM/yyyy');
        $dataInicio = $inicio->format(new DateTime($request->start_date));

        $atual = new IntlDateFormatter(null, null, null, null, null, 'dd/MM/yyyy');
        $dataAtual = $atual->format(new DateTime());
        return view('relatorio.relatorio')->with([
            'registros' => $registros,
            'dataInicio' => $dataInicio,
            'dataFim' => isset($dataFim) ? $dataFim : $dataAtual,
        ]);
    }
}
