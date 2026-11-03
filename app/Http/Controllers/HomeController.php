<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

class HomeController extends Controller
{
    #[OA\Get(
        path: '/api/',
        summary: 'Default Home',
        tags: ['Home'],
        responses: [
            new OA\Response(response: 200, description: 'Default Home'),
        ],
    )]
    public function index()
    {
        return response()->json([
            'message' => "Bonjour bienvenue sur l'api ATT-STDIO développer par Renaud Fradin https://github.com/Renaudfradin.",
        ], 200);
    }
}
