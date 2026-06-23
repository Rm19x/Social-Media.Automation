<?php
/**
 * -----------------------------------------------------------------------
 * SOCIAL MEDIA AUTOMATION PANEL - X (TWITTER) COMPLETE 23 FEATURES
 * Created by : Mr.Rm19
 * GitHub     : https://github.com/Rm19x
 * -----------------------------------------------------------------------
 */

namespace App\Features;

use App\Core\SessionManager;
use App\Core\Request;

class XFeatures {
    
    private $cookie;
    private $csrfToken;
    private $authHeader;

    public function __construct() {
        $session = SessionManager::getSession('x_platform'); // cite: uploaded:gemini-code-1782250763364.txt
        if (!$session || empty($session['cookie']) || empty($session['x_csrf_token'])) { // cite: uploaded:gemini-code-1782250763364.txt
            die("❌ Error: Sesi X tidak ditemukan atau tidak aktif. Set cookie dulu!\n"); // cite: uploaded:gemini-code-1782250763364.txt
        } // cite: uploaded:gemini-code-1782250763364.txt
        
        $this->cookie = $session['cookie']; // cite: uploaded:gemini-code-1782250763364.txt
        $this->csrfToken = $session['x_csrf_token']; // cite: uploaded:gemini-code-1782250763364.txt
        $this->authHeader = "Authorization: Bearer AAAAAAAAAAAAAAAAAAAAANRILgAAAAAAnwIqqSmjYguxC389hjgS2Cwtf7Q%3DOD1gTe9RxHUw9jCnm0gKccgNM3CHmOI0mO79p7g7A"; // cite: uploaded:gemini-code-1782250763364.txt
    }

    private function getHeaders() {
        return [
            $this->authHeader, // cite: uploaded:gemini-code-1782250763364.txt
            "Cookie: " . $this->cookie, // cite: uploaded:gemini-code-1782250763364.txt
            "X-Csrf-Token: " . $this->csrfToken, // cite: uploaded:gemini-code-1782250763364.txt
            "Content-Type: application/json", // cite: uploaded:gemini-code-1782250763364.txt
            "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36" // cite: uploaded:gemini-code-1782250763364.txt
        ];
    }

    // ==========================================
    // KELOMPOK AKSI POSTING & INTERAKSI TWEET (1 - 6)
    // ==========================================

    /** 1. Buat Tweet / Post Baru */
    public function createTweet($text) {
        $url = "https://x.com/i/api/graphql/CreateTweet"; // cite: uploaded:gemini-code-1782250763364.txt
        $payload = ['variables' => ['tweet_text' => $text, 'semantic_annotation_ids' => []], 'queryId' => 'CreateTweet']; // cite: uploaded:gemini-code-1782250763364.txt
        $res = Request::send($url, 'POST', json_encode($payload), $this->getHeaders());
        echo ($res['status'] && $res['code'] === 200) ? "✅ Sukses menerbitkan tweet baru!\n" : "❌ Gagal menerbitkan tweet.\n";
    }

    /** 2. Auto Like / Favorite Tweet */
    public function autoLikeTweet($tweetId) {
        $url = "https://x.com/i/api/graphql/lMwFv9w6Rtwa07XgM_Z-gQ/FavoriteTweet"; // cite: uploaded:gemini-code-1782250763364.txt
        $payload = ['variables' => ['tweet_id' => $tweetId], 'queryId' => 'lMwFv9w6Rtwa07XgM_Z-gQ']; // cite: uploaded:gemini-code-1782250763364.txt
        $res = Request::send($url, 'POST', json_encode($payload), $this->getHeaders()); // cite: uploaded:gemini-code-1782250763364.txt
        echo ($res['status'] && $res['code'] === 200) ? "✅ Sukses Like Tweet ID: {$tweetId}\n" : "❌ Gagal Like Tweet\n"; // cite: uploaded:gemini-code-1782250763364.txt
    }

    /** 3. Auto Unlike / Batal Suka Tweet */
    public function autoUnlikeTweet($tweetId) {
        $url = "https://x.com/i/api/graphql/UnfavoriteTweet"; // cite: uploaded:gemini-code-1782250763364.txt
        $payload = ['variables' => ['tweet_id' => $tweetId]]; // cite: uploaded:gemini-code-1782250763364.txt
        $res = Request::send($url, 'POST', json_encode($payload), $this->getHeaders()); // cite: uploaded:gemini-code-1782250763364.txt
        echo ($res['status'] && $res['code'] === 200) ? "✅ Sukses Batalkan Like Tweet ID: {$tweetId}\n" : "❌ Gagal Batalkan Like\n"; // cite: uploaded:gemini-code-1782250763364.txt
    }

