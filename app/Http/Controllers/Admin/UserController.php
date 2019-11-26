<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use DataTables;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
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
        $this->table = 'user';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $view = [
            'title' => __('Users'),
            'breadcrumbs' => [
                route('admin.user.index') => __('User'),
                null => __('index')
            ],
        ];
        return view('admin.user.index', $view);
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $user = User::list($request);
            return DataTables::of($user)
                ->addColumn('DT_RowIndex', function ($data) {
                    return '<div class="checkbox icheck"><label><input type="checkbox" name="selectedData[]" value="'.$data->id.'"></label></div>';
                })
                ->editColumn('created_at', function($data) {
                    return (date('d-m-Y h:m:s', strtotime($data->created_at)));
                })
                ->addColumn('action', function($data) {
                    return '<a class="btn btn-sm btn-primary" href="'.route('admin.user.show', $data->id).'" title="'.__("See detail").'"><i class="fa fa-eye"></i> '.__("See").'</a> <a class="btn btn-sm btn-warning" href="'.route('admin.user.edit', $data->id).'" title="'.__("Edit").'"><i class="fa fa-edit"></i> '.__("Edit").'</a>';
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
        //     return redirect()->route('admin.user.index')->with('alert-danger', __($this->noPermission));
        // }
        // if (auth()->guard('admin')->user()->cant('adminCreate', User::class)) {
        //     return redirect()->route('admin.user.index')->with('alert-danger', __($this->unauthorizedMessage));
        // }
        $view = [
            'title' => __('Create User'),
            'breadcrumbs' => [
                route('admin.user.index') => __('User'),
                null => __('Create')
            ],
        ];

        return view('admin.user.create', $view);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // if (auth()->user()->cant('create', User::class)) {
        //     return redirect()->route('user.index')->with('alert-danger', __($this->unauthorizedMessage));
        // }
        $validatedData = $request->validate([
            'name' => 'required|unique:users|max:255',
            'username' => 'required|unique:users',
            'email' => 'required|unique:users',
            'password' => 'required',
        ]);
        $request->merge(['password' =>  Hash::make($request->password)]);
        $user = User::create($request->all());
        $user->photo = $this->uploadImage($user, $request);
        $user->save();
        return redirect(route('admin.user.index'))->with('alert-success', __($this->createdMessage));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $view = [
            'title' => __('User Detail'),
            'breadcrumbs' => [
                route('admin.user.index') => __('Users'),
                null => __('Show')
            ],
            'user' => $user,
        ];

        return view('admin.user.show', $view);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function edit(user $user)
    {
        // if (auth()->user()->cant('edit', user::class)) {
        //     return redirect()->route('user.index')->with('alert-danger', __($this->unauthorizedMessage));
        // }
        $view = [
            'title' => __('User Edit'),
            'breadcrumbs' => [
                route('admin.user.index') => __('User'),
                null => __('Edit')
            ],
            'competitions' => Competition::orderBy('created_at', 'DESC')->pluck('name', 'id')->toArray(),
            'user' => $user,
        ];

        return view('admin.user.edit', $view);
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
            if (User::destroy($request->selectedData)){
                return response()->json(['status' => true, 'message' => __($this->deletedMessage)]);
            }
            return response()->json(['status' => false, 'message' => __($this->errorMessage)]);
        }
    }

    /**
     * Upload submission letter
     * 
     * @param  \App\user  $user
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $oldFile
     * @return string
     */
    public function uploadImage($user, Request $request, $oldFile = null)
    {
        if ($request->hasFile('photo')) {
            $filename = 'image_'.md5($user->name).'.'.$request->photo->extension();
            $path = $request->file('photo')->storeAs('img/avatar/'.$user->id, $filename);
            return $user->id.'/'.$filename;
        }
        return $oldFile;
    }
}
