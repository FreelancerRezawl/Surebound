<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageContent extends Model
{
    protected $fillable = ['page', 'key', 'value'];

    /**
     * Get all content key-values for a given page merged with default fallbacks.
     */
    public static function getForPage(string $page, array $defaults = []): array
    {
        $stored = static::where('page', $page)->pluck('value', 'key')->all();
        return array_merge($defaults, array_filter($stored, fn($v) => !is_null($v)));
    }

    /**
     * Save/update array of key-value contents for a page.
     */
    public static function setForPage(string $page, array $data): void
    {
        foreach ($data as $key => $value) {
            if ($key === '_token' || $key === '_method') continue;
            static::updateOrCreate(
                ['page' => $page, 'key' => $key],
                ['value' => $value]
            );
        }
    }
}
