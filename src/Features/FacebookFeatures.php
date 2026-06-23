<?php
/**
 * -----------------------------------------------------------------------
 * SOCIAL MEDIA AUTOMATION PANEL - FACEBOOK COMPLETE 23 FEATURES
 * Created by : Mr.Rm19
 * GitHub     : https://github.com/Rm19x
 * -----------------------------------------------------------------------
 */

namespace App\Features;

use App\Core\SessionManager;
use App\Core\Request;

class FacebookFeatures {
    
    private $cookie;
    private $fbDtsg;

    public function __construct() {
        $session = SessionManager::getSession('facebook'); // cite: uploaded:FacebookFeatures.php
        if (!$session || empty($session['cookie']) || empty($session['fb_dtsg'])) { // cite: uploaded:FacebookFeatures.php
            die("❌ Error: Sesi Facebook tidak aktif. Set cookie dulu!\n"); // cite: uploaded:FacebookFeatures.php
        } // cite: uploaded:FacebookFeatures.php
        $this->cookie = $session['cookie']; // cite: uploaded:FacebookFeatures.php
        $this->fbDtsg = $session['fb_dtsg']; // cite: uploaded:FacebookFeatures.php
    }

    private function getHeaders() {
        return [
            "Cookie: " . $this->cookie, // cite: uploaded:FacebookFeatures.php
            "Content-Type: application/x-www-form-urlencoded", // cite: uploaded:FacebookFeatures.php
            "User-Agent: Mozilla/5.0 (Linux; Android 10; SM-G960F) AppleWebKit/537.36" // cite: uploaded:FacebookFeatures.php
        ];
    }

    // ==========================================
    // KELOMPOK FITUR GRUP (FITUR 1 - 5)
    // ==========================================

    /** 1. Auto Post Ke Banyak Grup */
    public function autoPostGroup($groupId, $message) {
        $url = "https://mbasic.facebook.com/composer/send/?target={$groupId}"; // cite: uploaded:FacebookFeatures.php
        $payload = ['fb_dtsg' => $this->fbDtsg, 'xcst' => '1', 'view_post' => 'Post', 'status' => $message]; // cite: uploaded:FacebookFeatures.php
        $res = Request::send($url, 'POST', http_build_query($payload), $this->getHeaders()); // cite: uploaded:FacebookFeatures.php
        echo ($res['status'] && in_array($res['code'], [200, 302])) ? "✅ Sukses Post Group ID: {$groupId}\n" : "❌ Gagal Post Group ID: {$groupId}\n";
    }

    /** 2. Keluar Grup Massal */
    public function massLeaveGroup($groupId) {
        $url = "https://mbasic.facebook.com/group/leave/?gfid={$groupId}"; // cite: uploaded:FacebookFeatures.php
        $payload = ['fb_dtsg' => $this->fbDtsg, 'confirm' => 'Leave Group']; // cite: uploaded:FacebookFeatures.php
        $res = Request::send($url, 'POST', http_build_query($payload), $this->getHeaders()); // cite: uploaded:FacebookFeatures.php
        echo ($res['status'] && in_array($res['code'], [200, 302])) ? "✅ Berhasil Keluar Grup: {$groupId}\n" : "❌ Gagal Keluar Grup\n";
    }

    /** 3. Gabung Grup Massal via ID */
    public function massJoinGroup($groupId) {
        $url = "https://mbasic.facebook.com/a/group/join/?group_id={$groupId}";
        $payload = ['fb_dtsg' => $this->fbDtsg];
        $res = Request::send($url, 'POST', http_build_query($payload), $this->getHeaders());
        echo ($res['status'] && in_array($res['code'], [200, 302])) ? "✅ Permintaan Gabung Grup {$groupId} Dikirim\n" : "❌ Gagal Gabung Grup\n";
    }

    /** 4. Auto Post Komentar Massal di Postingan Grup */
    public function autoCommentGroupPost($postId, $commentText) {
        $url = "https://mbasic.facebook.com/a/comment.php?id={$postId}";
        $payload = ['fb_dtsg' => $this->fbDtsg, 'comment_text' => $commentText];
        $res = Request::send($url, 'POST', http_build_query($payload), $this->getHeaders());
        echo ($res['status'] && in_array($res['code'], [200, 302])) ? "✅ Sukses Komen di Post Grup: {$postId}\n" : "❌ Gagal Komen\n";
    }

