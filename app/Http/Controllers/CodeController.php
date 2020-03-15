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

    public function index() {

        $this->query_fields = ['id', 'code', 'status', 'created_at', 'updated_at'];
        $this->fields['hidden'] = ['id'];
        $this->column_values = [
            'status' => [1=>'Available',0=>'Sold']
        ];
        $this->with_actions = false;

        $this->filters = [
            'text' => ['code'],
        ];

        return parent::index();
    }

    public function create() {

        $this->fields['text_replace'] = [
            'code' => 'Number of codes to be generated'
        ];

        return parent::create();
    }

    public function store(Request $request)
    {
        if ($request->code > 100 || $request->code <= 0) {
            return back()->withInputs()->with(parent::_response(false, 'Error: Can only generate maximum of 100 minimum of 1'));
        }

        $codes = [];

        for ($i=0; $i < $request->code; $i++) { 
            $codes[] = [
                'user_id' => auth()->user()->id,
                'code' => (date('Hjis', time())+$i).Str::random(4),
            ];
        }

        Code::insert($codes);

        return redirect('codes')->with(parent::_response(true, 'Codes generated Successfully'));
    }

}
