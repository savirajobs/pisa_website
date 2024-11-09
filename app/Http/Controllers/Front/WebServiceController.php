<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Otp;
use App\Models\WsLog;
use Carbon\Carbon;

class WebServiceController extends Controller
{
    function createAndStoreOTP($phone)
    {
        $otpCode = rand(1000, 9999);

        // Simpan OTP ke database
        Otp::create([
            'phone' => $phone,
            'otp' => $otpCode,
            'expired_at' => Carbon::now()->addMinutes(5) // OTP berlaku selama 60 menit
        ]);

        return $otpCode;
    }

    function verifyOtp(Request $request)
    {
        $otp = Otp::where('phone', $request->otp_phone)
            ->where('otp', $request->otp_value)
            ->where('expired_at', '>', Carbon::now())
            ->first();

        if (!$otp) {
            return response()->json(['error' => 'OTP tidak valid.'], 500);
        } elseif ($otp->expired_at < Carbon::now()) {
            return response()->json(['error' => 'OTP kadaluwarsa.'], 500);
        } else {
            //update kolom verification, lalu panggil method send wa
            $otp->delete();
            return response()->json(['success' => 'Feedback berhasil terkirim.']);
        }

        // if ($otp) {
        //     // OTP valid, hapus setelah digunakan
        //     $otp->delete();
        //     return response()->json(['success' => 'Feedback berhasil terkirim.']);
        //     // return true;
        // }

        // return false; // OTP tidak valid atau sudah kedaluwarsa
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
