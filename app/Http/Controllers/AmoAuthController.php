<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class AmoAuthController extends Controller
{
    private $client_id;
    private $client_secret;
    private $redirect_uri;
    private $subdomain;

    public function __construct()
    {
        $this->client_id = config('services.amocrm.client_id');
        $this->client_secret = config('services.amocrm.client_secret');
        $this->redirect_uri = config('services.amocrm.redirect_uri');
        $this->subdomain = config('services.amocrm.subdomain');
    }

    public function redirect()
    {
        $url = "https://{$this->subdomain}.amocrm.ru/oauth?client_id={$this->client_id}&state=random_state&mode=post_message&redirect_uri={$this->redirect_uri}";
        return redirect($url);
    }

    public function callback(Request $request)
    {
        $response = Http::post("https://{$this->subdomain}.amocrm.ru/oauth2/access_token", [
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret,
            'grant_type' => 'authorization_code',
            'code' => $request->code,
            'redirect_uri' => $this->redirect_uri,
        ]);

        if ($response->successful()) {
            Storage::put('amo_tokens.json', $response->body());
            return redirect()->route('leads.index');
        } else {
            return response('Ошибка авторизации', 401);
        }
    }
}
