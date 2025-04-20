<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Book;

class BookFilterService
{
    public static function filter(Request $request, ?int $categoryId = null)
    {
        $query = Book::query();

        if ($categoryId) {
            $query->whereHas('categories', fn($q) =>
                $q->where('category_id', $categoryId)
            );
        }

        if ($request->filled('query')) {
            $query->where('title', 'like', '%' . $request->input('query') . '%');
        }

        if ($request->filled('author')) {
            $query->whereIn('author', $request->input('author'));
        }

        if ($request->filled('language')) {
            $query->whereIn('language', $request->input('language'));
        }

        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->input('price_min'));
        }

        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->input('price_max'));
        }

        switch ($request->input('sort')) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'title_desc':
                $query->orderBy('title', 'desc');
                break;
            case 'title_asc':
                $query->orderBy('title', 'asc');
                break;
            case 'new':
            default:
                $query->orderBy('release_year', 'desc');
                break;
        }

        return $query->paginate(10);
    }
}
