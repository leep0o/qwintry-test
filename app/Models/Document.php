<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Document extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'desc',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'has_file',
    ];

    /**
     * Relation with model: File
     *
     * @return HasOne
     */
    public function file(): HasOne
    {
        return $this->hasOne(File::class);
    }

    /**
     * Accessor 'has_file'
     *
     * @return bool
     */
    public function getHasFileAttribute(): bool
    {
        return $this->file && ($this->file->count() > 0);
    }
}