    /** 4. Auto Retweet / Share Tweet */
    public function autoRetweet($tweetId) {
        $url = "https://x.com/i/api/graphql/ojm6V6A7Z6Uv3-W8Zz8A_A/CreateRetweet"; // cite: uploaded:gemini-code-1782250763364.txt
        $payload = ['variables' => ['tweet_id' => $tweetId, 'dark_request' => false], 'queryId' => 'ojm6V6A7Z6Uv3-W8Zz8A_A']; // cite: uploaded:gemini-code-1782250763364.txt
        $res = Request::send($url, 'POST', json_encode($payload), $this->getHeaders()); // cite: uploaded:gemini-code-1782250763364.txt
        echo ($res['status'] && $res['code'] === 200) ? "✅ Sukses Retweet Tweet ID: {$tweetId}\n" : "❌ Gagal Retweet\n"; // cite: uploaded:gemini-code-1782250763364.txt
    }

    /** 5. Auto Undo Retweet / Batal Retweet */
    public function autoUndoRetweet($tweetId) {
        $url = "https://x.com/i/api/graphql/DeleteRetweet"; // cite: uploaded:gemini-code-1782250763364.txt
        $payload = ['variables' => ['source_tweet_id' => $tweetId]]; // cite: uploaded:gemini-code-1782250763364.txt
        $res = Request::send($url, 'POST', json_encode($payload), $this->getHeaders()); // cite: uploaded:gemini-code-1782250763364.txt
        echo ($res['status'] && $res['code'] === 200) ? "✅ Sukses Membatalkan Retweet ID: {$tweetId}\n" : "❌ Gagal Batalkan Retweet\n"; // cite: uploaded:gemini-code-1782250763364.txt
    }

    /** 6. Auto Comment / Reply Tweet Target */
    public function autoComment($targetTweetId, $commentText) {
        $url = "https://x.com/i/api/graphql/CreateTweet"; // cite: uploaded:gemini-code-1782250763364.txt
        $payload = ['variables' => ['tweet_text' => $commentText, 'reply' => ['in_reply_to_tweet_id' => $targetTweetId, 'exclude_reply_user_ids' => []], 'semantic_annotation_ids' => []], 'queryId' => 'CreateTweet']; // cite: uploaded:gemini-code-1782250763364.txt
        $res = Request::send($url, 'POST', json_encode($payload), $this->getHeaders()); // cite: uploaded:gemini-code-1782250763364.txt
        echo ($res['status'] && $res['code'] === 200) ? "✅ Komentar Sukses Dikirim!\n" : "❌ Gagal Balas Tweet\n"; // cite: uploaded:gemini-code-1782250763364.txt
    }

    // ==========================================
    // KELOMPOK MANAJEMEN AKUN & RELASI (7 - 14)
    // ==========================================

    /** 7. Mass Follow Pengguna */
    public function massFollow($userId) {
        $url = "https://x.com/i/api/graphql/u7p6ZreD66Zvi_KvVz7v7w/FollowUser"; // cite: uploaded:gemini-code-1782250763364.txt
        $payload = ['variables' => ['userId' => $userId, 'user_id' => $userId], 'queryId' => 'u7p6ZreD66Zvi_KvVz7v7w']; // cite: uploaded:gemini-code-1782250763364.txt
        $res = Request::send($url, 'POST', json_encode($payload), $this->getHeaders()); // cite: uploaded:gemini-code-1782250763364.txt
        echo ($res['status'] && $res['code'] === 200) ? "✅ Berhasil Follow ID: {$userId}\n" : "❌ Gagal Follow ID: {$userId}\n"; // cite: uploaded:gemini-code-1782250763364.txt
    }

    /** 8. Mass Unfollow Pengguna */
    public function massUnfollow($userId) {
        $url = "https://x.com/i/api/graphql/UnfollowUser"; // cite: uploaded:gemini-code-1782250763364.txt
        $payload = ['variables' => ['userId' => $userId], 'queryId' => 'unfollow_user_id_xxx']; // cite: uploaded:gemini-code-1782250763364.txt
        $res = Request::send($url, 'POST', json_encode($payload), $this->getHeaders()); // cite: uploaded:gemini-code-1782250763364.txt
        echo ($res['status'] && $res['code'] === 200) ? "✅ Berhasil Unfollow ID: {$userId}\n" : "❌ Gagal Unfollow ID: {$userId}\n"; // cite: uploaded:gemini-code-1782250763364.txt
    }

