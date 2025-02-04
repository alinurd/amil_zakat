<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Str;
use Infobip\Configuration;
use Infobip\Api\WhatsAppApi;
use Infobip\Model\WhatsAppTextContent;
use Infobip\Model\WhatsAppTextMessage;
use Illuminate\Support\Facades\Http;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getContenByKategori($param)
{
    // Menggunakan Eloquent untuk mengambil konten berdasarkan kategori
    $contents = Content::where('code_kategori', $param)->get();

    return $contents;
}

    public function generateCode($param)
    {
        $ran = Str::random(6);
        $code = $param . "-" . $ran . "-" . date("Y");
        return $code;
    }
    public function generateCodeById($param, $id)
    {
        $ran = Str::random(6);
        $code = $param . "-" . $ran . "-" . date("dmy") . "-000" . $id;
        return $code;
    }
    public function sendMassage1($to, $msg, $code)
    {
        $BASE_URL = 'https://api.nusasms.com/nusasms_api/1.0/whatsapp/media';
        $BASE_TEST_URL = 'https://dev.nusasms.com/nusasms_api/1.0/whatsapp/media';

        $curl = curl_init();

        $media_path = public_path('images/icons/header.jpg');
        // $media_url = url('/public/images/icons/header.jpg');
        $media_url = asset('images/icons/header.jpg');
        $curl = curl_init();

        $payload = json_encode([
            'caption' => $msg,
            // 'queue' => 'YOUR_QUEUE',
            'destination' => $to,
            'media_url' => 'https://zis-alhasanah.com/public/invoice/invoice_'.$code.'.pdf',
            // 'media_url' => 'http://127.0.0.1:8000/public/images/icons/invoice-6.pdf',
            // 'message' => 'Alhamdulillah, telah diterima penunaikan zis/fidyah dari Bapak/ibu:'.$from,
            'include_unsubscribe' => false,
        ]);

        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $BASE_URL,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => [
                "APIKey: 33DF7E9D96A13B5DB75FB01BAB6DE458",
                'Content-Type: application/json'
            ],
            CURLOPT_POSTFIELDS => $payload,
        ]);

        $resp = curl_exec($curl);

        if (!$resp) {
            die('Error: "' . curl_error($curl) . '" - Code: ' . curl_errno($curl));
        } else {
            echo $resp;
        }

        curl_close($curl);

        dd($resp);
    }
    public function sendMassage2($to, $msg, $code)
    {
        $BASE_URL = 'https://api.nusasms.com/nusasms_api/1.0/whatsapp/message';
         
 
        $curl = curl_init();

        $payload = json_encode([ 
            'destination' => $to, 
            'message' => $msg,
            'include_unsubscribe' => false, 
        ]);

        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $BASE_URL,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => [
                "APIKey: 33DF7E9D96A13B5DB75FB01BAB6DE458",
                'Content-Type: application/json'
            ],
            CURLOPT_POSTFIELDS => $payload,
        ]);

        $resp = curl_exec($curl);

        if (!$resp) {
            die('Error: "' . curl_error($curl) . '" - Code: ' . curl_errno($curl));
        } else {
            echo $resp;
        }

        curl_close($curl);

        // dd($resp);
    }
    public function sendMassage($to, $msg)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://app.saungwa.com/api/create-message',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'appkey' => 'a7862033-3af9-47c6-8c85-16d6822b8cad',
                'authkey' => 'CTak6Ul0XiukabnGasbqPCnVzzxs7ThcafHDJZf3S350f7k9Zy',
                'to' => $to,
                'message' => $msg,
                'sandbox' => 'false'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }
    
    protected function sendWax($no, $nama)
    {
        $response = Http::withHeaders([
            'Authorization' => 'App b42be3006183b810feb31c0cc4162822-997e6839-9163-4293-b012-8e9834e6264f',
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->post('https://qymz4m.api.infobip.com/whatsapp/1/message/template', [
            'messages' => [
                [
                    'from' => '447860099299',
                    'to' => $no,
                    'messageId' => '9fefd9d6-781f-4de6-ab86-cb68502110b6',
                    'content' => [
                        'templateName' => 'order_confirmation',
                        'templateData' => [
                            'body' => [
                                'placeholders' => $nama
                            ]
                        ],
                        'language' => 'en'
                    ]
                ]
            ]
        ]);

        if ($response->successful()) {
            echo $response->body();
        } else {
            echo 'Unexpected HTTP status: ' . $response->status() . ' ' . $response->body();
        }
    }

   
}
