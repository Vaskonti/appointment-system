<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAppointmentRequest;
use App\Models\Appointment;
use App\Services\Appointment\AppointmentServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function __construct(private readonly AppointmentServiceInterface $appointmentService) {}

    public function index(): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();

        return response()->json([
            'clients' => $this->appointmentService->getAppointmentsByUserId($user->id),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(CreateAppointmentRequest $request): JsonResponse
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appointment $appointment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        //
    }
}
