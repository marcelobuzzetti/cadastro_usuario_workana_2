<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->perfil_id === 1) {
            $usuarios = DB::table('users')
                ->leftJoin('perfils', 'perfils.id', '=', 'perfil_id')
                ->leftJoin('users as criador', 'criador.id', '=', 'users.usuario_criador_id')
                ->select(['users.id', 'users.name', 'users.email', 'perfils.perfil', 'criador.name as criador'])
                ->where('users.status', '=', 1)
                ->where('users.id', '!=', Auth::id())
                ->get();
        }

        if (Auth::user()->perfil_id === 3) {
            $usuarios = DB::table('users')
                ->leftJoin('perfils', 'perfils.id', '=', 'perfil_id')
                ->leftJoin('users as criador', 'criador.id', '=', 'users.usuario_criador_id')
                ->select(['users.id', 'users.name', 'users.email', 'perfils.perfil', 'criador.name as criador'])
                ->where('users.status', '=', 1)
                ->where('users.id', '!=', Auth::id())
                ->where('users.usuario_criador_id', '=', Auth::id())
                ->get();
        }

        return view('usuarios.index')->with('usuarios', $usuarios);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('usuarios.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::user()->perfil_id === 1) {

            $request->validate(
                [
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                    'password' => ['required', 'confirmed', Password::min(10)->letters()->mixedCase()->numbers()->symbols()],
                    'perfil_id' => ['required', Rule::in([1, 2, 3])]
                ],
                [
                    'name.required' => 'O nome deve ser digitado.',
                    'email.required' => 'O email deve ser digitado.',
                    'password.required' => 'O password deve ser digitado',
                    'perfil_id.required' => 'O perfil deve ser selecionado',
                ]
            );
        }

        if (Auth::user()->perfil_id === 2) {
            return redirect()->route('registros.index')
                ->with('error', 'Você não tem acesso.');
        }

        if (Auth::user()->perfil_id === 3) {

            $request->validate(
                [
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                    'password' => ['required', 'confirmed', Password::min(10)->letters()->mixedCase()->numbers()->symbols()],
                    'perfil_id' => ['required', Rule::in([2, 3])],
                ],
                [
                    'name.required' => 'O nome deve ser digitado.',
                    'email.required' => 'O email deve ser digitado.',
                    'password.required' => 'O password deve ser digitado',
                    'perfil_id.required' => 'O perfil deve ser selecionado',
                ]
            );
        }

        $name = $request->old('name');
        $email = $request->old('email');
        $password = $request->old('password');
        $password_confirmation = $request->old('password_confirmation');
        $perfil_id = $request->old('perfil_id');

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'perfil_id' => $request->perfil_id,
            'status' => 1,
            'usuario_criador_id' => Auth::id(),
        ]);

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario criado com sucesso.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $usuario)
    {
        if (Auth::id() === $usuario->usuario_criador_id || Auth::user()->perfil_id === 1) {
            return view('usuarios.show', compact('usuario'));
        } else {
            return redirect()->route('usuarios.index')
                ->with('error', 'Você não tem permissão para ver este usuário.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $usuario)
    {
        return view('usuarios.edit', compact('usuario'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $usuario)
    {

        if (Auth::user()->perfil_id === 1) {
            if($request->password){
                $request->validate(
                    [
                        'name' => ['required', 'string', 'max:255'],
                        'password' => ['required', 'confirmed', Password::min(10)->letters()->mixedCase()->numbers()->symbols()],
                        'perfil_id' => ['required', Rule::in([1, 2, 3])]
                    ],
                    [
                        'name.required' => 'O nome deve ser digitado',
                        'password.required' => 'O password deve ser digitado',
                        'perfil_id.required' => 'O perfil deve ser selecionado',
                    ]
                );
            } else {
                $request->validate(
                    [
                        'name' => ['required', 'string', 'max:255'],
                        'perfil_id' => ['required', Rule::in([1, 2, 3])]
                    ],
                    [
                        'name.required' => 'O nome deve ser digitado',
                        'perfil_id.required' => 'O perfil deve ser selecionado',
                    ]
                );
            }
        }

        if (Auth::user()->perfil_id === 2) {
            return redirect()->route('registros.index')
                ->with('error', 'Você não tem acesso.');
        }

        if (Auth::user()->perfil_id === 3) {

            if($request->password){
                $request->validate(
                    [
                        'name' => ['required', 'string', 'max:255'],
                        'password' => ['required', 'confirmed', Password::min(10)->letters()->mixedCase()->numbers()->symbols()],
                        'perfil_id' => ['required', Rule::in([2, 3])]
                    ],
                    [
                        'name.required' => 'O nome deve ser digitado',
                        'password.required' => 'O password deve ser digitado',
                        'perfil_id.required' => 'O perfil deve ser selecionado',
                        'perfil_id.rule' => 'O perfil selecionado é inválido',
                    ]
                );
            } else {
                $request->validate(
                    [
                        'name' => ['required', 'string', 'max:255'],
                        'perfil_id' => ['required', Rule::in([2, 3])]
                    ],
                    [
                        'name.required' => 'O nome deve ser digitado',
                        'perfil_id.required' => 'O perfil deve ser selecionado',
                        'perfil_id.rule' => 'O perfil selecionado é inválido',
                    ]
                );
            }
        }

        $name = $request->old('name');
        $email = $request->old('email');
        $perfil_id = $request->old('perfil_id');

        if($request->password){
            $request->merge([
                'password' => Hash::make($request->password),
            ]);
        }

        if (Auth::id() === $usuario->usuario_criador_id || Auth::user()->perfil_id === 1) {
            if($request->password){
                $usuario->update([
                    'name' => $request->name,
                    'password' => Hash::make($request->password),
                    'perfil_id' => $request->perfil_id
                ]);
            } else {
                $usuario->update([
                    'name' => $request->name,
                    'perfil_id' => $request->perfil_id
                ]);
            }
        } else {
            return redirect()->route('usuarios.index')
                ->with('error', 'Você não tem permissão para editar este usuário.');
        }

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuário atualizado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $usuario)
    {

        if (Auth::id() === $usuario->usuario_criador_id || Auth::user()->perfil_id === 1) {
            $usuario->update(['status' => 2]);
        } else {
            return redirect()->route('usuarios.index')
                ->with('error', 'Você não tem permissão para excluir este usuário.');
        }

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuário apagado com sucesso');
    }

    public function inativos()
    {
        $usuarios = DB::table('users')
            ->leftJoin('perfils', 'perfils.id', '=', 'perfil_id')
            ->select(['users.id', 'users.name', 'users.email', 'perfils.perfil'])
            ->where('users.status', '=', 2)
            ->get();

        return view('usuarios.inativos')->with('usuarios', $usuarios);
    }

    public function ativar(Request $request)
    {
        User::where('id', $request->id)->update(['status' => 1]);

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuário reativado com sucesso');
    }
}
