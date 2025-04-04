<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="API com Swagger",
 *     description="Documentação da API que consome a Pexels",
 *     @OA\Contact(
 *         email="arc.albert.cruz@gmail.com"
 *     )
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="Authorization",
 *     type="apiKey",
 *     in="header",
 *     name="Authorization",
 *     description="Informe seu token de acesso no cabeçalho. Exemplo: API_BACKEND_TOKEN"
 * )
 */
class PexelsController extends Controller
{
    public function __construct(
        private \App\Services\PexelsVideoServiceInterface $pexelsService
    ) {}

    /**
     * @OA\Get(
     *     path="/api/videos",
     *     summary="Search videos",
     *     description="Return a list of videos from Pexels based on the search term.",
     *     operationId="getVideos",
     *     tags={"Pexels"},
     *     security={{"Authorization":{}}},
     *     @OA\Parameter(
     *         name="query",
     *         in="query",
     *         required=true,
     *         description="search term",
     *         @OA\Schema(type="string", example="nature")
     *     ),
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         required=false,
     *         description="Result per page",
     *         @OA\Schema(type="integer", example=5)
     *     ),
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         required=false,
     *         description="Page number",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Videos retrieved successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="items",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=123456),
     *                     @OA\Property(property="width", type="integer", example=1920),
     *                     @OA\Property(property="height", type="integer", example=1080),
     *                     @OA\Property(property="duration", type="integer", example=15),
     *                     @OA\Property(property="userName", type="string", example="Albert Cruz"),
     *                     @OA\Property(
     *                         property="videoFiles",
     *                         type="array",
     *                         @OA\Items(
     *                             @OA\Property(property="id", type="integer"),
     *                             @OA\Property(property="quality", type="string"),
     *                             @OA\Property(property="file_type", type="string"),
     *                             @OA\Property(property="width", type="integer"),
     *                             @OA\Property(property="height", type="integer"),
     *                             @OA\Property(property="fps", type="double"),
     *                             @OA\Property(property="link", type="string"),
     *                             @OA\Property(property="size", type="integer")
     *                         )
     *                     ),
     *                     @OA\Property(
     *                         property="videoPictures",
     *                         type="array",
     *                         @OA\Items(
     *                             @OA\Property(property="id", type="integer"),
     *                             @OA\Property(property="nr", type="integer"),
     *                             @OA\Property(property="picture", type="string")
     *                         )
     *                     )
     *                 )
     *             ),
     *             @OA\Property(property="page", type="integer", example=1),
     *             @OA\Property(property="per_page", type="integer", example=5),
     *             @OA\Property(property="total_pages", type="integer", example=20)
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=500, description="Internal Server Error")
     * )
     */
    public function __invoke(\App\Http\Requests\SearchVideoRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $result = $this->pexelsService->search($request->validated());
            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
