<?php

namespace App\Http\Controllers;

use App\Models\Config;
use Exception;
use Illuminate\Http\Request;

class ConfigController extends Controller
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
        $config = Config::latest()->first();
        if ($config){
            return redirect()->route('configs.edit', $config->id);
        }
        return view('config.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /* $config = Config::latest()->first();
        if ($config){
            return redirect()->route('configs.edit', $config->id);
        } */

        $request->validate([
            'email' => 'required|email',
            'corpo_email' => 'required',
            'link' => 'required|url',
        ]);

        $email = $request->old('email');
        $corpo_email = $request->old('corpo_email');
        $link = $request->old('link');

        try {
            $config = Config::create($request->all());
        } catch (Exception $e) {
            return redirect()->route('cadastros.index')
            ->with('error', $e->getMessage());
        }

        return redirect()->route('cadastros.index')
            ->with('success', "Config criada com sucesso!!!");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $config = Config::findOrFail($id);
        return view('config.show', compact('config'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $config = Config::findOrFail($id);
        return view('config.edit', compact('config'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Config $config)
    {

        $request->validate([
            'email' => 'required|email',
            'corpo_email' => 'required',
            'link' => 'required',
        ]);

        $email = $request->old('email');
        $corpo_email = $request->old('corpo_email');
        $link = $request->old('link');

        try {
            $config->update($request->all());
        } catch (Exception $e) {
            return redirect()->route('cadastros.index')
            ->with('error', $e->getMessage());
        }

        return redirect()->route('cadastros.index')
            ->with('success', "Configs Atualizadas");
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
