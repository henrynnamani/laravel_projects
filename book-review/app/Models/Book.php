<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function scopeTitle(Builder $query, string $title): Builder // local query selector
    {
        return $query->where('title', 'LIKE', '%' . $title . '%');
    }

    public function scopeWithReviewsCount(Builder $query, $from = null, $to = null): Builder
    {
        return $query->withCount(relations: [
            'reviews' => fn(Builder $q) => $this->dateRangeFilter($q, $from, $to)
        ]);
    }

    public function scopeWithAvgRating(Builder $query, $from = null, $to = null): Builder
    {
        return $query->withAvg([
            'reviews' => fn(Builder $q) => $this->dateRangeFilter($q, $from, $to)
        ], 'rating');
    }

    public function scopePopular(Builder $query, $from = null, $to = null): Builder
    {
        return $query->withReviewsCount()->orderBy('reviews_count', 'desc');
    }

    public function scopeHighestRated(Builder $query, $from = null, $to = null): Builder
    {
        return $query->withAvgRating()->orderBy('reviews_avg_rating', 'desc');
    }

    public function scopeMinReviews(Builder $query, int $minReviews): Builder
    {
        return $query->having('reviews_count', '>=', $minReviews);
    }

    private function dateRangeFilter(Builder $query, $from = null, $to = null)
    {
        if ($from && !$to) {
            $query->where('created_at', '>=', $from);
        } elseif (!$from && $to) {
            $query->where('created_at', '<=', $to);
        } elseif ($from && $to) {
            $query->whereBetween('created_at', [$from, $to]);
        }
    } // query object is modified, since it's passed by reference

    public function scopePopularLastMonth(Builder $query)
    {
        return $query->popular(now()->subMonths(), now())->highestRated(now()->subMonths(), now())->minReviews(2);
    }

    public function scopePopularLast6Month(Builder $query)
    {
        return $query->popular(now()->subMonths(6), now())->highestRated(now()->subMonths(6))->minReviews(2);
    }

    public function scopeHighestRatedLastMonth(Builder $query)
    {
        return $query->highestRated(now()->subMonths(), now())->popular(now()->subMonths(6), now())->minReviews(5);
    }

    public function scopeHighestRatedLast6Month(Builder $query)
    {
        return $query->highestRated(now()->subMonths(), now())->popular(now()->subMonths(6), now())->minReviews(5);
    }

    protected static function booted()
    {
        static::updated(fn(Book $book) => cache()->forget('book:' . $book->id));
        static::deleted(fn(Book $book) => cache()->forget('book:' . $book->id));
        static::created(fn(Book $book) => cache()->forget('book:' . $book->id));
    }
}