    /** 9. Mass Block / Blokir Pengguna */
    public function massBlock($userId) {
        $url = "https://x.com/i/api/graphql/w1v9RL_Wof9Q_7gB8WwAEA/BlockUser"; // cite: uploaded:gemini-code-1782250763364.txt
        $payload = ['variables' => ['userId' => $userId], 'queryId' => 'w1v9RL_Wof9Q_7gB8WwAEA']; // cite: uploaded:gemini-code-1782250763364.txt
        $res = Request::send($url, 'POST', json_encode($payload), $this->getHeaders()); // cite: uploaded:gemini-code-1782250763364.txt
        echo ($res['status'] && $res['code'] === 200) ? "✅ Berhasil Blokir ID: {$userId}\n" : "❌ Gagal Blokir ID: {$userId}\n"; // cite: uploaded:gemini-code-1782250763364.txt
    }

    /** 10. Mass Unblock / Batal Blokir Pengguna */
    public function massUnblock($userId) {
        $url = "https://x.com/i/api/graphql/UnblockUser"; // cite: uploaded:gemini-code-1782250763364.txt
        $payload = ['variables' => ['userId' => $userId]]; // cite: uploaded:gemini-code-1782250763364.txt
        $res = Request::send($url, 'POST', json_encode($payload), $this->getHeaders()); // cite: uploaded:gemini-code-1782250763364.txt
        echo ($res['status'] && $res['code'] === 200) ? "✅ Berhasil Unblock ID: {$userId}\n" : "❌ Gagal Unblock ID: {$userId}\n"; // cite: uploaded:gemini-code-1782250763364.txt
    }

    /** 11. Mute User / Bisukan Pengguna Massal */
    public function muteUser($userId) {
        $url = "https://x.com/i/api/1.1/mutes/users/create.json";
        $payload = ['user_id' => $userId];
        $res = Request::send($url, 'POST', http_build_query($payload), ["Cookie: " . $this->cookie, "X-Csrf-Token: " . $this->csrfToken]);
        echo ($res['status'] && $res['code'] === 200) ? "✅ Berhasil Mute ID: {$userId}\n" : "❌ Gagal Mute Akun\n";
    }

    /** 12. Unmute User / Batal Bisukan Pengguna */
    public function unmuteUser($userId) {
        $url = "https://x.com/i/api/1.1/mutes/users/destroy.json";
        $payload = ['user_id' => $userId];
        $res = Request::send($url, 'POST', http_build_query($payload), ["Cookie: " . $this->cookie, "X-Csrf-Token: " . $this->csrfToken]);
        echo ($res['status'] && $res['code'] === 200) ? "✅ Berhasil Unmute ID: {$userId}\n" : "❌ Gagal Unmute Akun\n";
    }

    /** 13. Hapus Tweet Sendiri Massal */
    public function massDeleteTweets($tweetId) {
        $url = "https://x.com/i/api/graphql/vaY6ww7OmfVw4g7Hw8A/DeleteTweet"; // cite: uploaded:gemini-code-1782250763364.txt
        $payload = ['variables' => ['tweet_id' => $tweetId], 'queryId' => 'vaY6ww7OmfVw4g7Hw8A']; // cite: uploaded:gemini-code-1782250763364.txt
        $res = Request::send($url, 'POST', json_encode($payload), $this->getHeaders()); // cite: uploaded:gemini-code-1782250763364.txt
        echo ($res['status'] && $res['code'] === 200) ? "✅ Tweet ID {$tweetId} Berhasil Dihapus!\n" : "❌ Gagal Hapus Tweet\n"; // cite: uploaded:gemini-code-1782250763364.txt
    }

    /** 14. Kirim DM (Direct Message) Target */
    public function sendDirectMessage($conversationId, $text) {
        $url = "https://x.com/i/api/1.1/dm/new2.json";
        $payload = ['conversation_id' => $conversationId, 'text' => $text, 'cards_platform' => 'Web-12'];
        $res = Request::send($url, 'POST', json_encode($payload), $this->getHeaders());
        echo ($res['status'] && $res['code'] === 200) ? "✅ DM Sukses Dikirim Ke: {$conversationId}\n" : "❌ Gagal Kirim DM\n";
    }

    // ==========================================
    // KELOMPOK FITUR LIST, SCRAPE & MANAGEMENT (15 - 23)
    // ==========================================

    /** 15. Buat List/Daftar Kustom Baru */
    public function createCustomList($name, $description) {
        $url = "https://x.com/i/api/graphql/CreateList";
        $payload = ['variables' => ['name' => $name, 'description' => $description, 'isPrivate' => true]];
        $res = Request::send($url, 'POST', json_encode($payload), $this->getHeaders());
        echo ($res['status'] && $res['code'] === 200) ? "✅ List Kustom '{$name}' Berhasil Dibuat!\n" : "❌ Gagal Buat List\n";
    }

