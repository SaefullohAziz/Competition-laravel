<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use DataTables;
use App\School;
use Illuminate\Http\Request;

class SchoolController extends Controller
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
        $this->table = 'school';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $view = [
            'title' => __('Schools'),
            'breadcrumbs' => [
                route('admin.school.index') => __('Schools'),
                null => __('index')
            ],
        ];
        return view('admin.school.index', $view);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        if ($request->ajax()) {
            $school = School::list($request);
            return DataTables::of($school)
                ->addColumn('DT_RowIndex', function ($data) {
                    return '<div class="checkbox icheck"><label><input type="checkbox" name="selectedData[]" value="'.$data->id.'"></label></div>';
                })
                ->editColumn('created_at', function($data) {
                    return (date('d-m-Y h:m:s', strtotime($data->created_at)));
                })
                ->editColumn('name', function($data) {
                    return $data->type.' '.$data->name;
                })
                ->addColumn('action', function($data) {
                    return '<a class="btn btn-sm btn-primary" href="'.route('admin.school.show', $data->id).'" title="'.__("See detail").'"><i class="fa fa-eye"></i> '.__("See").'</a> <a class="btn btn-sm btn-warning" href="'.route('admin.school.edit', $data->id).'" title="'.__("Edit").'"><i class="fa fa-edit"></i> '.__("Edit").'</a>';
                })
                ->rawColumns(['DT_RowIndex', 'action'])
                ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // if ( ! auth()->guard('admin')->user()->can('create ' . $this->table)) {
        //     return redirect()->route('admin.school.index')->with('alert-danger', __($this->noPermission));
        // }
        // if (auth()->guard('admin')->user()->cant('adminCreate', School::class)) {
        //     return redirect()->route('admin.school.index')->with('alert-danger', __($this->unauthorizedMessage));
        // }
        $view = [
            'title' => __('Create School'),
            'breadcrumbs' => [
                route('admin.school.index') => __('School'),
                null => __('Create')
            ],
            'types' => ['MAN' => 'MAN', 'MA' => 'MA', 'SMKS' => 'SMKS', 'SMKN' => 'SMKN', 'SMPN' => 'SMPN', 'SMPS' => 'SMPS', 'MTS' => 'MTS', 'MTSN' => 'MTSN'],
        ];

        return view('admin.school.create', $view);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // if (auth()->user()->cant('create', School::class)) {
        //     return redirect()->route('school.index')->with('alert-danger', __($this->unauthorizedMessage));
        // }
        $validatedData = $request->validate([
            'type' => 'required',
            'name' => 'required|unique:schools|max:255',
            'email' => 'required|unique:schools',
        ]);
        School::create($request->all());
        return redirect(route('admin.school.create'))->with('alert-success', __($this->createdMessage));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\School  $school
     * @return \Illuminate\Http\Response
     */
    public function show(School $school)
    {
        $view = [
            'title' => __('School Detail'),
            'breadcrumbs' => [
                route('admin.school.index') => __('Schools'),
                null => __('Show')
            ],
            'school' => $school,
        ];

        return view('admin.school.show', $view);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\School  $school
     * @return \Illuminate\Http\Response
     */
    public function edit(School $school)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\School  $school
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, School $school)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\School  $school
     * @return \Illuminate\Http\Response
     */
    public function destroy(School $school)
    {
        //
    }
}
