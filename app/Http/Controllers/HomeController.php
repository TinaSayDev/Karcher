<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Загружаем только верхний уровень категорий + переводы
        $categories = Category::whereNull('parent_id')
            ->with(['translations'])
            ->get();

        return view('home', compact('categories'));
    }
}
