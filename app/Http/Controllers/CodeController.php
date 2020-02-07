<?php

namespace App\Http\Controllers;

use App\Code;
use App\Http\Requests\CreateCodeRequest;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CodeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $codes = Code::paginate(10);

        $latest_codes = Code::whereDate('created_at', '=', Carbon::today())->count();

        return view('code.index', compact('codes', 'latest_codes'));
    }

    public function create()
    {
        return view('code.create');
    }

    public function store(CreateCodeRequest $request)
    {
        if ($request->code > 100 || $request->code <= 0) {
            $data = [
                'message' => 'Error: Can only generate maximum of 100 minimum of 1',
                'success' => false,
            ];

            return redirect('code')->with($data);
        }


        $codes = [];

        for ($i=0; $i < $request->code; $i++) { 
            $codes[] = [
                'user_id' => auth()->user()->id,
                'code' => (date('His', time())+$i).Str::random(4),
            ];
        }

        Code::insert($codes);

        $data = [
            'message' => 'Code generated Successfully',
            'success' => true,
        ];

        return redirect('code')->with($data);
    }

    public function show(Code $code)
    {
        //
    }

    public function edit(Code $code)
    {
        //
    }

    public function update(Request $request, Code $code)
    {
        //
    }

    public function destroy(Code $code)
    {
        //
    }
}
