<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;

class InvalidOrdeerException extends Exception
{
    // public function report(){

    // }
    public function render(Request $request){
        // dd($this->getMessage());
        return redirect()->route('front.home')
                ->withInput()
                ->withErrors(['message'=>$this->getMessage()])
                ->with('info',$this->getMessage());
    }
}
