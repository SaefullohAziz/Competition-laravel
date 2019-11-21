<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Competition;
use Illuminate\Http\Request;
use DataTables;

class CompetitionController extends Controller
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
        $this->table = 'competition';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $view = [
            'title' => __('Competitons'),
            'breadcrumbs' => [
                route('admin.competition.index') => __('Competition'),
                null => __('index')
            ],
        ];
        return view('admin.competition.index', $view);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        if ($request->ajax()) {
            $competition = Competition::list($request);
            return DataTables::of($competition)
                ->addColumn('DT_RowIndex', function ($data) {
                    return '<div class="checkbox icheck"><label><input type="checkbox" name="selectedData[]" value="'.$data->id.'"></label></div>';
                })
                ->editColumn('created_at', function($data) {
                    return (date('d-m-Y h:m:s', strtotime($data->created_at)));
                })
                ->addColumn('action', function($data) {
                    return '<a class="btn btn-sm btn-success" href="'.route('admin.competition.show', $data->id).'" title="'.__("See detail").'"><i class="fa fa-eye"></i> '.__("See").'</a> <a class="btn btn-sm btn-warning" href="'.route('admin.competition.edit', $data->id).'" title="'.__("Edit").'"><i class="fa fa-edit"></i> '.__("Edit").'</a>';
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
            'title' => __('Create Competition'),
            'breadcrumbs' => [
                route('admin.competition.index') => __('Competition'),
                null => __('Create')
            ],
        ];
        return view('admin.competition.create', $view);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // if (auth()->user()->cant('create', Competition::class)) {
        //     return redirect()->route('competition.index')->with('alert-danger', __($this->unauthorizedMessage));
        // }
        $validatedData = $request->validate([
            'name' => 'required|unique:name|max:255',
            'alias' => 'required|unique:alias',
            'theme' => 'required',
            'theme' => 'required',
            'image' => 'mimes:jpeg,png,jpg',
            'date' => 'required',
        ]);
        $request->merge([
            'date' => date('Y-m-d', strtotime($request->date)),
        ]);
        $competition = Competition::create($request->all());
        $competition->image = $this->uploadImage($competition, $request);
        $competition->save();
        return redirect(route('admin.competition.index'))->with('alert-success', __($this->createdMessage));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\competition  $competition
     * @return \Illuminate\Http\Response
     */
    public function show(competition $competition)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\competition  $competition
     * @return \Illuminate\Http\Response
     */
    public function edit(competition $competition)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\competition  $competition
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, competition $competition)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\competition  $competition
     * @return \Illuminate\Http\Response
     */
    public function destroy(competition $competition)
    {
        //
    }

    /**
     * Upload submission letter
     * 
     * @param  \App\Subsidy  $subsidy
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $oldFile
     * @return string
     */
    public function uploadImage($competition, Request $request, $oldFile = null)
    {
        if ($request->hasFile('image')) {
            $filename = 'image_'.md5($competition->name).'.'.$request->image->extension();
            $path = $request->image->storeAs('public/competition/'.$competition->name, $filename);
            return $competition->id.'/'.$filename;
        }
        return $oldFile;
    }
}
