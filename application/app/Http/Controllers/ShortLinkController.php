<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateShortLinkRequest;
use App\Services\ShortLinkService;

final class ShortLinkController extends Controller
{
    public function __construct(
        private ShortLinkService $shortLinkService
    ) {}

    public function store(CreateShortLinkRequest $request)
    {
        $link = $this->shortLinkService->createShortLink(
            $request->input('url'),
            $request->input('ttl')
        );

        return response()->json([
            'slug' => $link->slug,
            'short_link' => url($link->slug),
            'expires_at' => $link->expires_at,
        ]);
    }
}
