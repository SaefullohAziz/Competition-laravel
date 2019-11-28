<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Judge;
use DataTables;
use Illuminate\Support\Facades\Hash;

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
            'title' => __('Juri'),
            'breadcrumbs' => [
                route('admin.juri.index') => __('Juri'),
                null => __('index')
            ],
        ];
        return view('admin.juri.index', $view);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        if ($request->ajax()) {
            $judge = Judge::list($request);
            return DataTables::of($judge)
                ->addColumn('DT_RowIndex', function ($data) {
                    return '<div class="checkbox icheck"><label><input type="checkbox" name="selectedData[]" value="'.$data->id.'"></label></div>';
                })
                ->editColumn('created_at', function($data) {
                    return (date('d-m-Y h:m:s', strtotime($data->created_at)));
                })
                ->addColumn('action', function($data) {
                    return '<a class="btn btn-sm btn-primary" href="'.route('admin.juri.show', $data->id).'" title="'.__("See detail").'"><i class="fa fa-eye"></i> '.__("See").'</a> <a class="btn btn-sm btn-warning" href="'.route('admin.juri.edit', $data->id).'" title="'.__("Edit").'"><i class="fa fa-edit"></i> '.__("Edit").'</a>';
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
        //     return redirect()->route('admin.judge.index')->with('alert-danger', __($this->noPermission));
        // }
        // if (auth()->guard('admin')->user()->cant('adminCreate', Judge::class)) {
        //     return redirect()->route('admin.judge.index')->with('alert-danger', __($this->unauthorizedMessage));
        // }
        $view = [
            'title' => __('Create Judge'),
            'breadcrumbs' => [
                route('admin.juri.index') => __('Judge'),
                null => __('Create')
            ],
        ];
        return view('admin.juri.create', $view);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // if (auth()->user()->cant('create', Judge::class)) {
        //     return redirect()->route('juri.index')->with('alert-danger', __($this->unauthorizedMessage));
        // }
        $this->validate($request, [
            'name' => 'required|unique:judges|max:255',
            'username' => 'required|unique:judges',
            'email' => 'required',
            'address' => 'required',
            'gender' => 'required',
            'password' => 'required',
        ]);
        $request->merge(['password' =>  Hash::make($request->password)]);
        $judge = Judge::create($request->all());
        $judge->photo = $this->uploadImage($judge, $request);
        $judge->save();
        return redirect(route('admin.juri.index'))->with('alert-success', __($this->createdMessage));
    }

     /**
     * Display the specified resource.
     *
     * @param  \App\Judge  $judge
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $view = [
            'title' => __('Judge Detail'),
            'breadcrumbs' => [
                route('admin.juri.index') => __('Judges'),
                null => __('Show')
            ],
            'judge' => Judge::find($id),
        ];

        return view('admin.juri.show', $view);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\judge  $judge
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $view = [
            'title' => __('Judjes edit'),
            'breadcrumbs' => [
                route('admin.juri.index') => __('Judge'),
                null => __('show')
            ],
            'judge' => Judge::find($id),
        ];
        return view('admin.juri.edit', $view);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\judge  $judge
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $judge = Judge::find($id);
        // if (auth()->user()->cant('create', Judge::class)) {
        //     return redirect()->route('judge.index')->with('alert-danger', __($this->unauthorizedMessage));
        // }
        $validatedData = $request->validate([
            'name' => 'required|unique:judges|max:255',
            'username' => 'required|unique:judges',
            'email' => 'required',
            'address' => 'required',
            'gender' => 'required',
            'photo' => 'mimes:jpeg,png,jpg',
        ]);
        if ($request->password !=NULL) {
            $request->merge(['password' => bcrypt($request->password)]);
        } else {
            $request->merge(['password' => $judge->password]);
        }
        $judge->fill($request->all());
        $judge->photo = $this->uploadImage($judge, $request, $judge->photo);
        $judge->save();
        return redirect(route('admin.juri.edit' , $judge->id))->with('alert-success', __($this->updatedMessage));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if ($request->ajax()) {
            // if ( ! auth()->guard('admin')->user()->can('delete ' . $this->table)) {
            //     return response()->json(['status' => false, 'message' => __($this->noPermission)], 422);
            // }
            if (Judge::destroy($request->selectedData)){
                return response()->json(['status' => true, 'message' => __($this->deletedMessage)]);
            }
            return response()->json(['status' => false, 'message' => __($this->errorMessage)]);
        }
    }

    public function uploadImage($judge, Request $request, $oldFile = null)
    {
        if ($request->hasFile('photo')) {
            $filename = 'image_'.md5($judge->photo).'.'.$request->photo->extension();
            $path = $request->file('photo')->storeAs('img/avatar/'.$judge->id, $filename);
            return $judge->id.'/'.$filename;
        }
        return $oldFile;
    }
}
