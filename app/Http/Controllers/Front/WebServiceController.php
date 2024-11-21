<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Models\Otp;
use App\Models\WsLog;
use Carbon\Carbon;

class WebServiceController extends Controller
{
    function createAndStoreOTP($id, $phone)
    {
        $otpCode = rand(1000, 9999);

        // Simpan OTP ke database
        Otp::create([
            'feedback_id' => $id,
            'phone' => $phone,
            'otp' => $otpCode,
            'expired_at' => Carbon::now()->addMinutes(5) // OTP berlaku selama 60 menit
        ]);

        return $otpCode;
    }

    function verifyOtp(Request $request)
    {
        // dd($request);

        $otp = Otp::where('feedback_id', $request->otp_id)
            ->where('otp', $request->otp_value)
            ->where('expired_at', '>', Carbon::now())
            ->first();

        if (!$otp) {
            return response()->json(['error' => 'OTP tidak valid.'], 500);
        } elseif ($otp->expired_at < Carbon::now()) {
            return response()->json(['error' => 'OTP kadaluwarsa.'], 500);
        } else {
            //update kolom verification, lalu panggil method send wa
            Feedback::where('feedback_id', $request->otp_id)
                ->update([
                    'verification_status' => 1,
                    'updated_at' => now()
                ]);

            $feedback = Feedback::where('feedback_id', $request->otp_id)
                ->first();

            $message = "Pengaduan anda atas nama *" . strtoupper($request->otp_sender) . "* sudah diterima. 
Petugas akan segera menghubungi untuk menindaklanjuti pengaduan Anda. 
Terima Kasih\r\n
Dinas Pemberdayaan Perempuan, Perlindungan Anak, Pengendalian Penduduk dan Keluarga Berencana
Jl. DR. Sutomo No 50, Sananwetan
Layanan Helpdesk, melalui :
E-mail : dp3a-p2kb@blitarkota.go.id
Telp/Faks : (0342) 801 080
WhatsApp : 0812-9206-6600
Instagram : @dp3ap2kb.kotablitar
Website : http://dp3a-p2kb.blitarkota.go.id

*Waspada modus penipuan. Seluruh layanan DP3AP2KB Kota Blitar Tidak Dipungut Biaya* ";

            $message_operator = "Pengajuan Pendampingan NIB Secara Individu anda atas nama *" . strtoupper($request->otp_sender) . "* , No HP : +62" . $request->otp_phone . " sudah diterima. \r\nSegera cek detail permohonan pada aplikasi untuk menindaklanjuti. \r\nTerima Kasih";

            $this->send_wa("62" . $request->otp_phone, $message);
            $this->send_wa("6282245090093", $message_operator);

            $otp->delete();
            return response()->json(['success' => 'Feedback berhasil terkirim.']);
        }
    }

    public function send_wa($target, $text)
    {
        date_default_timezone_set('Asia/Jakarta');

        $user = 'dp3ap2kb_pisa';
        $id_token = '6410';
        $token = md5($id_token . date('YmdH'));

        $data = array(
            'target' => $this->fixed_phone($target),
            'text' => $text,
            'user' => $user,
            'token' => $token
        );

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_URL, 'http://ws.blitarkota.go.id/wa.php');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

        $result = curl_exec($curl);
        $info = curl_getinfo($curl);
        curl_close($curl);

        // Simpan log ke database tanpa user dan token
        $log_data = $data;
        unset($log_data['user'], $log_data['token']); // Buang user dan token dari log_data

        WsLog::create([
            'endpoint' => 'send_wa',
            'identifier' => $target,
            'identifier_data' => json_encode(['text' => $text]),
            'request_data' => json_encode($log_data),
            'response_data' => $result,
            'status' => 'sent',
            'ip_address' => $this->getClientIp(), // Tambahkan alamat IP
        ]);

        return $result;
    }

    private function fixed_phone($phone)
    {
        if ($phone) {
            $phone = preg_replace('/^08/', '628', $phone);
            $phone = preg_replace('/^\+62/', '62', $phone);
            return $phone;
        }
        return $phone;
    }

    public function send_test_message()
    {
        // Contoh nomor telepon dan pesan untuk testing
        $target = '082264108950';
        $text = 'PISA Testing';

        // Memanggil metode send_wa
        $result = $this->send_wa($target, $text);

        // Menampilkan hasil untuk testing
        return response()->json([
            'result' => $result
        ]);
    }
}
