<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AboutPage;
use Inertia\Inertia;

class PageController extends Controller
{
    public function about()
    {
        $page = AboutPage::with('translations')->first();
        $translation = $page?->translation();

        return Inertia::render('AboutPage', [
            'page' => $translation
        ]);
    }

    public function contacts()
    {
        return Inertia::render('Contacts');
    }
}
