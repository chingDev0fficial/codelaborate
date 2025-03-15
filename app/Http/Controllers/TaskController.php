<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TaskController extends Controller
{
    private $judgeApiUrl = 'https://judge0-ce.p.rapidapi.com';
    private $apiKey = '339ff2dfebmsh0aefef3e53373aep1cbbc4jsnfb7a0e199402'; // Replace with your RapidAPI key

    public function index()
    {
        return view('task');
    }

    public function execute(Request $request)
    {
        $response = Http::withHeaders([
            'X-RapidAPI-Host' => 'judge0-ce.p.rapidapi.com',
            'X-RapidAPI-Key' => $this->apiKey,
            'Content-Type' => 'application/json'
        ])->post($this->judgeApiUrl . '/submissions', [
            'language_id' => $request->language_id,
            'source_code' => base64_encode($request->source_code),
            'stdin' => base64_encode($request->stdin ?? ''),
        ]);

        return response()->json($response->json());
    }

    public function getResult($token)
    {
        $response = Http::withHeaders([
            'X-RapidAPI-Host' => 'judge0-ce.p.rapidapi.com',
            'X-RapidAPI-Key' => $this->apiKey,
        ])->get($this->judgeApiUrl . "/submissions/{$token}");

        return response()->json($response->json());
    }
}
