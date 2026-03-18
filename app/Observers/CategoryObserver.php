<?php

namespace App\Observers;

use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CategoryObserver
{
    public function created(Category $category): void
    {
        Log::channel('category')->info('create', [
            'actor_user_id' => Auth::id(),
            'actor_role' => Auth::user()?->role,
            'category_id' => $category->id,
        ]);
    }

    public function updated(Category $category): void
    {
        Log::channel('category')->info('update', [
            'actor_user_id' => Auth::id(),
            'actor_role' => Auth::user()?->role,
            'category_id' => $category->id,
            'changed' => array_keys($category->getChanges()),
        ]);
    }

    public function deleted(Category $category): void
    {
        Log::channel('category')->info('delete', [
            'actor_user_id' => Auth::id(),
            'actor_role' => Auth::user()?->role,
            'category_id' => $category->id,
        ]);
    }
}
