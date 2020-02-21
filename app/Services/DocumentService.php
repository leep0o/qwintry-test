<?php

namespace App\Services;

use App\Models\File;
use App\Models\Document;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Collection;
use App\Exceptions\DocumentNotFoundException;

class DocumentService
{
    /**
     * @var Document
     */
    private $document;

    /**
     * @var File
     */
    private $file;

    /**
     * DocumentService constructor.
     * @param Document $document
     */
    public function __construct(Document $document, File $file)
    {
        $this->document = $document;
        $this->file = $file;
    }

    /**
     * Documents
     *
     * @return Collection
     */
    public function list(): Collection
    {
        return $this->document
            ->select('id', 'name', 'desc', 'created_at')
            ->get();
    }

    /**
     * Get document
     *
     * @param int $id
     * @return Document
     * @throws DocumentNotFoundException
     */
    public function show(int $id): Document
    {
        $document = $this->document
            ->select('id', 'name', 'desc', 'created_at')
            ->with('file')
            ->find($id);

        if (!$document) {
            throw new DocumentNotFoundException('Document not found, id:  ' . $id);
        }

        return $document;
    }

    /**
     * Store document
     *
     * @param array $data
     * @return Document
     * @throws \Exception
     */
    public function store(array $data): Document
    {
//        DB::beginTransaction();

        if (isset($data['id']) && $data['id']) {
            $document = $this->document->findOrFail($data['id']);
            $document->update($data);
        } else {
            $document = $this->document->create($data);
        }

//        DB::commit();

        if (isset($data['image'])) {
            $storedFile = $this->storeFile($data['image'], $document);
            $newFile = $this->file->create($storedFile);

            $document->file()->save($newFile);
            $document->save();
        }

        return $document;
    }

    /**
     * Delete document
     *
     * @param int $id
     * @return bool
     */
    public function destroy(int $id): bool
    {
        $document = $this->document->findOrFail($id);

        return $document->delete();
    }

    /**
     * Store file
     *
     * @param $file
     * @param $document
     * @return array
     */
    public function storeFile($file, $document): array
    {
        if ($document->has_file && Storage::disk('public')->exists($document->file->full_path)) {
            Storage::disk('public')->delete($document->file->full_path);
        }

        $size = filesize($file);
        $path = '/images/documents';
        $name = time() . '.' . $file->getClientOriginalExtension();

        Storage::disk('public')->putFileAs($path, $file, $name);

        return [
            'filename' => $name,
            'path' => $path,
            'size' => $size,
        ];
    }
}
