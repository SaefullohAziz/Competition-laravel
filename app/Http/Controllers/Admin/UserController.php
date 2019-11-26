<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Contest;
use App\Competition;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $view = [ 
            'title' => 'Users',
            'competitions' => Competition::pluck('name', 'id')->toArray(),
            'contests' => Contest::pluck('name', 'id')->toArray()
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
        //     return redirect()->route('admin.contest.index')->with('alert-danger', __($this->noPermission));
        // }
        // if (auth()->guard('admin')->user()->cant('adminCreate', Contest::class)) {
        //     return redirect()->route('admin.contest.index')->with('alert-danger', __($this->unauthorizedMessage));
        // }
        $view = [
            'title' => __('Create User'),
            'breadcrumbs' => [
                route('admin.user.index') => __('User'),
                null => __('Create')
            ],
            'competitions' => Competition::orderBy('created_at', 'DESC')->pluck('name', 'id')->toArray(),
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(user $user)
    {
        // if (auth()->user()->cant('edit', contest::class)) {
        //     return redirect()->route('contest.index')->with('alert-danger', __($this->unauthorizedMessage));
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
