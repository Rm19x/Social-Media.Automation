<?php
/**
 * -----------------------------------------------------------------------
 * SOCIAL MEDIA AUTOMATION PANEL - CLI INTERFACE ENTRYPOINT
 * Created by : Mr.Rm19
 * GitHub     : https://github.com/Rm19x
 * -----------------------------------------------------------------------
 */

require_once __DIR__ . '/vendor/autoload.php';

use App\Core\SessionManager;
use App\Features\XFeatures;
use App\Features\InstagramFeatures;
use App\Features\FacebookFeatures;
use App\Features\TikTokFeatures;

function tampilkanHeader() {
    echo "===================================================\n";
    echo "              SOCIAL MEDIA AUTOMATION PANEL\n";
    echo "              Created by: Mr.Rm19\n";
    echo "              GitHub: github.com/Rm19x\n";
    echo "===================================================\n";
}

while (true) {
    tampilkanHeader();
    echo "Pilih Menu Pengelolaan Sesi atau Fitur:\n";
    echo "1. Kelola Sesi / Cookie Akun (4 Platform)\n";
    echo "2. Jalankan Otomasi X (Twitter)\n";
    echo "3. Jalankan Otomasi Instagram\n";
    echo "4. Jalankan Otomasi Facebook\n";
    echo "5. Jalankan Otomasi TikTok\n";
    echo "0. Keluar Aplikasi\n";
    echo "---------------------------------------------------\n";
    echo "Pilih Menu [0-5]: ";
    $menuUtama = trim(fgets(STDIN));

    if ($menuUtama === '0') {
        echo "Keluar dari aplikasi. Terima kasih Mr.Rm19!\n";
        break;
    }

    switch ($menuUtama) {
        case '1':
            // === KELOLA SESI / COOKIE ===
            echo "\n--- KELOLA SESI LOGIN ---\n";
            echo "1. Set & Validasi Cookie X\n";
            echo "2. Set & Validasi Cookie Instagram\n";
            echo "3. Set & Validasi Cookie Facebook\n";
            echo "4. Set & Validasi Cookie TikTok\n";
            echo "Pilih Platform [1-4]: ";
            $pilihanSesi = trim(fgets(STDIN));

            if ($pilihanSesi === '1') {
                echo "Masukkan Cookie X: ";
                $cookie = trim(fgets(STDIN));
                echo "Masukkan X-CSRF-Token: ";
                $csrf = trim(fgets(STDIN));
                echo "🔄 Memvalidasi sesi ke server X...\n";
                if (SessionManager::validateX($cookie, $csrf)) {
                    SessionManager::saveSession('x_platform', ['cookie' => $cookie, 'x_csrf_token' => $csrf]);
                    echo "✅ Sesi X valid dan berhasil disimpan!\n";
                } else {
                    echo "❌ Validasi gagal! Cookie atau Token tidak aktif.\n";
                }
            } elseif ($pilihanSesi === '2') {
                echo "Masukkan Cookie Instagram: ";
                $cookie = trim(fgets(STDIN));
                echo "Masukkan X-CSRFToken: ";
                $csrf = trim(fgets(STDIN));
                echo "🔄 Memvalidasi sesi ke server Instagram...\n";
                if (SessionManager::validateInstagram($cookie)) {
                    SessionManager::saveSession('instagram', ['cookie' => $cookie, 'x_csrftoken' => $csrf]);
                    echo "✅ Sesi Instagram valid dan berhasil disimpan!\n";
                } else {
                    echo "❌ Validasi gagal! Periksa sessionid kamu.\n";
                }
            } elseif ($pilihanSesi === '3') {
                echo "Masukkan Cookie Facebook: ";
                $cookie = trim(fgets(STDIN));
                echo "Masukkan Token fb_dtsg: ";
                $fbDtsg = trim(fgets(STDIN));
                echo "🔄 Memvalidasi sesi ke mbasic Facebook...\n";
                if (SessionManager::validateFacebook($cookie)) {
                    SessionManager::saveSession('facebook', ['cookie' => $cookie, 'fb_dtsg' => $fbDtsg]);
                    echo "✅ Sesi Facebook valid dan berhasil disimpan!\n";
                } else {
                    echo "❌ Validasi gagal! Cookie mati atau ter-checkpoint.\n";
                }
            } elseif ($pilihanSesi === '4') {
                echo "Masukkan Cookie TikTok (Pastikan ada sessionid_ss): ";
                $cookie = trim(fgets(STDIN));
                echo "🔄 Memvalidasi sesi ke API TikTok...\n";
                if (SessionManager::validateTikTok($cookie)) {
                    SessionManager::saveSession('tiktok', ['cookie' => $cookie]);
                    echo "✅ Sesi TikTok valid dan berhasil disimpan!\n";
                } else {
                    echo "❌ Validasi gagal! Sesi kedaluwarsa.\n";
                }
            }
            break;

        case '2':
            // === OTOMASI X ===
            $x = new XFeatures();
            echo "\n--- FITUR X (TWITTER) ---\n";
            echo "1. Mass Follow\n2. Mass Unfollow\n3. Mass Block\n4. Mass Unblock\n5. Mass Delete Tweets\n6. Auto Comment\nPilih Aksi: ";
            $aksi = trim(fgets(STDIN));
            if (in_array($aksi, ['1', '2', '3', '4', '5'])) {
                echo "Masukkan ID Target (pisahkan dengan koma jika banyak): ";
                $ids = explode(',', trim(fgets(STDIN)));
                if ($aksi === '1') $x->massFollow($ids);
                if ($aksi === '2') $x->massUnfollow($ids);
                if ($aksi === '3') $x->massBlock($ids);
                if ($aksi === '4') $x->massUnblock($ids);
                if ($aksi === '5') $x->massDeleteTweets($ids);
            } elseif ($aksi === '6') {
                echo "Masukkan ID Tweet Utama: "; $tId = trim(fgets(STDIN));
                echo "Masukkan Isi Teks Replay: "; $teks = trim(fgets(STDIN));
                $x->autoComment($tId, $teks);
            }
            break;

        case '3':
            // === OTOMASI INSTAGRAM ===
            $ig = new InstagramFeatures();
            echo "\n--- FITUR INSTAGRAM ---\n";
            echo "1. Mass Follow\n2. Mass Unfollow\n3. Scrape Followers\n4. Scrape Following\n5. Mass Block\n6. Auto Comment\nPilih Aksi: ";
            $aksi = trim(fgets(STDIN));
            if (in_array($aksi, ['1', '2', '5'])) {
                echo "Masukkan ID User (pisahkan dengan koma): ";
                $ids = explode(',', trim(fgets(STDIN)));
                if ($aksi === '1') $ig->massFollow($ids);
                if ($aksi === '2') $ig->massUnfollow($ids);
                if ($aksi === '5') $ig->massBlock($ids);
            } elseif ($aksi === '3' || $aksi === '4') {
                echo "Masukkan ID Numerik Target: "; $target = trim(fgets(STDIN));
                if ($aksi === '3') $ig->scrapeFollowers($target);
                if ($aksi === '4') $ig->scrapeFollowing($target);
            } elseif ($aksi === '6') {
                echo "Masukkan Media ID Instagram: "; $mId = trim(fgets(STDIN));
                echo "Masukkan Isi Komentar: "; $teks = trim(fgets(STDIN));
                $ig->autoComment($mId, $teks);
            }
            break;

        case '4':
            // === OTOMASI FACEBOOK ===
            $fb = new FacebookFeatures();
            echo "\n--- FITUR FACEBOOK ---\n";
            echo "1. Auto Post Multiple Groups\n2. Auto Leave Groups\n3. Auto Accept Friend Request\n4. Auto Reject Friend Request\n5. Mass Cancel Sent Request\nPilih Aksi: ";
            $aksi = trim(fgets(STDIN));
            if ($aksi === '1') {
                echo "Masukkan ID Group FB: "; $gId = trim(fgets(STDIN));
                echo "Masukkan Teks Postingan: "; $teks = trim(fgets(STDIN));
                $fb->autoPostGroup($gId, $teks);
            } elseif ($aksi === '2') {
                echo "Masukkan ID Group yang ingin ditinggalkan: "; $gId = trim(fgets(STDIN));
                $fb->massLeaveGroup($gId);
            } elseif (in_array($aksi, ['3', '4', '5'])) {
                echo "Masukkan ID User pengirim/target: "; $uId = trim(fgets(STDIN));
                if ($aksi === '3') $fb->acceptFriendRequest($uId);
                if ($aksi === '4') $fb->rejectFriendRequest($uId);
                if ($aksi === '5') $fb->cancelSentRequest($uId);
            }
            break;

        case '5':
            // === OTOMASI TIKTOK ===
            $tt = new TikTokFeatures();
            echo "\n--- FITUR TIKTOK ---\n";
            echo "1. Mass Delete Own Videos\n2. Mass Unfollow\n3. Auto Comment Video\nPilih Aksi: ";
            $aksi = trim(fgets(STDIN));
            if ($aksi === '1') {
                echo "Masukkan Video IDs (pisahkan dengan koma): ";
                $ids = explode(',', trim(fgets(STDIN)));
                $tt->massDeleteVideos($ids);
            } elseif ($aksi === '2') {
                echo "Masukkan User UIDs (pisahkan dengan koma): ";
                $ids = explode(',', trim(fgets(STDIN)));
                $tt->massUnfollow($ids);
            } elseif ($aksi === '3') {
                echo "Masukkan Video ID Target: "; $vId = trim(fgets(STDIN));
                echo "Masukkan Teks Komentar: "; $teks = trim(fgets(STDIN));
                $tt->autoComment($vId, $teks);
            }
            break;

        default:
            echo "❌ Pilihan menu utama tidak valid!\n";
            break;
    }
    echo "\nTekan Enter untuk kembali ke Menu Utama...";
    fgets(STDIN);
    echo "\n";
}