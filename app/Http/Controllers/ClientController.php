<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Models\Client;
use App\Repositories\Client\ClientRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function __construct(private readonly ClientRepositoryInterface $clientRepository) {}

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'clients' => $this->clientRepository->getClientsByUserId(Auth::id()),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateClientRequest $request): JsonResponse
    {
        $data = $request->validated();
        $client = $this->clientRepository->createClient($data);

        return response()->json([
            'message' => 'Client created successfully',
            'client' => $client,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClientRequest $request, Client $client): JsonResponse
    {
        $data = $request->validated();
        $updatedClient = $this->clientRepository->updateClient($client->id, $data);

        return response()->json([
            'message' => 'Client updated successfully',
            'client' => $updatedClient,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client): JsonResponse
    {
        $this->clientRepository->deleteClient($client->id);

        return response()->json([
            'message' => 'Client deleted successfully',
        ]);
    }
}
