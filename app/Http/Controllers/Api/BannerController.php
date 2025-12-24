<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index(Request $request)
    {
        $locale = $request->query('locale', app()->getLocale());

        $banners = Banner::where('locale', $locale)
            ->get(['image', 'link']);

        // возвращаем полный URL к изображению
        $banners->transform(function ($banner) {
            $banner->image = asset("storage/{$banner->image}");
            return $banner;
        });

        return response()->json($banners);
    }
}
