<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Services\DocumentService;
use App\Http\Requests\DocumentStoreRequest;

class DocumentController extends Controller
{
    /**
     * @var DocumentService
     */
    private $documentService;

    /**
     * DocumentController constructor.
     * @param DocumentService $documentService
     */
    public function __construct(DocumentService $documentService)
    {
        $this->documentService = $documentService;
    }

    /**
     * Documents
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $documents = $this->documentService->list();

        return response()->json($documents);
    }

    /**
     * Get document
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        $documents = $this->documentService->show($id);

        return response()->json($documents);
    }

    /**
     * Delete document
     *
     * @param DocumentStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(DocumentStoreRequest $request)
    {
        $documents = $this->documentService->store($request->all());

        return response()->json($documents);
    }

    /**
     * Delete document
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        $documents = $this->documentService->destroy($id);

        return response()->json($documents);
    }
}
