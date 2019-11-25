<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Administrator;
use DataTables;
use Illuminate\Support\Facades\Hash;

class AdministratorController extends Controller
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
        $this->table = 'administrator';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $view = [
            'title' => __('Administrators'),
            'breadcrumbs' => [
                route('admin.administrator.index') => __('Administrator'),
                null => __('index')
            ],
        ];
        return view('admin.administrator.index', $view);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        if ($request->ajax()) {
            $administrator = Administrator::list($request);
            return DataTables::of($administrator)
                ->addColumn('DT_RowIndex', function ($data) {
                    return '<div class="checkbox icheck"><label><input type="checkbox" name="selectedData[]" value="'.$data->id.'"></label></div>';
                })
                ->editColumn('created_at', function($data) {
                    return (date('d-m-Y h:m:s', strtotime($data->created_at)));
                })
                ->addColumn('action', function($data) {
                    return '<a class="btn btn-sm btn-primary" href="'.route('admin.administrator.show', $data->id).'" title="'.__("See detail").'"><i class="fa fa-eye"></i> '.__("See").'</a> <a class="btn btn-sm btn-warning" href="'.route('admin.administrator.edit', $data->id).'" title="'.__("Edit").'"><i class="fa fa-edit"></i> '.__("Edit").'</a>';
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
            'title' => __('Create Administrator'),
            'breadcrumbs' => [
                route('admin.administrator.index') => __('Administrator'),
                null => __('Create')
            ],
        ];
        return view('admin.administrator.create', $view);
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
        $this->validate($request, [
            'name' => 'required|unique:administrators|max:255',
            'username' => 'required|unique:administrators',
            'email' => 'required',
            'password' => 'required',
        ]);
        $request->merge(['password' =>  Hash::make($request->password)]);
        $administrator = Administrator::create($request->all());
        $administrator->photo = $this->uploadImage($administrator, $request);
        $administrator->save();
        return redirect(route('admin.administrator.index'))->with('alert-success', __($this->createdMessage));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Administrator  $administrator
     * @return \Illuminate\Http\Response
     */
    public function show(Administrator $administrator)
    {
        $view = [
            'title' => __('Administrator Detail'),
            'breadcrumbs' => [
                route('admin.administrator.index') => __('Administrators'),
                null => __('Show')
            ],
            'administrator' => $administrator,
        ];

        return view('admin.administrator.show', $view);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\administrator  $administrator
     * @return \Illuminate\Http\Response
     */
    public function edit(administrator $administrator)
    {
        $view = [
            'title' => __('Administrators edit'),
            'breadcrumbs' => [
                route('admin.administrator.index') => __('Administrator'),
                null => __('show')
            ],
            'administrator' => $administrator,
        ];
        return view('admin.administrator.edit', $view);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\administrator  $administrator
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, administrator $administrator)
    {
        // if (auth()->user()->cant('create', Administrator::class)) {
        //     return redirect()->route('administrator.index')->with('alert-danger', __($this->unauthorizedMessage));
        // }
        $validatedData = $request->validate([
            'name' => 'required|unique:administrators|max:255',
            'username' => 'required|unique:administrators',
            'email' => 'required',
            'photo' => 'mimes:jpeg,png,jpg',
        ]);
        $administrator->fill($request->all());
        $administrator->photo = $this->uploadImage($administrator, $request, $administrator->photo);
        $administrator->save();
        return redirect(route('admin.administrator.edit' , $administrator->id))->with('alert-success', __($this->updatedMessage))   ;
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
            if (Administrator::destroy($request->selectedData)){
                return response()->json(['status' => true, 'message' => __($this->deletedMessage)]);
            }
            return response()->json(['status' => false, 'message' => __($this->errorMessage)]);
        }
    }

    /**
     * Upload submission letter
     * 
     * @param  \App\administrator  $administrator
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $oldFile
     * @return string
     */
    public function uploadImage($administrator, Request $request, $oldFile = null)
    {
        if ($request->hasFile('photo')) {
            $filename = 'image_'.md5($administrator->name).'.'.$request->photo->extension();
            $path = $request->file('photo')->storeAs('img/avatar/'.$administrator->id, $filename);
            return $administrator->id.'/'.$filename;
        }
        return $oldFile;
    }
}
