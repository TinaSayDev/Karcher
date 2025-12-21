<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AboutPage;
use App\Models\Contact;
use Illuminate\Http\Request;
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
        $locale = app()->getLocale(); // ru / en / uz

        $contacts = Contact::with('translations')->get();

        return Inertia::render('Contacts', [
            'contacts' => $contacts->map(function ($contact) use ($locale) {
                $translation = $contact->translations
                        ->firstWhere('locale', $locale)
                    ?? $contact->translations->firstWhere('locale', 'ru');

                return [
                    'key' => $contact->key,
                    'label' => $translation?->label,
                    'address' => $translation?->address,
                    'phone' => $translation?->phone,
                    'email' => $translation?->email,
                    'schedule' => $translation?->schedule,
                ];
            }),
        ]);
    }
}
