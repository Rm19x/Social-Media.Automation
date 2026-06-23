<?php
/**
 * -----------------------------------------------------------------------
 * SOCIAL MEDIA AUTOMATION PANEL - INSTAGRAM COMPLETE 23 FEATURES
 * Created by : Mr.Rm19
 * GitHub     : https://github.com/Rm19x
 * -----------------------------------------------------------------------
 */

namespace App\Features;

use App\Core\SessionManager;
use App\Core\Request;

class InstagramFeatures {
    
    private $cookie;
    private $csrfToken;

    public function __construct() {
        $session = SessionManager::getSession('instagram');
        if (!$session || empty($session['cookie'])) {
            die("❌ Error: Sesi Instagram tidak ditemukan atau tidak aktif. Set cookie dulu!\n");
        }
        
        $this->cookie = $session['cookie'];
        $this->csrfToken = $session['x_csrftoken'] ?? 'missing_token';
    }

    private function getHeaders() {
        return [
            "Cookie: " . $this->cookie,
            "X-CSRFToken: " . $this->csrfToken,
            "Content-Type: application/x-www-form-urlencoded",
            "X-Instagram-AJAX: 1",
            "X-Requested-With: XMLHttpRequest",
            "User-Agent: Mozilla/5.0 (iPhone; CPU iPhone OS 14_4 like Mac OS X) AppleWebKit/605.1.15"
        ];
    }

    // ==========================================
    // KELOMPOK FITUR RELASI & FOLLOWER (1 - 6)
    // ==========================================

    /** 1. Mass Follow User */
    public function massFollow($userId) {
        $url = "https://www.instagram.com/api/v1/friendships/create/{$userId}/";
        $res = Request::send($url, 'POST', http_build_query(['container_module' => 'profile']), $this->getHeaders());
        echo ($res['status'] && $res['code'] === 200) ? "✅ Berhasil Follow ID: {$userId}\n" : "❌ Gagal Follow ID: {$userId}\n";
    }

    /** 2. Mass Unfollow User */
    public function massUnfollow($userId) {
        $url = "https://www.instagram.com/api/v1/friendships/destroy/{$userId}/";
        $res = Request::send($url, 'POST', http_build_query(['container_module' => 'profile']), $this->getHeaders());
        echo ($res['status'] && $res['code'] === 200) ? "✅ Berhasil Unfollow ID: {$userId}\n" : "❌ Gagal Unfollow ID: {$userId}\n";
    }

    /** 3. Scrape Daftar Followers Target */
    public function scrapeFollowers($targetUserId) {
        $url = "https://www.instagram.com/api/v1/friendships/{$targetUserId}/followers/?count=20";
        $res = Request::send($url, 'GET', [], $this->getHeaders());
        echo ($res['status'] && $res['code'] === 200) ? "✅ Sukses Ambil Data Followers Target!\n" : "❌ Gagal Scrape Followers\n";
    }

    /** 4. Scrape Daftar Following Target */
    public function scrapeFollowing($targetUserId) {
        $url = "https://www.instagram.com/api/v1/friendships/{$targetUserId}/following/?count=20";
        $res = Request::send($url, 'GET', [], $this->getHeaders());
        echo ($res['status'] && $res['code'] === 200) ? "✅ Sukses Ambil Data Following Target!\n" : "❌ Gagal Scrape Following\n";
    }

    /** 5. Mass Block/Blokir Akun */
    public function massBlock($userId) {
        $url = "https://www.instagram.com/api/v1/friendships/block/{$userId}/";
        $res = Request::send($url, 'POST', [], $this->getHeaders());
        echo ($res['status'] && $res['code'] === 200) ? "✅ Akun ID {$userId} Berhasil Diblokir!\n" : "❌ Gagal Blokir Akun\n";
    }

    /** 6. Mass Unblock/Batal Blokir Akun */
    public function massUnblock($userId) {
        $url = "https://www.instagram.com/api/v1/friendships/unblock/{$userId}/";
        $res = Request::send($url, 'POST', [], $this->getHeaders());
        echo ($res['status'] && $res['code'] === 200) ? "✅ Blokir Akun ID {$userId} Berhasil Dibuka!\n" : "❌ Gagal Unblock Akun\n";
    }

    // ==========================================
    // KELOMPOK FITUR INTERAKSI MEDIA & POST (7 - 12)
    // ==========================================

    /** 7. Auto Comment / Beri Komentar Massal */
    public function autoComment($mediaId, $commentText) {
        $url = "https://www.instagram.com/api/v1/media/{$mediaId}/comment/";
        $payload = ['comment_text' => $commentText, 'container_module' => 'feed_contextual_post'];
        $res = Request::send($url, 'POST', http_build_query($payload), $this->getHeaders());
        echo ($res['status'] && $res['code'] === 200) ? "✅ Komentar Sukses Dikirim ke Media: {$mediaId}\n" : "❌ Gagal Kirim Komentar\n";
    }

