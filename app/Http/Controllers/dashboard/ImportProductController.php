<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Jobs\ImportProduct;
use Illuminate\Http\Request;

class ImportProductController extends Controller
{
    public function create(){
        return view('dashboard.products.import');
    }
    public function sotre(Request $request){
        $job = new ImportProduct($request->post('count'));
        $job->onQueue('import');
        $this->dispatch($job);
        return redirect()->route('dashboard.products.index')->with('success','Downloading successfully');
    }
}
