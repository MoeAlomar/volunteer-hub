<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Opportunity extends Model
{
    public const CATEGORIES = ['بيئة', 'اجتماعي', 'تعليم', 'صحة', 'سياحة'];

    /** category => [emoji, fallback colour, image file name in public/images] */
    private const STYLES = [
        'بيئة'    => ['🌳', '#2e7d32', 'environment'],
        'اجتماعي' => ['🍲', '#b5651d', 'social'],
        'تعليم'   => ['📚', '#6a1b9a', 'education'],
        'صحة'     => ['⛑️', '#c0392b', 'health'],
        'سياحة'   => ['🧭', '#8d6e63', 'tourism'],
    ];

    protected $fillable = ['title', 'category', 'city', 'event_date', 'capacity', 'description'];

    protected $casts = [
        'event_date' => 'date',
        'capacity' => 'integer',
    ];

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    /** Uses withCount('registrations') when it was loaded, otherwise queries. */
    public function registeredCount(): int
    {
        if (array_key_exists('registrations_count', $this->attributes)) {
            return (int) $this->attributes['registrations_count'];
        }

        return $this->registrations()->count();
    }

    public function getRemainingAttribute(): int
    {
        return max(0, $this->capacity - $this->registeredCount());
    }

    public function getPercentAttribute(): int
    {
        return $this->capacity > 0
            ? min(100, (int) round($this->registeredCount() / $this->capacity * 100))
            : 0;
    }

    /** open | full | closed (event date already passed) */
    public function getStatusAttribute(): string
    {
        if ($this->event_date->lt(today())) {
            return 'closed';
        }

        return $this->remaining === 0 ? 'full' : 'open';
    }

    public function getIconAttribute(): string
    {
        return $this->style()[0];
    }

    public function getColorAttribute(): string
    {
        return $this->style()[1];
    }

    public function getImageAttribute(): string
    {
        return $this->style()[2];
    }

    private function style(): array
    {
        return self::STYLES[$this->category] ?? ['📌', '#2e7d32', 'environment'];
    }
}
