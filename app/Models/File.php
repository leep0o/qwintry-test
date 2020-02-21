<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class File extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'filename', 'path', 'size',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'url', 'full_path',
    ];

    /**
     * Relation with model: Document
     *
     * @return BelongsTo
     */
    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }

    /**
     * Accessor 'full_path'
     *
     * @return string
     */
    public function getFullPathAttribute(): string
    {
        return $this->path . '/' . $this->filename;
    }

    /**
     * Accessor 'url'
     *
     * @return string
     */
    public function getUrlAttribute(): string
    {
        return Storage::url($this->full_path);
    }
}
