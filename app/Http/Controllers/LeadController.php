<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class LeadController extends Controller
{
    private $subdomain;

    public function __construct()
    {
        $this->subdomain = config('services.amocrm.subdomain');
    }

    public function index(Request $request)
    {
        $tokens = json_decode(Storage::get('amo_tokens.json'), true);

        $query = [
            'page' => $request->get('page', 1),
            'limit' => $request->get('limit', 10),
            'with' => 'contacts',
        ];

        if ($request->filled('status_id')) {
            $query['filter[statuses][]'] = $request->get('status_id');
        }

        if ($request->filled('updated_at_from')) {
            $query['filter[updated_at][from]'] = strtotime($request->get('updated_at_from'));
        }

        if ($request->filled('updated_at_to')) {
            $query['filter[updated_at][to]'] = strtotime($request->get('updated_at_to'));
        }

        $response = Http::withToken($tokens['access_token'])
            ->get("https://{$this->subdomain}.amocrm.ru/api/v4/leads", $query);

        if (!$response->successful()) {
            return response('Ошибка получения лидов', 500);
        }

        $leads = $response->json()['_embedded']['leads'] ?? [];
        $page = $request->get('page', 1);
        $limit = $request->get('limit', 10);

        return view('leads.index', compact('leads', 'page', 'limit'));
    }
}
