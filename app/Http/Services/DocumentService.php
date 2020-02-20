<?php

namespace App\Http\Services;

use App\Models\Document;

class DocumentService
{
    /**
     * @var Document
     */
    private $document;

    /**
     * DocumentService constructor.
     * @param Document $document
     */
    public function __construct(Document $document)
    {
        $this->document = $document;
    }

    /**
     * Documents
     *
     * @return Document
     */
    public function list()
    {
        return $this->document
            ->select('id', 'name', 'desc', 'created_at')
            ->get();
    }

    /**
     * Get document
     */
    public function show(int $id)
    {
        return $this->document
            ->with('file')
            ->findOrFail($id);
    }

    /**
     * Delete document
     */
    public function store(array $data)
    {
        if ($data['id']) {
            $document = $this->document->findOrFail($data['id']);
            $document->update($data);
        } else {
            $document = $this->document->create($data);
        }

        if ($data['file']) {
            $file = '';
            $document->file()->save($file);
            $document->save();
        }

        return $document;
    }

    /**
     * Delete document
     *
     * @param int $id
     * @return mixed
     */
    public function destroy(int $id)
    {
        $document = $this->document->findOrFail($id);

        // Storage file delete to model observer

        return $document->delete();
    }
}
