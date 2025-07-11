<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Models\Appointment;
use App\Models\Client;
use App\Notifications\AppointmentNotification;
use App\Repositories\Client\ClientRepositoryInterface;
use App\Services\Appointment\AppointmentServiceInterface;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AppointmentController extends Controller
{
    public function __construct(
        private readonly AppointmentServiceInterface $appointmentService,
        private readonly ClientRepositoryInterface   $clientRepository
    )
    {
    }

    public function index(): JsonResponse
    {
        return response()->json([
            'clients' => $this->appointmentService->getAppointmentsByUserId(Auth::id()),
        ]);
    }

    public function store(CreateAppointmentRequest $request): JsonResponse
    {
        $data = $request->validated();
        $userClients = $this->clientRepository->getClientsByUserId(Auth::id());
        if (!in_array($data['client_id'], $userClients->pluck('id')->toArray())) {
            return response()->json([
                'message' => 'Client not found',
            ], 404);
        }

        $appointment = $this->appointmentService->create($data);

        return response()->json([
            'message' => 'Appointment created successfully',
            'appointment' => $appointment,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment): JsonResponse
    {
        $user = Auth::user();
        $client = $this->clientRepository->getClientById($appointment->client_id);

        if (!$client || $client['user_id'] !== $user->id) {
            return response()->json([
                'message' => 'Appointment not found or does not belong to the user',
            ], 404);
        }

        return response()->json([
            'appointment' => $appointment,
            'client' => $client,
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAppointmentRequest $request, Appointment $appointment): JsonResponse
    {
        $updated = $this->appointmentService->update(
            $appointment->id,
            $request->validated()
        );

        return response()->json([
            'message' => 'Appointment updated successfully',
            'appointment' => $updated,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment): JsonResponse
    {
        $this->appointmentService->delete($appointment->id);

        return response()->json([
            'message' => 'Appointment deleted successfully',
        ], 204);
    }

    public function pastAppointments(Request $request, Client $client): JsonResponse
    {
        $user = Auth::user();

        if ($client['user_id'] !== $user->id) {
            return response()->json([
                'message' => 'Client not found or does not belong to the user',
            ], 404);
        }


        $appointments = $this->appointmentService->getPastAppointmentsByUserId($user->id, $client->id);

        return response()->json([
            'appointments' => $appointments,
        ]);
    }

    public function upcomingAppointments(Request $request, Client $client): JsonResponse
    {
        $user = Auth::user();

        if ($client['user_id'] !== $user->id) {
            return response()->json([
                'message' => 'Client not found or does not belong to the user',
            ], 404);
        }

        $appointments = $this->appointmentService->getUpcomingAppointmentsByUserId($user->id, $client->id);

        return response()->json([
            'appointments' => $appointments,
        ]);
    }
}