    /** 8. Auto Delete Komentar Sendiri */
    public function deleteComment($mediaId, $commentId) {
        $url = "https://www.instagram.com/api/v1/media/{$mediaId}/comment/{$commentId}/delete/";
        $res = Request::send($url, 'POST', [], $this->getHeaders());
        echo ($res['status'] && $res['code'] === 200) ? "✅ Komentar ID {$commentId} Berhasil Dihapus\n" : "❌ Gagal Hapus Komentar\n";
    }

    /** 9. Auto Like / Suka Postingan (Media) */
    public function autoLikeMedia($mediaId) {
        $url = "https://www.instagram.com/api/v1/media/{$mediaId}/like/";
        $res = Request::send($url, 'POST', [], $this->getHeaders());
        echo ($res['status'] && $res['code'] === 200) ? "✅ Sukses Like Postingan ID: {$mediaId}\n" : "❌ Gagal Like Postingan\n";
    }

    /** 10. Auto Unlike / Batal Suka Postingan */
    public function autoUnlikeMedia($mediaId) {
        $url = "https://www.instagram.com/api/v1/media/{$mediaId}/unlike/";
        $res = Request::send($url, 'POST', [], $this->getHeaders());
        echo ($res['status'] && $res['code'] === 200) ? "✅ Sukses Batalkan Like Postingan ID: {$mediaId}\n" : "❌ Gagal Batalkan Like\n";
    }

    /** 11. Auto Save / Bookmark Postingan Ke Koleksi */
    public function saveMedia($mediaId) {
        $url = "https://www.instagram.com/api/v1/media/{$mediaId}/save/";
        $res = Request::send($url, 'POST', [], $this->getHeaders());
        echo ($res['status'] && $res['code'] === 200) ? "✅ Postingan ID {$mediaId} Tersimpan ke Bookmark!\n" : "❌ Gagal Simpan Postingan\n";
    }

    /** 12. Auto Unsave / Hapus dari Bookmark */
    public function unsaveMedia($mediaId) {
        $url = "https://www.instagram.com/api/v1/media/{$mediaId}/unsave/";
        $res = Request::send($url, 'POST', [], $this->getHeaders());
        echo ($res['status'] && $res['code'] === 200) ? "✅ Postingan ID {$mediaId} Dihapus dari Bookmark!\n" : "❌ Gagal Unsave Postingan\n";
    }

    // ==========================================
    // KELOMPOK FITUR DIRECT MESSAGE & STORY (13 - 17)
    // ==========================================

    /** 13. Kirim DM (Direct Message) Teks Ke Target */
    public function sendDirectMessage($targetUserId, $text) {
        $url = "https://www.instagram.com/api/v1/direct_v2/threads/broadcast/text/";
        $payload = ['recipient_users' => "[[$targetUserId]]", 'text' => $text, 'client_context' => bin2hex(random_bytes(16))];
        $res = Request::send($url, 'POST', http_build_query($payload), $this->getHeaders());
        echo ($res['status'] && $res['code'] === 200) ? "✅ DM Teks Berhasil Dikirim ke User: {$targetUserId}\n" : "❌ Gagal Kirim DM Teks\n";
    }

    /** 14. Kirim DM Link/Tautan Massal */
    public function sendDirectLink($targetUserId, $linkUrl, $text = "") {
        $url = "https://www.instagram.com/api/v1/direct_v2/threads/broadcast/link/";
        $payload = ['recipient_users' => "[[$targetUserId]]", 'link_text' => $text, 'link_urls' => "[\"{$linkUrl}\"]", 'client_context' => bin2hex(random_bytes(16))];
        $res = Request::send($url, 'POST', http_build_query($payload), $this->getHeaders());
        echo ($res['status'] && $res['code'] === 200) ? "✅ DM Link Berhasil Dikirim ke User: {$targetUserId}\n" : "❌ Gagal Kirim DM Link\n";
    }

    /** 15. Kirim Reaksi ke Story Orang Lain (Story Reaction) */
    public function reactStory($storyMediaId, $reactionEmoji = "❤️") {
        $url = "https://www.instagram.com/api/v1/media/{$storyMediaId}/story_reaction/";
        $payload = ['reaction_type' => 'emoji', 'emoji' => $reactionEmoji];
        $res = Request::send($url, 'POST', http_build_query($payload), $this->getHeaders());
        echo ($res['status'] && $res['code'] === 200) ? "✅ Sukses Kirim Reaksi '{$reactionEmoji}' Ke Story!\n" : "❌ Gagal Kirim Reaksi Story\n";
    }

