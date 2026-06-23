<?php
/**
 * -----------------------------------------------------------------------
 * SOCIAL MEDIA AUTOMATION PANEL - CORE HTTP REQUEST DRIVER
 * Created by : Mr.Rm19
 * GitHub     : https://github.com/Rm19x
 * -----------------------------------------------------------------------
 */

namespace App\Core;

class Request {
    
    /**
     * Mengirim HTTP Request menggunakan cURL murni
     */
    public static function send($url, $method = 'POST', $payload = [], $headers = []) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Menghindari isu SSL pada beberapa OS
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $method = strtoupper($method);
        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            if (is_array($payload)) {
                // Jika payload berstruktur JSON, di-encode di level pemanggilan fitur
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
            } else {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
            }
        } elseif ($method === 'DELETE' || $method === 'PUT') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
            if (!empty($payload)) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, is_array($payload) ? http_build_query($payload) : $payload);
            }
        }

        // Menyisipkan User-Agent standar jika tidak didefinisikan secara spesifik oleh fitur
        $hasUserAgent = false;
        foreach ($headers as $header) {
            if (stripos($header, 'User-Agent:') === 0) {
                $hasUserAgent = true;
                break;
            }
        }
        if (!$hasUserAgent) {
            $headers[] = "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36";
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error    = curl_error($ch);
        curl_close($ch);

        if ($error) {
            return [
                'status'  => false,
                'code'    => $httpCode,
                'message' => $error,
                'body'    => null
            ];
        }

        return [
            'status'  => true,
            'code'    => $httpCode,
            'message' => 'OK',
            'body'    => $response
        ];
    }
}
