<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\DocumentService;
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
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json($this->documentService->list());
    }

    /**
     * Get document
     *
     * @param int $id
     * @return JsonResponse
     * @throws \App\Exceptions\DocumentNotFoundException
     */
    public function show(int $id): JsonResponse
    {
        return response()->json($this->documentService->show($id));
    }

    /**
     * Delete document
     */
    public function store(DocumentStoreRequest $request)
    {
        return response()->json($this->documentService->store($request->all()));
    }

    /**
     * Delete document
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        return response()->json($this->documentService->destroy($id));
    }
}