    /** 16. Lihat/Tonton Story Target (Mark Story as Seen) */
    public function viewStory($storyMediaId, $takenAt, $userItemSourceId) {
        $url = "https://www.instagram.com/api/v1/stories/media_seen/";
        $payload = ['container_module' => 'feed_timeline', 'reels' => json_encode(["{$userItemSourceId}" => ["{$storyMediaId}_{$takenAt}"]])];
        $res = Request::send($url, 'POST', http_build_query($payload), $this->getHeaders());
        echo ($res['status'] && $res['code'] === 200) ? "✅ Story Terbaca/Dilihat otomatis!\n" : "❌ Gagal Kirim Log View Story\n";
    }

    /** 17. Hapus Postingan/Foto Milik Sendiri */
    public function deleteOwnMedia($mediaId) {
        $url = "https://www.instagram.com/api/v1/media/{$mediaId}/delete/";
        $res = Request::send($url, 'POST', http_build_query(['media_id' => $mediaId]), $this->getHeaders());
        echo ($res['status'] && $res['code'] === 200) ? "✅ Postingan Sendiri ID {$mediaId} Berhasil Dihapus!\n" : "❌ Gagal Hapus Postingan\n";
    }

    // ==========================================
    // KELOMPOK PROFIL, LAPORAN & SCRAPE (18 - 23)
    // ==========================================

    /** 18. Ubah Nama Lengkap Profil (Edit Full Name) */
    public function updateProfileName($fullName) {
        $url = "https://www.instagram.com/api/v1/accounts/edit_profile/";
        $payload = ['first_name' => $fullName];
        $res = Request::send($url, 'POST', http_build_query($payload), $this->getHeaders());
        echo ($res['status'] && $res['code'] === 200) ? "✅ Nama Profil Diperbarui Menjadi: {$fullName}\n" : "❌ Gagal Edit Nama\n";
    }

    /** 19. Ubah Teks Bio Profil (Edit Biography) */
    public function updateProfileBio($biographyText) {
        $url = "https://www.instagram.com/api/v1/accounts/edit_profile/";
        $payload = ['biography' => $biographyText];
        $res = Request::send($url, 'POST', http_build_query($payload), $this->getHeaders());
        echo ($res['status'] && $res['code'] === 200) ? "✅ Bio Akun Sukses Diubah!\n" : "❌ Gagal Edit Bio\n";
    }

    /** 20. Ubah Privasi Akun Jadi Privat (Set Account Private) */
    public function setAccountPrivate() {
        $url = "https://www.instagram.com/api/v1/accounts/set_private/";
        $res = Request::send($url, 'POST', [], $this->getHeaders());
        echo ($res['status'] && $res['code'] === 200) ? "✅ Status Akun Berhasil Diubah ke PRIVAT\n" : "❌ Gagal Mengubah Privasi\n";
    }

    /** 21. Ubah Privasi Akun Jadi Publik (Set Account Public) */
    public function setAccountPublic() {
        $url = "https://www.instagram.com/api/v1/accounts/set_public/";
        $res = Request::send($url, 'POST', [], $this->getHeaders());
        echo ($res['status'] && $res['code'] === 200) ? "✅ Status Akun Berhasil Diubah ke PUBLIK\n" : "❌ Gagal Mengubah Privasi\n";
    }

    /** 22. Scrape Info ID Numerik Akun Berdasarkan Username */
    public function scrapeUserId($username) {
        $url = "https://www.instagram.com/api/v1/users/web_profile_info/?username={$username}";
        $res = Request::send($url, 'GET', [], $this->getHeaders());
        if ($res['status'] && $res['code'] === 200) {
            $data = json_decode($res['body'], true);
            $userId = $data['data']['user']['id'] ?? 'Tidak Ditemukan';
            echo "📊 Hasil Scrape @{$username} -> ID Numerik Instagram: {$userId}\n";
            return $userId;
        }
        echo "❌ Gagal Ambil ID Numerik User @{$username}\n";
        return null;
    }

    /** 23. Laporkan Akun Pelanggaran Target (Mass Report User) */
    public function massReportUser($targetUserId, $reasonId = "1") {
        $url = "https://www.instagram.com/api/v1/users/{$targetUserId}/report/";
        $payload = ['reason_id' => $reasonId, 'source_name' => 'profile'];
        $res = Request::send($url, 'POST', http_build_query($payload), $this->getHeaders());
        echo ($res['status'] && $res['code'] === 200) ? "✅ Aduan Pelanggaran untuk User ID {$targetUserId} Sukses Dikirim!\n" : "❌ Gagal Kirim Laporan Akun\n";
    }
}