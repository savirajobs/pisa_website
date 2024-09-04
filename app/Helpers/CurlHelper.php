<?php


// class CurlHelper {
    //     public static function fetchAuthData($password) {
        //         $nip = $password;
        //         // dd($nip);
        
        //         $url = 'http://ws.blitarkota.go.id';
        //         $data = array(
            //             'data' => 'pegawai',
            //             'view' => 'pegawai_email',
            //             'user' => 'diskominfotik_shortapp',
//             'token' => md5("1227" . date('YmdH')),
//             'nip' => $nip
//         );

//         $curl = curl_init();
//         curl_setopt($curl, CURLOPT_URL, $url);
//         curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//         curl_setopt($curl, CURLOPT_POST, true);
//         curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data)); 

//         $response = curl_exec($curl);

//         if ($response === false) {
    //             // Handle cURL error
    //             throw new \Exception(curl_error($curl), curl_errno($curl));
//         }

//         curl_close($curl);

//         return $response;
//     }
// }
namespace App\Helpers;

class CurlHelper {
    public static function fetchAuthData($requestData) {
        // dd($requestData['email']);
        // Dummy email and password data
        $dummyEmail = 'yuda@mail.com';
        $dummyPassword = 'yuda';

        // Check if provided email and password match dummy data
        if ($requestData['email'] === $dummyEmail && $requestData['password'] === $dummyPassword) {
            return [
                'email' => $requestData['email'],
                'password' => $requestData['password'],
            ];
        } else {
            return false;
        }
    }
}