    /** 5. Auto Like Massal Postingan Grup */
    public function autoLikeGroupPost($postId) {
        $url = "https://mbasic.facebook.com/a/like.php?ft_ent_id={$postId}";
        $payload = ['fb_dtsg' => $this->fbDtsg];
        $res = Request::send($url, 'POST', http_build_query($payload), $this->getHeaders());
        echo ($res['status'] && in_array($res['code'], [200, 302])) ? "✅ Sukses Like Post Grup: {$postId}\n" : "❌ Gagal Like\n";
    }

    // ==========================================
    // KELOMPOK FITUR TEMAN & REQUEST (FITUR 6 - 11)
    // ==========================================

    /** 6. Terima Permintaan Pertemanan */
    public function acceptFriendRequest($senderId) {
        $url = "https://mbasic.facebook.com/a/friends/friend/?confirm={$senderId}"; // cite: uploaded:FacebookFeatures.php
        $payload = ['fb_dtsg' => $this->fbDtsg]; // cite: uploaded:FacebookFeatures.php
        $res = Request::send($url, 'POST', http_build_query($payload), $this->getHeaders()); // cite: uploaded:FacebookFeatures.php
        echo ($res['status'] && in_array($res['code'], [200, 302])) ? "✅ Teman Diterima ID: {$senderId}\n" : "❌ Gagal Terima\n";
    }

    /** 7. Tolak Permintaan Pertemanan */
    public function rejectFriendRequest($senderId) {
        $url = "https://mbasic.facebook.com/a/friends/friend/?delete={$senderId}"; // cite: uploaded:FacebookFeatures.php
        $payload = ['fb_dtsg' => $this->fbDtsg]; // cite: uploaded:FacebookFeatures.php
        $res = Request::send($url, 'POST', http_build_query($payload), $this->getHeaders()); // cite: uploaded:FacebookFeatures.php
        echo ($res['status'] && in_array($res['code'], [200, 302])) ? "✅ Teman Ditolak ID: {$senderId}\n" : "❌ Gagal Tolak\n";
    }

    /** 8. Batalkan Permintaan Pertemanan Keluar */
    public function cancelSentRequest($targetUserId) {
        $url = "https://mbasic.facebook.com/a/friendrequest/cancel/?list=friend_requests_sent&id={$targetUserId}"; // cite: uploaded:FacebookFeatures.php
        $payload = ['fb_dtsg' => $this->fbDtsg]; // cite: uploaded:FacebookFeatures.php
        $res = Request::send($url, 'POST', http_build_query($payload), $this->getHeaders()); // cite: uploaded:FacebookFeatures.php
        echo ($res['status'] && in_array($res['code'], [200, 302])) ? "✅ Request Dibatalkan Ke ID: {$targetUserId}\n" : "❌ Gagal Batalkan\n";
    }

    /** 9. Unfriend Massal */
    public function massUnfriend($targetUserId) {
        $url = "https://mbasic.facebook.com/a/friends/friend/?unfriend={$targetUserId}";
        $payload = ['fb_dtsg' => $this->fbDtsg];
        $res = Request::send($url, 'POST', http_build_query($payload), $this->getHeaders());
        echo ($res['status'] && in_array($res['code'], [200, 302])) ? "✅ Unfriend Sukses ID: {$targetUserId}\n" : "❌ Gagal Unfriend\n";
    }

    /** 10. Add Friend / Tambah Teman Massal Target */
    public function massAddFriend($targetUserId) {
        $url = "https://mbasic.facebook.com/a/friends/add/?subject_id={$targetUserId}";
        $payload = ['fb_dtsg' => $this->fbDtsg];
        $res = Request::send($url, 'POST', http_build_query($payload), $this->getHeaders());
        echo ($res['status'] && in_array($res['code'], [200, 302])) ? "✅ Add Friend Dikirim Ke ID: {$targetUserId}\n" : "❌ Gagal Add Friend\n";
    }

