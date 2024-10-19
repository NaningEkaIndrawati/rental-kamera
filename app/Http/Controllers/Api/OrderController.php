<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\UpdateNotificationStatus;
use App\Models\Alat;
use App\Models\Notifications;
use App\Models\Order;
use App\Models\Payment;
use Carbon\Carbon;
use DateTime;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function store(Request $request){

        $request->validate([
            "id_alat" => "required",
            "waktu_sewa" => "required",
            "start_date" => "required",
            "start_time" => "required",
        ]);

        $alat = Alat::where('id', $request->id_alat)->first();

        if(!$alat){
            return response()->json(["message" => "Alat Tidak Ditemukan"]);
        }


        if($request->waktu_sewa == "6"){
            $harga = $alat->harga6;
        }else if($request->waktu_sewa == "12"){
            $harga = $alat->harga12;
        }else{
            $harga = $alat->harga24;
        }

        $pembayaran = new Payment();

        $pembayaran->no_invoice = Auth::id()."/".Carbon::now()->timestamp;
        $pembayaran->penyewa_id = Auth::id();
        $pembayaran->total = $harga;
        $pembayaran->save();
        $orderStart = date('Y-m-d H:i', strtotime($request['start_date'].$request['start_time']));
        $oderEnd = date('Y-m-d H:i', strtotime($request['start_date'].$request['start_time']."+" . $request->waktu_sewa ." hours"));
        // dd($oderEnd);
        /**
            * ketika reservasi nanti akan mengirim notifikasi ke user mengenai berhasil membuat notifikasi,
            * dan membuat notifikasi -1 jam dari order enddate, dan membuat schadule notifikasi di jam H order end
            * segera untuk di kembalikan, denda terhitung 3 jam 50k jika lebih dari 3 jam maka dihitung 1 hari, dan membuat schadule notifikasi di hari order end + jam 3
         */
        // dd(Auth::id()); -> penyewa, yang digunakan adalah userid

        $order = Order::create([
            'alat_id' => $alat->id,
            'penyewa_id' => Auth::id(),
            'payment_id' => $pembayaran->id,
            'durasi' => $request->waktu_sewa,
            'starts' => $orderStart,
                'ends' => $oderEnd,
                'harga' => $harga,
            ]);


        //send notifikasi ketika berhasil reservasi
        $this->sendNotifikasiKetikaReservasi((string)Auth::id(),$alat->nama_alat,$request->wakt_sewa);

        //send notifikasi peringatan 1 jam sebelum habis
        $this->sendNotifikasiSatuJamSebelumWaktuHabis((string)Auth::id(),$alat->nama_alat,$oderEnd,$order->id);

        //send notifikasi peringatan ketika keterlambatan
        $this->sendNotifikasiKeterlambatan((string)Auth::id(),$alat->nama_alat,$oderEnd,$order->id);


        return response()->json(["message" => "Berhasil Reservasi","Order" => $order]);
    }
    private function sendNotifikasiKetikaReservasi($userid,$alat, $waktu_sewa){
        $dataMessage = [
            'title' => 'Reservasi Kamera Berhasil!',
            'body' => 'Selamat! Anda telah berhasil melakukan reservasi '.$alat.' untuk '.$waktu_sewa.'. Jangan lupa untuk mengembalikannya tepat waktu.',
        ];
        $api = "https://api.onesignal.com/api/v1/notifications";
        $client = new Client();
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic ' . env('ONESIGNAL_REST_API_KEY') // Your REST API Key
        ];
        $bodyRequest = [
            'target_channel'=>"push",
            'app_id' => env('ONESIGNAL_APP_ID'), // Your OneSignal App ID
            'include_external_user_ids'=>[
                $userid
            ],
            // 'included_segments' => ['All'], // Send to all users
            'headings' => ['en' => $dataMessage['title']], // Notification title
            'contents' => ['en' => $dataMessage['body']], // Notification content
        ];
        try {
            $response = $client->post($api, [
                'headers' => $headers,
                'body' => json_encode($bodyRequest)
            ]);

            // Decode the response body if needed
            $bodyResponse = json_decode($response->getBody()->getContents(), true);
            return response()->json(['message' => 'Notification to Users spesifik User', 'response' => $bodyResponse]);


        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to send notification', 'message' => $e->getMessage()], 500);
        }
    }
    private function sendNotifikasiSatuJamSebelumWaktuHabis($userid,$alat,$waktu_habis,$orderId){
        // $datetime = $waktu_habis->addMinute(); // Menambahkan 1 menit
        // $datetime = $waktu_habis->addHour();
        $datetime = new DateTime($waktu_habis); // Mengubah string waktu menjadi objek DateTime
        $datetime->modify('-1 hour');           // Mengurangi 1 jam dari waktu habis
        $datetime_satu_jam_sebelum = $datetime->format('Y-m-d H:i'); // Format kembali ke string

        $dataMessage = [
            'title' => 'Waktu Sewa '.$alat.' Hampir Habis!',
            'body' => 'Sisa 1 jam lagi sebelum waktu sewa kamera berakhir. Pastikan untuk mengembalikannya tepat waktu agar terhindar dari denda.',
        ];
        $api = "https://api.onesignal.com/api/v1/notifications";
        $client = new Client();
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic ' . env('ONESIGNAL_REST_API_KEY') // Your REST API Key
        ];
        $bodyRequest = [
            'target_channel'=>"push",
            'app_id' => env('ONESIGNAL_APP_ID'), // Your OneSignal App ID
            'include_external_user_ids'=>[
                $userid
            ],
            // 'included_segments' => ['All'], // Send to all users
            'headings' => ['en' => $dataMessage['title']], // Notification title
            'contents' => ['en' => $dataMessage['body']], // Notification content
            "send_after"=>$datetime_satu_jam_sebelum
        ];
        try {
            $response = $client->post($api, [
                'headers' => $headers,
                'body' => json_encode($bodyRequest)
            ]);

            // Decode the response body if needed
            $bodyResponse = json_decode($response->getBody()->getContents(), true);
            $notifikasiId = $bodyResponse['id'];
            Notifications::create([
                'notification_id' => $notifikasiId,
                'penyewa_id'=>$userid,
                'order_id'=>$orderId,
                'title' => $dataMessage['title'],
                'message' => $dataMessage['body'],
                'status' => 'reserved',
            ]);
            // ! run job update notification status
            UpdateNotificationStatus::dispatch($orderId,$notifikasiId)->delay(strtotime($datetime_satu_jam_sebelum));

            return response()->json(['message' => 'Notification to Users'.$userid.' Created', 'response' => $bodyResponse]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to send notification', 'message' => $e->getMessage()], 500);
        }
    }
    private function sendNotifikasiKeterlambatan($userid,$alat,$waktu_habis,$orderId){
        // $datetime = $waktu_habis;
        $dataMessage = [
            'title' => 'Waktu Sewa '.$alat.' Telah Berakhir!',
            'body' => 'Segera kembalikan untuk menghindari denda. Denda 50k jika terlambat kurang dari 3 jam. Keterlambatan lebih dari 3 jam akan dihitung sebagai sewa 1 hari.',
        ];
        $api = "https://api.onesignal.com/api/v1/notifications";
        $client = new Client();
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic ' . env('ONESIGNAL_REST_API_KEY') // Your REST API Key
        ];
        $bodyRequest = [
            'target_channel'=>"push",
            'app_id' => env('ONESIGNAL_APP_ID'), // Your OneSignal App ID
            'include_external_user_ids'=>[
                $userid
            ],
            // 'included_segments' => ['All'], // Send to all users
            'headings' => ['en' => $dataMessage['title']], // Notification title
            'contents' => ['en' => $dataMessage['body']], // Notification content
            "send_after"=>$waktu_habis
        ];
        try {
            $response = $client->post($api, [
                'headers' => $headers,
                'body' => json_encode($bodyRequest)
            ]);

            // Decode the response body if needed
            $bodyResponse = json_decode($response->getBody()->getContents(), true);
            $notifikasiId = $bodyResponse['id'];
            Notifications::create([
                'notification_id' => $notifikasiId,
                'penyewa_id'=>$userid,
                'order_id'=>$orderId,
                'title' => $dataMessage['title'],
                'message' => $dataMessage['body'],
                'status' => 'reserved',
            ]);
            // ! run job update notification status
            UpdateNotificationStatus::dispatch($orderId,$notifikasiId)->delay(strtotime($waktu_habis));

            return response()->json(['message' => 'Notification to Users'.$userid.' Created', 'response' => $bodyResponse]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to send notification', 'message' => $e->getMessage()], 500);
        }
    }
}
