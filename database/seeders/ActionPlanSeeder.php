<?php

namespace Database\Seeders;

use App\Models\ActionPlan;
use App\Models\ApCriteriaScore;
use App\Models\SawCriteria;
use Illuminate\Database\Seeder;

class ActionPlanSeeder extends Seeder
{
    public function run(): void
    {
        // Matriks nilai: [C1, C2, C3, C4]
        // C1=Relevansi Gejala(0.35), C2=Kemudahan(0.25), C3=Efektivitas Literatur(0.25), C4=Kesesuaian Usia(0.15)
        $plans = [
            [
                'code'             => 'AP01',
                'name'             => 'Latihan Restrukturisasi Kognitif',
                'description'      => 'Identifikasi pikiran otomatis negatif ("cognitive distortions") yang muncul saat menghadapi kebingungan karir atau identitas, kemudian ganti dengan perspektif yang lebih seimbang dan berbasis bukti.',
                'category'         => 'cognitive',
                'source_reference' => 'Beck et al. (1979) — Cognitive Behavioral Therapy; disupport wellbraintherapy.com & healthline.com (2023)',
                'how_to'           => "1. Tulis situasi yang memicu pikiran negatif.\n2. Catat pikiran otomatis yang muncul (misal: 'Saya gagal total').\n3. Tanyakan: Apakah pikiran ini berdasarkan fakta atau asumsi?\n4. Tuliskan perspektif alternatif yang lebih seimbang (misal: 'Saya sedang belajar, kegagalan adalah bagian dari proses').\n5. Ulangi setiap kali pikiran negatif muncul.",
                'duration_minutes' => 20,
                'difficulty'       => 'medium',
                'scores'           => [5, 3, 5, 4], // C1, C2, C3, C4
            ],
            [
                'code'             => 'AP02',
                'name'             => 'Teknik Thought Record (Catatan Pikiran)',
                'description'      => 'Catat secara sistematis situasi pemicu kecemasan, pikiran negatif yang muncul, emosi yang dirasakan (dengan intensitas 0-100%), dan alternatif pikiran yang lebih adaptif menggunakan format terstruktur.',
                'category'         => 'cognitive',
                'source_reference' => 'Beck, Rush, Shaw & Emery (1979) — CBT; Adapted from cognitive therapy worksheets (2022)',
                'how_to'           => "1. Siapkan lembar atau buku catatan.\n2. Kolom 1: Situasi (apa yang terjadi?).\n3. Kolom 2: Pikiran otomatis (apa yang langsung terlintas?).\n4. Kolom 3: Emosi & Intensitas (misal: Cemas 80%).\n5. Kolom 4: Bukti yang mendukung/melawan pikiran.\n6. Kolom 5: Pikiran alternatif yang lebih realistis.\n7. Kolom 6: Emosi setelah reframing.",
                'duration_minutes' => 15,
                'difficulty'       => 'medium',
                'scores'           => [4, 3, 5, 4],
            ],
            [
                'code'             => 'AP03',
                'name'             => 'Behavioral Experiment (Uji Ketakutan Kecil)',
                'description'      => 'Uji ketakutan atau asumsi negatif melalui langkah nyata yang kecil dan terukur, alih-alih hanya membayangkan skenario terburuk. Teknik ini membantu membuktikan atau menyangkal keyakinan irasional.',
                'category'         => 'behavioral',
                'source_reference' => 'Beck et al. (1979) — CBT Behavioral Experiments; sandiegotherapy.com (2023)',
                'how_to'           => "1. Identifikasi satu ketakutan spesifik (misal: 'Saya tidak akan bisa sukses di bidang X').\n2. Rancang eksperimen kecil untuk mengujinya (misal: coba ikut workshop/proyek kecil di bidang X).\n3. Lakukan eksperimen tersebut dalam 1-2 minggu.\n4. Catat hasilnya: apakah ketakutan terbukti atau tidak?\n5. Perbarui keyakinan Anda berdasarkan bukti nyata.",
                'duration_minutes' => null,
                'difficulty'       => 'medium',
                'scores'           => [4, 3, 4, 5],
            ],
            [
                'code'             => 'AP04',
                'name'             => 'Journaling Brain Dump Harian',
                'description'      => 'Tulis semua pikiran dan kegelisahan tanpa filter selama 10-15 menit setiap hari. Teknik "stream of consciousness" ini membantu "mengosongkan" pikiran yang overloaded dan mengurangi kecemasan.',
                'category'         => 'journaling',
                'source_reference' => 'Evidence-based journaling therapy; Nayatherapy.com (2023); medium.com (2023)',
                'how_to'           => "1. Siapkan buku catatan atau aplikasi notes.\n2. Set timer 10-15 menit.\n3. Tulis semua yang ada di pikiran tanpa menghakimi atau mengedit.\n4. Jangan khawatir tentang tata bahasa atau logika.\n5. Setelah selesai, baca sekilas dan tandai tema yang sering muncul.\n6. Lakukan setiap pagi atau sebelum tidur.",
                'duration_minutes' => 15,
                'difficulty'       => 'easy',
                'scores'           => [4, 5, 4, 5],
            ],
            [
                'code'             => 'AP05',
                'name'             => 'Journaling Klarifikasi Nilai (Values Clarification)',
                'description'      => 'Eksplorasi nilai-nilai hidup yang sejati melalui pertanyaan reflektif terstruktur. Membantu membedakan keinginan sendiri vs. ekspektasi orang lain, dan membangun kompas internal untuk pengambilan keputusan.',
                'category'         => 'journaling',
                'source_reference' => 'Nayatherapy.com (2023); Acceptance & Commitment Therapy — Hayes et al.',
                'how_to'           => "1. Jawab pertanyaan-pertanyaan berikut di jurnal:\n   • Apa 5 hal yang paling penting bagi saya dalam hidup?\n   • Jika tidak ada yang menilai, apa yang ingin saya lakukan?\n   • Pencapaian apa yang akan membuat saya bangga 10 tahun lagi?\n   • Kapan terakhir kali saya merasa paling hidup dan bersemangat?\n2. Baca ulang jawaban dan cari pola.\n3. Susun 3 nilai inti hidup Anda.",
                'duration_minutes' => 30,
                'difficulty'       => 'medium',
                'scores'           => [5, 4, 4, 4],
            ],
            [
                'code'             => 'AP06',
                'name'             => 'Penetapan Tujuan SMART Jangka Pendek',
                'description'      => 'Susun 1-3 tujuan spesifik, terukur, realistis, relevan, dan berbatas waktu (1-4 minggu) sebagai langkah pertama yang konkret. Menggantikan tujuan besar yang melumpuhkan dengan langkah kecil yang membangun momentum.',
                'category'         => 'behavioral',
                'source_reference' => 'Locke & Latham — Goal-Setting Theory (2002); nurtureyournaturepc.com (2023)',
                'how_to'           => "1. Pilih satu area kehidupan yang ingin diperbaiki.\n2. Tulis tujuan menggunakan format SMART:\n   • Specific: Apa tepatnya yang ingin dicapai?\n   • Measurable: Bagaimana cara mengukur keberhasilan?\n   • Achievable: Apakah realistis dalam waktu 2-4 minggu?\n   • Relevant: Apakah sesuai dengan nilai hidup Anda?\n   • Time-bound: Kapan deadline-nya?\n3. Bagi tujuan menjadi sub-tugas harian kecil.\n4. Evaluasi setiap minggu.",
                'duration_minutes' => 20,
                'difficulty'       => 'easy',
                'scores'           => [5, 4, 4, 5],
            ],
            [
                'code'             => 'AP07',
                'name'             => 'Eksplorasi Karir & Minat Mingguan',
                'description'      => 'Jadwalkan satu kegiatan eksplorasi karir/minat per minggu — riset online, informational interview, kursus singkat, atau shadowing — untuk mengurangi kebingungan arah melalui data nyata, bukan asumsi.',
                'category'         => 'behavioral',
                'source_reference' => 'Career counseling literature; Atwood & Scholtz (2008); fireflytherapyaustin.com (2023)',
                'how_to'           => "1. Buat daftar 3-5 bidang karir/minat yang ingin dijelajahi.\n2. Setiap minggu, pilih satu kegiatan eksplorasi:\n   • Baca artikel/buku tentang bidang tersebut\n   • Tonton wawancara profesional di bidang itu\n   • Hubungi alumni/koneksi yang bekerja di bidang itu\n   • Ikuti kursus online gratis (Coursera, edX, dll.)\n3. Catat insight dari setiap eksplorasi.\n4. Review setelah 1 bulan untuk melihat pola minat.",
                'duration_minutes' => 60,
                'difficulty'       => 'easy',
                'scores'           => [4, 4, 3, 5],
            ],
            [
                'code'             => 'AP08',
                'name'             => 'Latihan Pernapasan Kotak (Box Breathing)',
                'description'      => 'Teknik pernapasan 4-4-4-4 detik yang terbukti secara ilmiah menurunkan respons stres akut (fight-or-flight), menenangkan sistem saraf otonom, dan mengurangi kecemasan dalam hitungan menit.',
                'category'         => 'mindfulness',
                'source_reference' => 'Kabat-Zinn (1994) — MBSR; kaiserpermanente.org (2023); wellbraintherapy.com (2023)',
                'how_to'           => "Teknik Box Breathing (4 langkah):\n1. HIRUP: Tarik napas dalam melalui hidung selama 4 detik.\n2. TAHAN: Tahan napas selama 4 detik.\n3. BUANG: Hembuskan napas perlahan melalui mulut selama 4 detik.\n4. TAHAN: Tahan (kosong) selama 4 detik.\n5. Ulangi 4-8 kali.\n\nLakukan saat:\n• Merasa cemas atau overwhelmed\n• Sebelum keputusan penting\n• Setiap pagi sebagai ritual harian",
                'duration_minutes' => 5,
                'difficulty'       => 'easy',
                'scores'           => [3, 5, 4, 4],
            ],
            [
                'code'             => 'AP09',
                'name'             => 'Mindful Awareness dalam Aktivitas Sehari-hari',
                'description'      => 'Praktikkan kesadaran penuh (mindfulness) saat melakukan aktivitas rutin — makan, mandi, berjalan — untuk melatih kehadiran di momen saat ini dan mengurangi overthinking tentang masa depan.',
                'category'         => 'mindfulness',
                'source_reference' => 'Kabat-Zinn (1994) — MBSR; cityscapecounseling.com (2023); kaiserpermanente.org (2023)',
                'how_to'           => "1. Pilih satu aktivitas rutin harian (misal: makan siang).\n2. Selama aktivitas itu, fokuslah penuh pada pengalaman sensoris:\n   • Apa yang kamu lihat, cium, rasakan, dengar?\n3. Saat pikiran melayang ke masa depan/kegelisahan, sadari lalu kembalikan fokus ke aktivitas.\n4. Tidak perlu memaksa diri untuk 'tidak memikirkan apapun' — cukup amati tanpa menghakimi.\n5. Tingkatkan durasi secara bertahap.",
                'duration_minutes' => 10,
                'difficulty'       => 'easy',
                'scores'           => [3, 5, 4, 4],
            ],
            [
                'code'             => 'AP10',
                'name'             => 'Digital Detox Terjadwal (Batas Waktu Media Sosial)',
                'description'      => 'Tetapkan jadwal bebas media sosial harian yang konsisten (minimal 1 jam/hari, terutama pagi dan malam) untuk mengurangi pemicu perbandingan sosial — salah satu faktor utama QLC di era digital.',
                'category'         => 'behavioral',
                'source_reference' => 'Positive psychology; Studi QLC Indonesia — Faktor Media Sosial (2022-2024); brodieearl.com (2023)',
                'how_to'           => "1. Audit waktu screen time saat ini (gunakan fitur bawaan HP).\n2. Tetapkan zona bebas medsos:\n   • 1 jam pertama setelah bangun pagi\n   • 1 jam sebelum tidur malam\n3. Gunakan fitur 'Screen Time Limit' di HP.\n4. Ganti waktu tersebut dengan aktivitas offline:\n   • Membaca buku fisik\n   • Olahraga ringan\n   • Refleksi/journaling\n5. Evaluasi perasaan setelah 1 minggu.",
                'duration_minutes' => null,
                'difficulty'       => 'medium',
                'scores'           => [4, 5, 3, 5],
            ],
            [
                'code'             => 'AP11',
                'name'             => 'Membangun Koneksi dengan Mentor atau Figur Panutan',
                'description'      => 'Aktif mencari dan berkomunikasi dengan mentor, alumni, atau profesional senior di bidang yang diminati untuk mendapatkan perspektif nyata, bimbingan karir, dan dukungan emosional.',
                'category'         => 'social',
                'source_reference' => 'Social support theory; deltapsychology.com (2023); planetmindcare.com (2023)',
                'how_to'           => "1. Identifikasi 2-3 orang yang bisa menjadi mentor (alumni kampus, senior di pekerjaan, tokoh di bidang minat).\n2. Hubungi mereka dengan pesan yang spesifik dan tulus (bukan sekadar 'minta saran').\n3. Ajukan pertanyaan konkret: 'Bagaimana Anda menghadapi ketidakpastian di awal karir?'\n4. Jadwalkan percakapan reguler (bulanan).\n5. Bergabung dengan komunitas alumni atau grup profesional online.",
                'duration_minutes' => 60,
                'difficulty'       => 'medium',
                'scores'           => [4, 3, 3, 5],
            ],
            [
                'code'             => 'AP12',
                'name'             => 'Bergabung dengan Komunitas Berbasis Minat',
                'description'      => 'Temukan dan bergabung dengan komunitas (online/offline) yang berbagi minat, nilai, atau situasi yang sama untuk mengurangi isolasi sosial dan membangun rasa memiliki (sense of belonging).',
                'category'         => 'social',
                'source_reference' => 'Social support & belonging theory; Robbins & Wilner (2001); deltapsychology.com (2023)',
                'how_to'           => "1. Identifikasi minat atau situasi yang ingin Anda temukan komunitas-nya.\n2. Cari komunitas:\n   • Online: Discord, Reddit, Telegram, LinkedIn Group\n   • Offline: Komunitas lokal, UKM, organisasi minat\n3. Mulai dengan menjadi anggota pasif, lalu perlahan aktif berkontribusi.\n4. Hadiri setidaknya 1-2 acara/diskusi per bulan.\n5. Fokus pada memberi nilai, bukan hanya menerima.",
                'duration_minutes' => null,
                'difficulty'       => 'easy',
                'scores'           => [3, 4, 3, 5],
            ],
        ];

        $criteriaList = SawCriteria::orderBy('order')->get();

        foreach ($plans as $data) {
            $scores = $data['scores'];
            unset($data['scores']);

            $ap = ActionPlan::updateOrCreate(['code' => $data['code']], array_merge($data, ['is_active' => true]));

            // Simpan nilai matriks SAW
            foreach ($criteriaList as $index => $criteria) {
                ApCriteriaScore::updateOrCreate(
                    ['action_plan_id' => $ap->id, 'saw_criteria_id' => $criteria->id],
                    ['score' => $scores[$index] ?? 3]
                );
            }
        }
    }
}
