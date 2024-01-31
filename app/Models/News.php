<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class News extends Model
{
    use HasFactory;

    /**
     * scope for active items
     * @param $query
     * @return mixed
     */
    public function scopeActiveEntries($query)
    {
        return $query->where([
            'status' => 1,
            'is_approved' => 1,
        ]);
    }

    /**
     * scope for check language
     * @param $query
     * @return mixed
     */
    public function scopeWithLocalize($query)
    {
        return $query->where([
            'language' => getLanguage(),
        ]);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'news_tags');
    }

    public function auther(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }
}
