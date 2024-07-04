<?php

namespace App\Http\Controllers;

use App\Mail\OrganizationConfirmationMail;
use App\Models\Organization;
use App\Models\Position;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrganizationController extends Controller
{
    public function index()
    {
        $organizations = Organization::where('status_id', '!=', 3)
            ->where('paid_until', '>', Carbon::now())
            ->whereNotNull('paid_until')
            ->get(['id', 'name']);

        return response()->json($organizations);
    }

    public function position($organizationID)
    {
        if (!$organizationID) {
            return response()->json(['error' => 'Invalid organization ID'], 400);
        }

        $occupiedPositionIds = User::where('organization_id', $organizationID)
            ->pluck('position_id')
            ->toArray();

        $availablePositions = Position::whereNotIn('id', $occupiedPositionIds)->get(['id', 'name']);

        return response()->json($availablePositions);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'juridical_address' => 'required|string',
            'postal_address' => 'required|string',
            'inn' => 'required|string',
            'account_number' => 'required|string',
            'bank_account' => 'required|string',
            'bik' => 'required|string',
            'ogrn' => 'required|string',
            'email' => 'required|string|email',
            'phone' => 'required|string',
        ]);

        $organization = Organization::create($data);

        $confirmationUrl = config('app.url') . '/?uuid=' . $organization->confirmation_uuid;
        Mail::to($organization->email)->send(new OrganizationConfirmationMail($organization, $confirmationUrl));

        return response()->json($organization, 201);
    }

    public function show($id)
    {
        return Organization::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'sometimes|required|string',
            'juridical_address' => 'sometimes|required|string',
            'postal_address' => 'sometimes|required|string',
            'inn' => 'sometimes|required|string',
            'account_number' => 'sometimes|required|string',
            'bank_account' => 'sometimes|required|string',
            'bik' => 'sometimes|required|string',
            'ogrn' => 'sometimes|required|string',
            'email' => 'sometimes|required|string|email',
            'phone' => 'sometimes|required|string',
            'status_id' => 'sometimes|required|exists:organization_statuses,id',
            'paid_until' => 'sometimes|nullable|date',
            'confirmed_at' => 'sometimes|nullable|date'
        ]);

        $organization = Organization::findOrFail($id);
        $organization->update($data);

        return response()->json($organization);
    }

    public function destroy($id)
    {
        Organization::findOrFail($id)->delete();

        return response()->json(['message' => 'Organization deleted successfully']);
    }

    public function confirm($uuid)
    {
        $organization = Organization::where('confirmation_uuid', $uuid)->firstOrFail();
        $organization->update(['confirmed_at' => now()]);

        return response()->json(['message' => 'Организация подтверждена']);
    }

    public function setTrialPeriod(Request $request)
    {
        $data = $request->validate([
            'uuid' => 'required|uuid|exists:organizations,confirmation_uuid'
        ]);

        $organization = Organization::where('confirmation_uuid', $data['uuid'])->firstOrFail();

        if (!$organization->paid_until) {
            $organization->update([
                'paid_until' => now()->addDays(14)
            ]);
            return response()->json(['message' => 'Trial period set successfully.']);
        }

        return response()->json(['message' => 'Trial period is already set.']);
    }
}
