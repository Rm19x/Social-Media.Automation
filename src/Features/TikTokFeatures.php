<?php
/**
 * -----------------------------------------------------------------------
 * SOCIAL MEDIA AUTOMATION PANEL - TIKTOK COMPLETE 23 FEATURES
 * Created by : Mr.Rm19
 * GitHub     : https://github.com/Rm19x
 * -----------------------------------------------------------------------
 */

namespace App\Features;

use App\Core\SessionManager;
use App\Core\Request;

class TikTokFeatures {
    
    private $cookie;

    public function __construct() {
        $session = SessionManager::getSession('tiktok');
        if (!$session || empty($session['cookie'])) {
            die("❌ Error: Sesi TikTok tidak ditemukan atau tidak aktif. Set cookie dulu!\n");
        }
        $this->cookie = $session['cookie'];
    }

    private function getHeaders() {
        return [
            "Cookie: " . $this->cookie,
            "Content-Type: application/json",
            "Accept: application/json, text/plain, */*",
            "X-Secsdk-Csrf-Token: missing_token_placeholder",
            "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36"
        ];
    }

    // ==========================================
    // KELOMPOK FITUR INTERAKSI VIDEO & COMMENT (1 - 6)
    // ==========================================

    /** 1. Auto Comment / Kirim Komentar ke VT Target */
    public function autoComment($videoId, $commentText) {
        $url = "https://www.tiktok.com/api/comment/publish/";
        $payload = ["aweme_id" => $videoId, "text" => $commentText, "text_extra" => "[]"];
        $res = Request::send($url, 'POST', json_encode($payload), $this->getHeaders());
        echo ($res['status'] && $res['code'] === 200) ? "✅ Sukses kirim komentar ke VT: {$videoId}\n" : "❌ Gagal kirim komentar\n";
    }

    /** 2. Auto Like / Like Massal VT Target */
    public function autoLikeVideo($videoId) {
        $url = "https://www.tiktok.com/api/commit/item/digg/?aweme_id={$videoId}&type=1";
        $res = Request::send($url, 'POST', json_encode([]), $this->getHeaders());
        echo ($res['status'] && $res['code'] === 200) ? "✅ Sukses menyukai VT ID: {$videoId}\n" : "❌ Gagal menyukai VT\n";
    }

    /** 3. Auto Unlike / Batal Suka VT Target */
    public function autoUnlikeVideo($videoId) {
        $url = "https://www.tiktok.com/api/commit/item/digg/?aweme_id={$videoId}&type=2";
        $res = Request::send($url, 'POST', json_encode([]), $this->getHeaders());
        echo ($res['status'] && $res['code'] === 200) ? "✅ Sukses membatalkan suka pada VT ID: {$videoId}\n" : "❌ Gagal membatalkan suka\n";
    }

    /** 4. Auto Favorite / Simpan VT ke Bookmark */
    public function favoriteVideo($videoId) {
        $url = "https://www.tiktok.com/api/item/collect/?aweme_id={$videoId}&action=1";
        $res = Request::send($url, 'POST', json_encode([]), $this->getHeaders());
        echo ($res['status'] && $res['code'] === 200) ? "✅ VT ID {$videoId} Berhasil ditambahkan ke Favorit!\n" : "❌ Gagal favoritkan VT\n";
    }

    /** 5. Auto Unfavorite / Hapus VT dari Favorit */
    public function unfavoriteVideo($videoId) {
        $url = "https://www.tiktok.com/api/item/collect/?aweme_id={$videoId}&action=0";
        $res = Request::send($url, 'POST', json_encode([]), $this->getHeaders());
        echo ($res['status'] && $res['code'] === 200) ? "✅ VT ID {$videoId} Dihapus dari Favorit!\n" : "❌ Gagal unfavoritkan VT\n";
    }

    /** 6. Hapus Komentar Sendiri di VT */
    public function deleteOwnComment($commentId) {
        $url = "https://www.tiktok.com/api/comment/delete/";
        $payload = ["cid" => $commentId];
        $res = Request::send($url, 'POST', json_encode($payload), $this->getHeaders());
        echo ($res['status'] && $res['code'] === 200) ? "✅ Komentar ID {$commentId} Berhasil dihapus!\n" : "❌ Gagal hapus komentar\n";
    }

    // ==========================================
    // KELOMPOK HUBUNGAN PERTEMANAN & USER RELATIONS (7 - 12)
    // ==========================================

