<?php

namespace App\Http\Controllers;

use App\Models\ShortLink;
use App\Services\ShortLinkService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Http;

final class RedirectController extends Controller
{
    public function __construct(
        private ShortLinkService $shortLinkService
    )
    {
    }

    public function index(string $slug): RedirectResponse
    {
        $link = $this->shortLinkService->getBySlug($slug);

        $defaultRedirect = config('slug.default_redirect');

        if (!$link || ($link->expires_at && $link->expires_at->isPast())) {
            return redirect()->away($defaultRedirect);
        }

        // Проверка доступности URL
        try {
            $response = Http::timeout(3)->head($link->url);
            if ($response->successful()) {
                return redirect()->away($link->url);
            }
        } catch (\Exception $e) {
            return redirect()->away($defaultRedirect);
        }

        return redirect()->away($defaultRedirect);
    }
}
