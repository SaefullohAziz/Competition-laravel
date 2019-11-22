<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Contest;
use App\Competition;
use DataTables;
use Illuminate\Http\Request;

class ContestController extends Controller
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
        $this->table = 'contests';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $view = [
            'title' => __('Contests'),
            'breadcrumbs' => [
                route('admin.contest.index') => __('Contest'),
                null => __('index')
            ],
            'competitions' => Competition::orderBy('created_at')->pluck('name','id')->toArray(),
            'contests' => Contest::groupBy('name')->pluck('name', 'name')->toArray(),
        ];
        return view('admin.contest.index', $view);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        if ($request->ajax()) {
            $contests = Contest::list($request);
            return DataTables::of($contests)
                ->addColumn('DT_RowIndex', function ($data) {
                    return '<div class="checkbox icheck"><label><input type="checkbox" name="selectedData[]" value="'.$data->id.'"></label></div>';
                })
                ->editColumn('created_at', function($data) {
                    return (date('d-m-Y h:m:s', strtotime($data->created_at)));
                })
                ->addColumn('action', function($data) {
                    return '<a class="btn btn-sm btn-primary" href="'.route('admin.contest.show', $data->id).'" title="'.__("See detail").'"><i class="fa fa-eye"></i> '.__("See").'</a> <a class="btn btn-sm btn-warning" href="'.route('admin.contest.edit', $data->id).'" title="'.__("Edit").'"><i class="fa fa-edit"></i> '.__("Edit").'</a>';
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
            'title' => __('Create Contest'),
            'breadcrumbs' => [
                route('admin.contest.index') => __('Contest'),
                null => __('Create')
            ],
            'competitions' => Competition::orderBy('created_at', 'DESC')->pluck('name', 'id')->toArray(),
        ];

        return view('admin.contest.create', $view);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // if (auth()->user()->cant('create', contest::class)) {
        //     return redirect()->route('contest.index')->with('alert-danger', __($this->unauthorizedMessage));
        // }
        $validatedData = $request->validate([
            'name' => 'required|unique:contests|max:255',
            'limit' => 'numeric',
        ]);
        $contest = Contest::create($request->all());
        return redirect(route('admin.contest.create'))->with('alert-success', __($this->createdMessage));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\contest  $contest
     * @return \Illuminate\Http\Response
     */
    public function show(Contest $contest)
    {
        $view = [
            'title' => __('Contest Detail'),
            'breadcrumbs' => [
                route('admin.contest.index') => __('Contest'),
                null => __('Show')
            ],
            'competitions' => Competition::orderBy('created_at', 'DESC')->pluck('name', 'id')->toArray(),
            'contest' => $contest,
        ];

        return view('admin.contest.show', $view);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\contest  $contest
     * @return \Illuminate\Http\Response
     */
    public function edit(Contest $contest)
    {
        // if (auth()->user()->cant('edit', contest::class)) {
        //     return redirect()->route('contest.index')->with('alert-danger', __($this->unauthorizedMessage));
        // }
        $view = [
            'title' => __('Contest Edit'),
            'breadcrumbs' => [
                route('admin.contest.index') => __('Contest'),
                null => __('Edit')
            ],
            'competitions' => Competition::orderBy('created_at', 'DESC')->pluck('name', 'id')->toArray(),
            'contest' => $contest,
        ];

        return view('admin.contest.edit', $view);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\contest  $contest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contest $contest)
    {
        // if (auth()->user()->cant('edit', contest::class)) {
        //     return redirect()->route('contest.index')->with('alert-danger', __($this->unauthorizedMessage));
        // }
        $contest->fill($request->all());
        return redirect(url()->previous())->with('alert-success', __($this->createdMessage));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\contest  $contest
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if ($request->ajax()) {
            // if ( ! auth()->guard('admin')->user()->can('delete ' . $this->table)) {
            //     return response()->json(['status' => false, 'message' => __($this->noPermission)], 422);
            // }
            if (Contest::destroy($request->selectedData)){
                return response()->json(['status' => true, 'message' => __($this->deletedMessage)]);
            }
            return response()->json(['status' => false, 'message' => __($this->errorMessage)]);
        }
    }
}
