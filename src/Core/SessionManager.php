<?php
/**
 * -----------------------------------------------------------------------
 * SOCIAL MEDIA AUTOMATION PANEL - CORE SESSION/COOKIE MANAGER
 * Created by : Mr.Rm19
 * GitHub     : https://github.com/Rm19x
 * -----------------------------------------------------------------------
 */

namespace App\Core;

class SessionManager {
    
    private static $sessionFile = __DIR__ . '/../../config/sessions.json';

    /**
     * Memuat data cookie platform dari file JSON
     */
    public static function getSession($platform) {
        if (!file_exists(self::$sessionFile)) {
            return null;
        }
        $data = json_decode(file_get_contents(self::$sessionFile), true);
        return $data[$platform] ?? null;
    }

    /**
     * Menyimpan data cookie platform ke file JSON
     */
    public static function saveSession($platform, array $cookieData) {
        $data = file_exists(self::$sessionFile) ? json_decode(file_get_contents(self::$sessionFile), true) : [];
        $data[$platform] = $cookieData;
        
        $dir = dirname(self::$sessionFile);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        
        return file_put_contents(self::$sessionFile, json_encode($data, JSON_PRETTY_PRINT)) !== false;
    }

    /**
     * 1. Validasi Sesi X (Twitter)
     * Menguji cookie dengan menembak endpoint kredensial internal web X
     */
    public static function validateX($cookie, $csrfToken) {
        $url = "https://x.com/i/api/1.1/account/verify_credentials.json";
        
        $res = Request::send($url, 'GET', [], [
            "cookie: " . $cookie,
            "x-csrf-token: " . $csrfToken,
            "authorization: Bearer AAAAAAAAAAAAAAAAAAAAANRILgAAAAAAnwIqqSmjYguxC389hjgS2Cwtf7Q%3DOD1gTe9RxHUw9jCnm0gKccgNM3CHmOI0mO79p7g7A"
        ]);

        return ($res['status'] && $res['code'] === 200);
    }

    /**
     * 2. Validasi Sesi Instagram
     * Menguji apakah sessionid masih berlaku melalui endpoint current_user
     */
    public static function validateInstagram($cookie) {
        $url = "https://www.instagram.com/api/v1/accounts/current_user/";
        
        $res = Request::send($url, 'GET', [], [
            "cookie: " . $cookie,
            "X-Requested-With: XMLHttpRequest"
        ]);

        return ($res['status'] && $res['code'] === 200);
    }

    /**
     * 3. Validasi Sesi Facebook
     * Menguji cookie dengan mengakses endpoint profile dasar mbasic Facebook
     */
    public static function validateFacebook($cookie) {
        $url = "https://mbasic.facebook.com/profile.php";
        
        $res = Request::send($url, 'GET', [], [
            "cookie: " . $cookie,
            "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64)"
        ]);

        // Jika cookie mati, FB biasanya me-redirect (302) ke halaman login utama atau memblokir request
        if ($res['status'] && $res['code'] === 200) {
            // Memastikan konten yang kembali bukan form login paksaan
            if (strpos($res['body'], 'id="login_form"') === false && strpos($res['body'], 'name="login"') === false) {
                return true;
            }
        }
        return false;
    }

    /**
     * 4. Validasi Sesi TikTok
     * Menguji sessionid web TikTok melalui API konfigurasi user internal
     */
    public static function validateTikTok($cookie) {
        $url = "https://www.tiktok.com/api/user/detail/";
        
        $res = Request::send($url, 'GET', [], [
            "cookie: " . $cookie,
            "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36"
        ]);

        if ($res['status'] && $res['code'] === 200) {
            $data = json_decode($res['body'], true);
            // Struktur API TikTok mengembalikan status_code 0 jika request sukses dan user login
            if (isset($data['status_code']) && $data['status_code'] === 0) {
                return true;
            }
        }
        return false;
    }
}