<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Intl\Locales;
use Symfony\Component\Intl\Countries;

class ProfileController extends Controller
{
    public function edit() {
        $user = Auth::user();
        return view('dashboard.profile.edit',[
            'user'=>$user,
            'countries' => Countries::getNames(),
            'locales' => Locales::getNames(),
        ]);
    }

    public function update(Request $request){
        // dd($request);
        $request->validate([
            'first_name'=>['required','string','max:255'],
            'last_name'=>['required','string','max:255'],
            'birthday'=>['nullable','date','before:today'],
            'gender'=>['in:male,female'],
            'country'=>['required','string','size:2']
        ]);

        $user=$request->user();
        $user->profile->fill($request->all())->save();

        // $profile=$user->profile;
        // if($profile->name){
        //     $profile->update($request->all());
        // }else{
        //     // $request->merge([
        //     //     'user_id'=>$user->id
        //     // ]);
        //     // Profile::create($request->all());

        //     $user->profile()->create($request->all());
        // }

            return redirect()->route('dashboard.profile.edit')->with('success','the provile is saved');
    }
}
