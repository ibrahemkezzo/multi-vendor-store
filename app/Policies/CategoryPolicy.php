<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\User;
use App\Models\Category;
use Illuminate\Auth\Access\Response;

class CategoryPolicy
{
    /**
 * Perform pre-authorization checks.
 */
    public function before($user, string $ability)
    {
        // dd($user);
        if ($user->super_admin) {
            return true;
        }
    }


    /**
     * Determine whether the user can view any models.
     */
    public function viewAny( $user): bool
    {
        return $user->hasAbility('category.view');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view( $user, Category $category): bool
    {
        return $user->hasAbility('category.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create( $user): bool
    {
        return $user->hasAbility('category.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update( $user, Category $category): bool
    {
        return $user->hasAbility('category.update');
        // dd($user);

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete( $user, Category $category): bool
    {
        return $user->hasAbility('category.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    // public function restore( $user, category $category): bool
    // {
    //     //
    // }

    // /**
    //  * Determine whether the user can permanently delete the model.
    //  */
    // public function forceDelete( $user, category $category): bool
    // {
    //     //
    // }
}
