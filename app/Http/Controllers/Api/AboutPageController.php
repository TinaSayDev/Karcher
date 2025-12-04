<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AboutPage;
use Inertia\Inertia;

class AboutPageController extends Controller
{
    public function index()
    {
        $page = AboutPage::with('translations')->first();
        $translation = $page?->translation();

        return Inertia::render('AboutPage', [
            'page' => $translation
        ]);
    }
}
