<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function index()
    {
        return Currency::all();
    }

    public function show(Request $request, $date)
    {
        $date = Carbon::parse($date);

        return Currency::whereDate('date', $date)->get();
    }

    public function update()
    {
        $attempts = 3;
        do{
            try {
                $client = new Client();
                $response = $client->get(config('cbr.url'));
                $xml = simplexml_load_string($response->getBody());
                foreach ($xml->Valute as $valute) {
                        $currency = Currency::updateOrCreate([
                            'code' => (string) $valute->CharCode,
                        ], [
                            'date' => (string) $xml->attributes()->Date,
                            'rate' => (float) $valute->Value,
                        ]);
                };

                $attempts = 0;
                \Log::info('Запрос к ЦБР выполнен успешно');
            } catch (Exception $e) {
                $attempts--;
                \Log::error('Ошибка при запросе к ЦБР');
            }
        }while($attempts > 0);

//        return response()->json(['success' => true]);
    }
}
