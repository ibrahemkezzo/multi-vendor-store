<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProductPolicy
{
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
        return $user->hasAbility('product.view');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view( $user, Product $product): bool
    {
        return $user->hasAbility('product.view')&& $user->store_id == $product->store_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create( $user): bool
    {
        // dd($user);
        return $user->hasAbility('product.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update( $user, Product $product): bool
    {
        return $user->hasAbility('product.update')&& $user->store_id == $product->store_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete( $user, Product $product): bool
    {
        return $user->hasAbility('product.delete')&& $user->store_id == $product->store_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    // public function restore( $user, Product $product): bool
    // {
    //     //
    // }

    // /**
    //  * Determine whether the user can permanently delete the model.
    //  */
    // public function forceDelete( $user, Product $product): bool
    // {
    //     //
    // }
}