    /** 7. Mass Follow User */
    public function massFollow($targetUid) {
        $url = "https://www.tiktok.com/api/commit/follow/user/?type=1&object_id={$targetUid}&channel_id=3";
        $res = Request::send($url, 'POST', json_encode([]), $this->getHeaders());
        echo ($res['status'] && $res['code'] === 200) ? "✅ Berhasil Follow TikTok User ID: {$targetUid}\n" : "❌ Gagal Follow User\n";
    }

    /** 8. Mass Unfollow User */
    public function massUnfollow($targetUid) {
        $url = "https://www.tiktok.com/api/commit/follow/user/?type=0&object_id={$targetUid}&channel_id=3";
        $res = Request::send($url, 'POST', json_encode([]), $this->getHeaders());
        echo ($res['status'] && $res['code'] === 200) ? "✅ Berhasil Unfollow TikTok User ID: {$targetUid}\n" : "❌ Gagal Unfollow User\n";
    }

    /** 9. Mass Block / Blokir Pengguna */
    public function massBlockUser($targetUid) {
        $url = "https://www.tiktok.com/api/user/block/?block_type=1&target_uid={$targetUid}";
        $res = Request::send($url, 'POST', json_encode([]), $this->getHeaders());
        echo ($res['status'] && $res['code'] === 200) ? "✅ Akun TikTok UID {$targetUid} Berhasil diblokir!\n" : "❌ Gagal memblokir akun\n";
    }

    /** 10. Mass Unblock / Batal Blokir Pengguna */
    public function massUnblockUser($targetUid) {
        $url = "https://www.tiktok.com/api/user/block/?block_type=0&target_uid={$targetUid}";
        $res = Request::send($url, 'POST', json_encode([]), $this->getHeaders());
        echo ($res['status'] && $res['code'] === 200) ? "✅ Blokir Akun TikTok UID {$targetUid} Berhasil dibuka!\n" : "❌ Gagal membuka blokir akun\n";
    }

    /** 11. Mass Remove Follower / Depak Pengikut Sendiri */
    public function removeFollower($followerUid) {
        $url = "https://www.tiktok.com/api/user/remove_follower/?follower_uid={$followerUid}";
        $res = Request::send($url, 'POST', json_encode([]), $this->getHeaders());
        echo ($res['status'] && $res['code'] === 200) ? "✅ Sukses menghapus UID {$followerUid} dari daftar pengikutmu\n" : "❌ Gagal menghapus pengikut\n";
    }

    /** 12. Hapus Video Sendiri Massal (Mass Delete Own Videos) */
    public function massDeleteVideos($videoId) {
        $url = "https://www.tiktok.com/api/item/delete/";
        $payload = ["itemId" => $videoId];
        $res = Request::send($url, 'POST', json_encode($payload), $this->getHeaders());
        echo ($res['status'] && $res['code'] === 200) ? "✅ Video ID {$videoId} berhasil dihapus dari akun kamu.\n" : "❌ Gagal hapus Video ID {$videoId}\n";
    }

    // ==========================================
    // KELOMPOK MESSAGES, NOTIFICATION, & LIST (13 - 17)
    // ==========================================

    /** 13. Kirim Pesan Langsung (Direct Message) Target */
    public function sendDirectMessage($conversationId, $textMessage) {
        $url = "https://www.tiktok.com/api/chat/send_msg/";
        $payload = ["conversation_id" => $conversationId, "msg_type" => 1, "content" => json_encode(["text" => $textMessage])];
        $res = Request::send($url, 'POST', json_encode($payload), $this->getHeaders());
        echo ($res['status'] && $res['code'] === 200) ? "✅ DM Sukses terkirim ke Percakapan: {$conversationId}\n" : "❌ Gagal kirim DM\n";
    }

    /** 14. Tandai Semua Notifikasi Terbaca (Clear Notifications Read) */
    public function clearNotificationsRead() {
        $url = "https://www.tiktok.com/api/notice/read/";
        $res = Request::send($url, 'POST', json_encode([]), $this->getHeaders());
        echo ($res['status'] && $res['code'] === 200) ? "✅ Semua notifikasi akun berhasil ditandai telah dibaca.\n" : "❌ Gagal membaca notifikasi\n";
    }

    /** 15. Setujui Permintaan Pengikut Akun Privat */
    public function acceptFollowRequest($userUid) {
        $url = "https://www.tiktok.com/api/user/approve_follower/?approve_uid={$userUid}&action=1";
        $res = Request::send($url, 'POST', json_encode([]), $this->getHeaders());
        echo ($res['status'] && $res['code'] === 200) ? "✅ Permintaan ikuti dari UID {$userUid} Diterima!\n" : "❌ Gagal menerima permintaan ikuti\n";
    }

