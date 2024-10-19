<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notifications;
use Berkayk\OneSignal\OneSignalFacade as OneSignal;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
// use OneSignal;

class NotificationController extends Controller
{
    /**
     * system notifikasi
     * ketika reservasi nanti akan mengirim notifikasi ke user mengenai berhasil membuat notifikasi,
     * dan membuat notifikasi -1 jam dari order enddate, dan membuat schadule notifikasi di jam H order end
     * segera untuk di kembalikan, denda terhitung 3 jam 50k jika lebih dari 3 jam maka dihitung 1 hari, dan membuat schadule notifikasi di hari order end + jam 3
     *
     */
    public function sendNotificationToAllUser()
    {

        $dataMessage = [
            'title' => 'Judul Notifikasi',
            'body' => 'notifikasi untuk semua user',
        ];
        $api = "https://api.onesignal.com/api/v1/notifications";
        $client = new Client();
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic ' . env('ONESIGNAL_REST_API_KEY') // Your REST API Key
        ];
        $bodyRequest = [
            'target_channel' => "push",
            'app_id' => env('ONESIGNAL_APP_ID'), // Your OneSignal App ID
            'included_segments' => ['All'], // Send to all users
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

            return response()->json(['message' => 'Notification to All Users Created', 'response' => $bodyResponse]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to send notification', 'message' => $e->getMessage()], 500);
        }
    }
    public function sendNotificatonToSpesificUser($id)
    {
        $dataMessage = [
            'title' => 'Judul Notifikasi to spessifik user',
            'body' => 'Isi dari notifikasi ini spesifik user',
        ];
        $api = "https://api.onesignal.com/api/v1/notifications";
        $client = new Client();
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic ' . env('ONESIGNAL_REST_API_KEY') // Your REST API Key
        ];
        $bodyRequest = [
            'target_channel' => "push",
            'app_id' => env('ONESIGNAL_APP_ID'), // Your OneSignal App ID
            'include_external_user_ids' => [
                $id
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
    public function sendNotificatonToSpesificUserWithSchadule($id)
    {
        $datetime = Carbon::now()->addMinute(); // Menambahkan 1 menit
        $dataMessage = [
            'title' => 'Judul Notifikasi to spessifik user',
            'body' => 'Isi dari notifikasi ini spesifik user dengan schadule',
        ];
        $api = "https://api.onesignal.com/api/v1/notifications";
        $client = new Client();
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic ' . env('ONESIGNAL_REST_API_KEY') // Your REST API Key
        ];
        $bodyRequest = [
            'target_channel' => "push",
            'app_id' => env('ONESIGNAL_APP_ID'), // Your OneSignal App ID
            'include_external_user_ids' => [
                $id
            ],
            // 'included_segments' => ['All'], // Send to all users
            'headings' => ['en' => $dataMessage['title']], // Notification title
            'contents' => ['en' => $dataMessage['body']], // Notification content
            "send_after" => $datetime
        ];
        try {
            $response = $client->post($api, [
                'headers' => $headers,
                'body' => json_encode($bodyRequest)
            ]);

            // Decode the response body if needed
            $bodyResponse = json_decode($response->getBody()->getContents(), true);

            return response()->json(['message' => 'Notification to All Users Created', 'response' => $bodyResponse]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to send notification', 'message' => $e->getMessage()], 500);
        }

    }
    public function deleteNotification($notification_id)
    {
        // $notificationId = '';
        $appId = env('ONESIGNAL_APP_ID');
        $api = "https://api.onesignal.com/api/v1/notifications/" . $notification_id . "?app_id=" . $appId;
        $client = new Client();
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic ' . env('ONESIGNAL_REST_API_KEY') // Your REST API Key
        ];

        try {
            $response = $client->delete($api, [
                'headers' => $headers,
            ]);

            // Decode the response body if needed
            $bodyResponse = json_decode($response->getBody()->getContents(), true);

            return response()->json(['message' => 'Notification succes to delete', 'response' => $bodyResponse]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to send notification', 'message' => $e->getMessage()], 500);
        }
    }
    public function index()
    {
        $userid = Auth::user()->id;
        $notifications = Notifications::where('penyewa_id', $userid)
            ->where('status', ['active'])
            ->get();

        $data = [
            'notifications' => $notifications
        ];

        return response()->json($data);
    }
}

