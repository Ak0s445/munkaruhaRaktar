<?php

namespace App\Observers;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProductObserver
{
    public function created(Product $product): void
    {
        Log::channel('product')->info('create', [
            'actor_user_id' => Auth::id(),
            'actor_role' => Auth::user()?->role,
            'product_id' => $product->id,
        ]);
    }

    public function updated(Product $product): void
    {
        Log::channel('product')->info('update', [
            'actor_user_id' => Auth::id(),
            'actor_role' => Auth::user()?->role,
            'product_id' => $product->id,
            'changed' => array_keys($product->getChanges()),
        ]);
    }

    public function deleted(Product $product): void
    {
        Log::channel('product')->info('delete', [
            'actor_user_id' => Auth::id(),
            'actor_role' => Auth::user()?->role,
            'product_id' => $product->id,
        ]);
    }
}
