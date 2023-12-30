<?php

namespace App\Http\Controllers;

use App\Models\Penyewa;
use App\Http\Requests\StorePenyewaRequest;
use App\Http\Requests\UpdatePenyewaRequest;

class PenyewaController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePenyewaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePenyewaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Penyewa  $penyewa
     * @return \Illuminate\Http\Response
     */
    public function show(Penyewa $penyewa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Penyewa  $penyewa
     * @return \Illuminate\Http\Response
     */
    public function edit(Penyewa $penyewa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePenyewaRequest  $request
     * @param  \App\Models\Penyewa  $penyewa
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePenyewaRequest $request, Penyewa $penyewa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Penyewa  $penyewa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Penyewa $penyewa)
    {
        //
    }
}