    /** 16. Tambah Anggota Ke List Kustom */
    public function addMemberToList($listId, $userId) {
        $url = "https://x.com/i/api/graphql/AddMemberToList";
        $payload = ['variables' => ['listId' => $listId, 'userId' => $userId]];
        $res = Request::send($url, 'POST', json_encode($payload), $this->getHeaders());
        echo ($res['status'] && $res['code'] === 200) ? "✅ User ID {$userId} Dimasukkan ke List {$listId}\n" : "❌ Gagal Tambah Anggota List\n";
    }

    /** 17. Hapus Anggota Dari List Kustom */
    public function removeMemberFromList($listId, $userId) {
        $url = "https://x.com/i/api/graphql/RemoveMemberFromList";
        $payload = ['variables' => ['listId' => $listId, 'userId' => $userId]];
        $res = Request::send($url, 'POST', json_encode($payload), $this->getHeaders());
        echo ($res['status'] && $res['code'] === 200) ? "✅ User ID {$userId} Dihapus dari List {$listId}\n" : "❌ Gagal Hapus Anggota List\n";
    }

    /** 18. Ganti Nama Profil Sendiri (Update Profile Name) */
    public function updateProfileName($newName) {
        $url = "https://x.com/i/api/1.1/account/update_profile.json";
        $payload = ['name' => $newName];
        $res = Request::send($url, 'POST', http_build_query($payload), ["Cookie: " . $this->cookie, "X-Csrf-Token: " . $this->csrfToken]);
        echo ($res['status'] && $res['code'] === 200) ? "✅ Nama Akun Diubah Menjadi: {$newName}\n" : "❌ Gagal Mengubah Nama Profil\n";
    }

    /** 19. Ganti Deskripsi Bio Profil (Update Bio) */
    public function updateProfileBio($newBio) {
        $url = "https://x.com/i/api/1.1/account/update_profile.json";
        $payload = ['description' => $newBio];
        $res = Request::send($url, 'POST', http_build_query($payload), ["Cookie: " . $this->cookie, "X-Csrf-Token: " . $this->csrfToken]);
        echo ($res['status'] && $res['code'] === 200) ? "✅ Bio Akun Berhasil Diperbarui!\n" : "❌ Gagal Memperbarui Bio\n";
    }

    /** 20. Laporkan Akun/Tweet Target (Report Target) */
    public function reportTarget($tweetId, $reasonType = "spam") {
        $url = "https://x.com/i/api/1.1/report/create.json";
        $payload = ['reported_tweet_id' => $tweetId, 'reason' => $reasonType];
        $res = Request::send($url, 'POST', http_build_query($payload), ["Cookie: " . $this->cookie, "X-Csrf-Token: " . $this->csrfToken]);
        echo ($res['status'] && $res['code'] === 200) ? "✅ Laporan Pelanggaran Tweet ID {$tweetId} Terkirim!\n" : "❌ Gagal Kirim Laporan\n";
    }

    /** 21. Laporkan Spam Pengguna Massal */
    public function reportUserSpam($userId) {
        $url = "https://x.com/i/api/1.1/users/report_spam.json";
        $payload = ['user_id' => $userId];
        $res = Request::send($url, 'POST', http_build_query($payload), ["Cookie: " . $this->cookie, "X-Csrf-Token: " . $this->csrfToken]);
        echo ($res['status'] && $res['code'] === 200) ? "✅ Laporan Akun Spam ID {$userId} Sukses Diadukan!\n" : "❌ Gagal Laporkan Akun\n";
    }

    /** 22. Ambil Informasi Pengguna Kasar (Scrape User Info) */
    public function scrapeUserInfo($screenName) {
        $url = "https://x.com/i/api/graphql/UserByScreenName?variables=" . urlencode(json_encode(['screen_name' => $screenName, 'withSafetyModeUserFields' => true]));
        $res = Request::send($url, 'GET', [], $this->getHeaders());
        if ($res['status'] && $res['code'] === 200) {
            $data = json_decode($res['body'], true);
            $userId = $data['data']['user']['result']['rest_id'] ?? 'Tidak Ditemukan';
            echo "📊 Hasil Scrape @{$screenName} -> Rest ID / ID Numerik: {$userId}\n";
            return $userId;
        }
        echo "❌ Gagal Scrape Info User @{$screenName}\n";
        return null;
    }

    /** 23. Cari Tweet Berdasarkan Kata Kunci (Scrape Search Tweets) */
    public function searchTweets($keyword) {
        $url = "https://x.com/i/api/graphql/SearchTimeline?variables=" . urlencode(json_encode(['rawQuery' => $keyword, 'count' => 5, 'querySource' => 'typed_query']));
        $res = Request::send($url, 'GET', [], $this->getHeaders());
        if ($res['status'] && $res['code'] === 200) {
            echo "✅ Sukses Melakukan Query Pencarian untuk Kata Kunci: '{$keyword}'\n";
            return true;
        }
        echo "❌ Gagal Mencari Tweet\n";
        return false;
    }
}