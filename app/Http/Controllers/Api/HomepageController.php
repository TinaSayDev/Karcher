<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HomepageSection;
use Illuminate\Http\Request;

class HomepageController extends Controller
{
    public function index()
    {
        $locale = app()->getLocale();

        // FAQ-секции
        $faq = HomepageSection::whereIn('key', ['faq-1', 'faq-2', 'faq-3'])
            ->get()
            ->mapWithKeys(function ($s) use ($locale) {
                $content = $s->getContent($locale);

                // Конвертируем текст из JSON Tiptap в HTML
                if (is_array($content['text'] ?? null)) {
                    $content['text'] = $this->tiptapToHtml($content['text']);
                }

                return [$s->key => $content];
            });

        // Chosen article
        $chosenArticle = HomepageSection::where('key', 'chosen-article')
            ->first()?->getContent($locale);

        // Address
        $address = HomepageSection::where('key', 'address')
            ->first()?->getContent($locale);

        // Shops
        $shops = HomepageSection::where('key', 'shops')
                ->first()?->getContent($locale)['shops'] ?? [];

        return response()->json([
            'faq' => $faq,
            'chosenArticle' => $chosenArticle,
            'address' => $address,
            'shops' => $shops,
        ]);
    }

    /**
     * Рекурсивно конвертирует Tiptap JSON в HTML
     */
    private function tiptapToHtml(array $node): string
    {
        $html = '';

        foreach ($node['content'] ?? [] as $child) {
            switch ($child['type'] ?? null) {
                case 'text':
                    $html .= htmlspecialchars($child['text']);
                    break;

                case 'paragraph':
                    $html .= '<p>' . $this->tiptapToHtml($child) . '</p>';
                    break;

                case 'bold':
                    $html .= '<strong>' . $this->tiptapToHtml($child) . '</strong>';
                    break;

                case 'italic':
                    $html .= '<em>' . $this->tiptapToHtml($child) . '</em>';
                    break;

                case 'link':
                    $href = htmlspecialchars($child['attrs']['href'] ?? '#');
                    $html .= '<a href="' . $href . '">' . $this->tiptapToHtml($child) . '</a>';
                    break;

                case 'bulletList':
                    $html .= '<ul>' . $this->tiptapToHtml($child) . '</ul>';
                    break;

                case 'orderedList':
                    $html .= '<ol>' . $this->tiptapToHtml($child) . '</ol>';
                    break;

                case 'listItem':
                    $html .= '<li>' . $this->tiptapToHtml($child) . '</li>';
                    break;

                default:
                    $html .= $this->tiptapToHtml($child);
            }
        }

        return $html;
    }
}
