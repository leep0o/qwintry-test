<?php

namespace App\Observers;

use App\Models\Document;
use Illuminate\Support\Facades\Storage;

class DocumentObserver
{
    /**
     * Handle the post "deleting" event.
     *
     * @param Document $document
     */
    public function deleting(Document $document)
    {
        if ($document->has_file && Storage::disk('public')->exists($document->file->full_path)) {
            Storage::disk('public')->delete($document->file->full_path);
        }
    }
}
