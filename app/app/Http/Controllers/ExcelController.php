<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\ExcelImport;
use Excel;

class ExcelController extends Controller
{
    // API
    public function upload(Request $request)
    {
        Excel::import(new ExcelImport, $request->file('file'));
    }
}
