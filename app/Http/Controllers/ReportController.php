<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('report.index');
    }

    public function report(Request $request)
    {
        $from = $request->from;
        $to = $request->to;
        return view('report.report', compact('from', 'to'));
    }
}