    /** 11. Colek (Poke) Teman Massal */
    public function massPoke($targetUserId) {
        $url = "https://mbasic.facebook.com/pokes/inline/?pokee={$targetUserId}";
        $payload = ['fb_dtsg' => $this->fbDtsg, 'poke_target' => $targetUserId];
        $res = Request::send($url, 'POST', http_build_query($payload), $this->getHeaders());
        echo ($res['status'] && in_array($res['code'], [200, 302])) ? "✅ Berhasil Colek ID: {$targetUserId}\n" : "❌ Gagal Colek\n";
    }

    // ==========================================
    // KELOMPOK FITUR INTERAKSI & TIMELINE (FITUR 12 - 17)
    // ==========================================

    /** 12. Auto Post Status Ke Timeline Sendiri */
    public function autoPostStatus($message) {
        $url = "https://mbasic.facebook.com/composer/send/?privacyx=291667064279714"; // Privacy: Publik
        $payload = ['fb_dtsg' => $this->fbDtsg, 'status' => $message];
        $res = Request::send($url, 'POST', http_build_query($payload), $this->getHeaders());
        echo ($res['status'] && in_array($res['code'], [200, 302])) ? "✅ Berhasil Terbit Status Baru\n" : "❌ Gagal Terbit Status\n";
    }

    /** 13. Auto Like Postingan Timeline Target */
    public function autoLikePost($postId) {
        $url = "https://mbasic.facebook.com/a/like.php?ft_ent_id={$postId}";
        $payload = ['fb_dtsg' => $this->fbDtsg];
        $res = Request::send($url, 'POST', http_build_query($payload), $this->getHeaders());
        echo ($res['status'] && in_array($res['code'], [200, 302])) ? "✅ Berhasil Like Post ID: {$postId}\n" : "❌ Gagal Like Post\n";
    }

    /** 14. Auto Comment Postingan Timeline Target */
    public function autoCommentPost($postId, $commentText) {
        $url = "https://mbasic.facebook.com/a/comment.php?id={$postId}";
        $payload = ['fb_dtsg' => $this->fbDtsg, 'comment_text' => $commentText];
        $res = Request::send($url, 'POST', http_build_query($payload), $this->getHeaders());
        echo ($res['status'] && in_array($res['code'], [200, 302])) ? "✅ Komentar Terkirim di Post ID: {$postId}\n" : "❌ Gagal Komen\n";
    }

    /** 15. Auto Delete Postingan Sendiri */
    public function deleteOwnPost($postId) {
        $url = "https://mbasic.facebook.com/nux/content/delete/?id={$postId}";
        $payload = ['fb_dtsg' => $this->fbDtsg, 'confirm' => 'Delete'];
        $res = Request::send($url, 'POST', http_build_query($payload), $this->getHeaders());
        echo ($res['status'] && in_array($res['code'], [200, 302])) ? "✅ Postingan ID {$postId} Berhasil Dihapus\n" : "❌ Gagal Hapus Postingan\n";
    }

    /** 16. Blokir Pengguna Massal */
    public function massBlock($targetUserId) {
        $url = "https://mbasic.facebook.com/privacy/touch/block/confirm/?bid={$targetUserId}";
        $payload = ['fb_dtsg' => $this->fbDtsg, 'confirmed' => 'Block'];
        $res = Request::send($url, 'POST', http_build_query($payload), $this->getHeaders());
        echo ($res['status'] && in_array($res['code'], [200, 302])) ? "✅ Berhasil Blokir ID: {$targetUserId}\n" : "❌ Gagal Blokir\n";
    }

    /** 17. Unblock Pengguna Massal */
    public function massUnblock($targetUserId) {
        $url = "https://mbasic.facebook.com/privacy/touch/unblock/confirm/?bid={$targetUserId}";
        $payload = ['fb_dtsg' => $this->fbDtsg, 'confirmed' => 'Unblock'];
        $res = Request::send($url, 'POST', http_build_query($payload), $this->getHeaders());
        echo ($res['status'] && in_array($res['code'], [200, 302])) ? "✅ Berhasil Unblock ID: {$targetUserId}\n" : "❌ Gagal Unblock\n";
    }

