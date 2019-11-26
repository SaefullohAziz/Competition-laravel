<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Judge;
use Illuminate\Http\Request;

class JudgeController extends Controller
{
    private $table;

    /**
     * Create a new class instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->table = 'judge';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $view = [
            'title' => __('Judges'),
            'breadcrumbs' => [
                route('admin.juri.index') => __('Administrator'),
                null => __('index')
            ],
        ];
        return view('admin.juri.index', $view);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\judge  $judge
     * @return \Illuminate\Http\Response
     */
    public function show(Judge $judge)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\judge  $judge
     * @return \Illuminate\Http\Response
     */
    public function edit(Judge $judge)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\judge  $judge
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Judge $judge)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\judge  $judge
     * @return \Illuminate\Http\Response
     */
    public function destroy(Judge $judge)
    {
        //
    }
}
