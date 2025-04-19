<?php

namespace App\Services;

use App\Models\ShortLink;
use Carbon\Carbon;

final class ShortLinkService
{
    const CHARACTERS = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    private function generateSlug(int $length): string
    {
        do {
            $slug = '';
            for ($i = 0; $i < $length; $i++) {
                $slug .= self::CHARACTERS[random_int(0, strlen(self::CHARACTERS) - 1)];
            }
        } while (ShortLink::where('slug', $slug)->exists());

        return $slug;
    }

    public function createShortLink(string $url, ?int $ttlDays = null): ShortLink
    {
        $slugLength = config('slug.max_length');
        $ttl = $ttlDays ?? config('slug.default_ttl_days');

        $slug = $this->generateSlug($slugLength);
        $expiresAt = Carbon::now()->addDays($ttl);

        return ShortLink::create([
            'slug' => $slug,
            'url' => $url,
            'expires_at' => $expiresAt,
        ]);
    }

    public function getBySlug(string $slug): ?ShortLink
    {
        return ShortLink::query()->firstWhere('slug', $slug);
    }
}
