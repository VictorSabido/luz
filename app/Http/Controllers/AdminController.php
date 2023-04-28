<?php

namespace App\Http\Controllers;

use App\Models\Day;
use App\Models\HourlyPrice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function getLightData()
    {
        $days = [Carbon::now()->format('Y-m-d')];
        foreach ($days as $day) {
            $dayInDatabase = $this->getOrCreateDay($day);

            if ($dayInDatabase->hourlyPrices->count() > 0) {
                return;
            }

            $hourlyPrices = $this->getHourlyPrices($dayInDatabase);

            $this->updateHourlyPrices($hourlyPrices, $dayInDatabase);

            Log::info('Day ' . $day . ' Added');
        }
    }

    private function getOrCreateDay($day)
    {
        return Day::firstOrCreate(['day_date' => $day]);
    }

    private function getHourlyPrices($dayInDatabase)
    {
        $ree = new \App\Services\Ree();
        $response = $ree->getPriceByDate($dayInDatabase->day_date);

        return $response['PVPC'];
    }

    private function updateHourlyPrices($hourlyPrices, $dayInDatabase)
    {
        foreach ($hourlyPrices as $hour) {
            $hourInDatabase = HourlyPrice::where('day_id', $dayInDatabase->id)
                                        ->where('hour', substr($hour['Hora'], 0, 2))
                                        ->first();

            if (!$hourInDatabase) {
                HourlyPrice::create([
                    'day_id' => $dayInDatabase->id,
                    'hour' => substr($hour['Hora'], 0, 2),
                    'time_slot' => $hour['Hora'],
                    'pcb' => substr($hour['PCB'], 0, 2) / 100,
                    'cym' => substr($hour['CYM'], 0, 2) / 100,
                ]);
            }
        }
    }

    public function priceByDate(Request $request)
    {
        $date = $request->date;
        if (!$date) {
            abort(404);
        }

        $day = Day::with('hourlyPrices')->where('day_date', $date)->first();
        if (!$day) {
            return response()->json(['error' => 'No data found'], 404);
        }

        $dates = [
            'label' => Carbon::createFromFormat('Y-m-d', $day->day_date)->format('d/m/Y'),
            'prices' => $day->hourlyPrices->pluck('pcb')
        ];

        return response()->json($dates);
    }
}
