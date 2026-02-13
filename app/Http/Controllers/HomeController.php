<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ebook;
use App\Models\Category;

class HomeController extends Controller
{
    /**
     * USER HOME PAGE
     */
    public function userHome(Request $request)
    {
        $query = Ebook::query();

        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->category) {
            $query->where('category_id', $request->category);
        }

        $ebooks = $query->latest()->paginate(8);
        $categories = Category::all();

        return view('ebook.home', compact('ebooks', 'categories'));
    }
}