    /** 16. Tolak Permintaan Pengikut Akun Privat */
    public function rejectFollowRequest($userUid) {
        $url = "https://www.tiktok.com/api/user/approve_follower/?approve_uid={$userUid}&action=0";
        $res = Request::send($url, 'POST', json_encode([]), $this->getHeaders());
        echo ($res['status'] && $res['code'] === 200) ? "✅ Permintaan ikuti dari UID {$userUid} Berhasil ditolak.\n" : "❌ Gagal menolak permintaan ikuti\n";
    }

    /** 17. Sembunyikan Video Tertentu dari Publik (Set Video to Private) */
    public function setVideoPrivate($videoId) {
        $url = "https://www.tiktok.com/api/item/update_visibility/";
        $payload = ["item_id" => $videoId, "visibility" => 3]; // 3 = Private
        $res = Request::send($url, 'POST', json_encode($payload), $this->getHeaders());
        echo ($res['status'] && $res['code'] === 200) ? "✅ Visibilitas VT ID {$videoId} diubah menjadi PRIVAT.\n" : "❌ Gagal mengubah visibilitas VT\n";
    }

    // ==========================================
    // KELOMPOK PENGATURAN PROFIL & SCRAPE DATA (18 - 23)
    // ==========================================

    /** 18. Ubah Nama Panggilan Profil (Update Profile Nickname) */
    public function updateProfileNickname($newNickname) {
        $url = "https://www.tiktok.com/api/user/update/?type=nickname";
        $payload = ["nickname" => $newNickname];
        $res = Request::send($url, 'POST', json_encode($payload), $this->getHeaders());
        echo ($res['status'] && $res['code'] === 200) ? "✅ Nickname akun berhasil diganti menjadi: {$newNickname}\n" : "❌ Gagal mengganti nickname\n";
    }

    /** 19. Ubah Bio Deskripsi Profil (Update Signature Bio) */
    public function updateProfileBio($newBio) {
        $url = "https://www.tiktok.com/api/user/update/?type=signature";
        $payload = ["signature" => $newBio];
        $res = Request::send($url, 'POST', json_encode($payload), $this->getHeaders());
        echo ($res['status'] && $res['code'] === 200) ? "✅ Teks Bio akun berhasil diperbarui!\n" : "❌ Gagal mengubah bio profil\n";
    }

    /** 20. Laporkan Akun/VT Pelanggaran Target (Mass Report) */
    public function massReportTarget($targetId, $reportType = "item") {
        $url = "https://www.tiktok.com/api/report/action/?object_id={$targetId}&report_type={$reportType}";
        $res = Request::send($url, 'POST', json_encode([]), $this->getHeaders());
        echo ($res['status'] && $res['code'] === 200) ? "✅ Pengaduan laporan pelanggaran untuk ID {$targetId} terkirim!\n" : "❌ Gagal kirim laporan\n";
    }

    /** 21. Scrape Info Detail Daftar Pengikut (Follower List Data) */
    public function scrapeFollowerListData($userUid) {
        $url = "https://www.tiktok.com/api/user/list/?type=1&user_id={$userUid}&count=20";
        $res = Request::send($url, 'GET', [], $this->getHeaders());
        echo ($res['status'] && $res['code'] === 200) ? "✅ Sukses ambil antrean data pengikut untuk UID: {$userUid}\n" : "❌ Gagal scrape list pengikut\n";
    }

    /** 22. Scrape Info Detail Daftar Mengikuti (Following List Data) */
    public function scrapeFollowingListData($userUid) {
        $url = "https://www.tiktok.com/api/user/list/?type=2&user_id={$userUid}&count=20";
        $res = Request::send($url, 'GET', [], $this->getHeaders());
        echo ($res['status'] && $res['code'] === 200) ? "✅ Sukses ambil antrean data mengikuti untuk UID: {$userUid}\n" : "❌ Gagal scrape list mengikuti\n";
    }

    /** 23. Scrape UID Numerik Akun Berdasarkan Unique Username */
    public function scrapeUserUid($username) {
        $url = "https://www.tiktok.com/api/user/detail/?unique_id={$username}";
        $res = Request::send($url, 'GET', [], $this->getHeaders());
        if ($res['status'] && $res['code'] === 200) {
            $data = json_decode($res['body'], true);
            $uid = $data['userInfo']['user']['id'] ?? 'Tidak Ditemukan';
            echo "📊 Hasil Scrape @{$username} -> UID Numerik TikTok: {$uid}\n";
            return $uid;
        }
        echo "❌ Gagal mengambil data UID untuk username @{$username}\n";
        return null;
    }
}