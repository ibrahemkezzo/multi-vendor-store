<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Symfony\Component\Routing\Matcher\Dumper\StaticPrefixCollection;

class Role extends Model
{
    use HasFactory;
    protected $fillable=['name'];

    public static function CreateWithAbilities($request){
        // dd($request->abilities);
        DB::beginTransaction();
        try{
            $role = Role::create([
                'name'=>$request->post('name')
            ]);
            foreach($request->post('abilities') as $ability => $value){
                RoleAbility::create([
                    'role_id'=>$role->id,
                    'ability'=>$ability,
                    'type'=>$value,
                ]);
            }
            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            throw $e;
        }
        return $role;
    }
    public function UpdateWithAbilities($request){
        // dd($this);
        DB::beginTransaction();
        try{
            $this->update(['name'=> $request->post('name')]);
            foreach ($request->post('abilities') as $ability => $value) {
                RoleAbility::updateOrCreate([
                    'role_id'=>$this->id,
                    'ability'=>$ability
                ],[
                    'type'=>$value
                ]);
            }
            Db::commit();

        }catch(\Exception $e){
            DB::rollBack();
            throw $e;
        }
        return $this;
    }
    public function before($user,$ability){
        if($user->super_admin){return true;}
    }
    public function abilities(){
        return $this->hasMany(RoleAbility::class,'role_id','id');
    }
}