    // ==========================================
    // KELOMPOK FITUR PAGES, MESSAGES, & SCRAPE (FITUR 18 - 23)
    // ==========================================

    /** 18. Auto Like Fanspage (Halaman FB) */
    public function autoLikePage($pageId) {
        $url = "https://mbasic.facebook.com/a/profile/like/page/?page_id={$pageId}";
        $payload = ['fb_dtsg' => $this->fbDtsg];
        $res = Request::send($url, 'POST', http_build_query($payload), $this->getHeaders());
        echo ($res['status'] && in_array($res['code'], [200, 302])) ? "✅ Berhasil Menyukai Halaman ID: {$pageId}\n" : "❌ Gagal Like Halaman\n";
    }

    /** 19. Auto Unlike Fanspage */
    public function autoUnlikePage($pageId) {
        $url = "https://mbasic.facebook.com/a/profile/unlike/page/?page_id={$pageId}";
        $payload = ['fb_dtsg' => $this->fbDtsg];
        $res = Request::send($url, 'POST', http_build_query($payload), $this->getHeaders());
        echo ($res['status'] && in_array($res['code'], [200, 302])) ? "✅ Berhasil Batal Menyukai Halaman ID: {$pageId}\n" : "❌ Gagal Unlike Halaman\n";
    }

    /** 20. Kirim Pesan Inbox (PM) Massal Target */
    public function sendDirectMessage($targetUserId, $message) {
        $url = "https://mbasic.facebook.com/messages/send/?icm=1";
        $payload = [
            'fb_dtsg' => $this->fbDtsg,
            'body' => $message,
            'ids[' . $targetUserId . ']' => $targetUserId,
            'send' => 'Send'
        ];
        $res = Request::send($url, 'POST', http_build_query($payload), $this->getHeaders());
        echo ($res['status'] && in_array($res['code'], [200, 302])) ? "✅ Pesan Sukses Terkirim Ke ID: {$targetUserId}\n" : "❌ Gagal Kirim Pesan\n";
    }

    /** 21. Scrape Info Profil Target (Mengambil Nama & Bio Kasar) */
    public function scrapeProfileInfo($targetUserId) {
        $url = "https://mbasic.facebook.com/profile.php?id={$targetUserId}";
        $res = Request::send($url, 'GET', [], $this->getHeaders());
        if ($res['status'] && $res['code'] === 200) {
            preg_match('/<title>(.*?)<\/title>/', $res['body'], $matches);
            $name = $matches[1] ?? 'Tidak Ditemukan';
            echo "📊 Hasil Scrape ID {$targetUserId} -> Nama Akun: {$name}\n";
            return true;
        }
        echo "❌ Gagal Scrape Data Profil\n";
        return false;
    }

    /** 22. Laporkan Akun Target (Mass Report Target) */
    public function massReportAccount($targetUserId) {
        $url = "https://mbasic.facebook.com/rapid_report/submit/?target={$targetUserId}";
        $payload = ['fb_dtsg' => $this->fbDtsg, 'action' => 'report_profile', 'confirmed' => 'Submit'];
        $res = Request::send($url, 'POST', http_build_query($payload), $this->getHeaders());
        echo ($res['status'] && in_array($res['code'], [200, 302])) ? "✅ Laporan Pelanggaran Akun ID {$targetUserId} Berhasil Dikirim\n" : "❌ Gagal Mengirim Laporan\n";
    }

    /** 23. Berbagi Postingan Orang Lain Ke Kronologi Sendiri (Auto Share) */
    public function autoSharePost($postId) {
        $url = "https://mbasic.facebook.com/sharer.php?id={$postId}";
        $payload = ['fb_dtsg' => $this->fbDtsg, 'shared_from' => 'mbasic', 'submit' => 'Share'];
        $res = Request::send($url, 'POST', http_build_query($payload), $this->getHeaders());
        echo ($res['status'] && in_array($res['code'], [200, 302])) ? "✅ Post ID {$postId} Berhasil Di-Share Ke Timeline Kamu!\n" : "❌ Gagal Share Post\n";
    }
}
