<?php

namespace App\Http\Controllers;

use App\Models\ProviderSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProviderScheduleController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'schedules' => 'required|array',
            'schedules.*.day_of_week' => 'required|integer|between:0,6',
            'schedules.*.start_time' => 'required|date_format:H:i',
            'schedules.*.end_time' => 'required|date_format:H:i|after:schedules.*.start_time',
            'schedules.*.is_available' => 'nullable',
        ]);

        $userId = Auth::id();

        foreach ($request->schedules as $schedData) {
            ProviderSchedule::updateOrCreate(
                [
                    'user_id' => $userId,
                    'day_of_week' => $schedData['day_of_week'],
                ],
                [
                    'start_time' => $schedData['start_time'],
                    'end_time' => $schedData['end_time'],
                    'is_available' => isset($schedData['is_available']) ? (bool) $schedData['is_available'] : false,
                ]
            );
        }

        return back()->with('success', 'Jadwal kerja berhasil diperbarui!');
    }
}
