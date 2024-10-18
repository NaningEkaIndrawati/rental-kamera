<?php

namespace App\Jobs;

use App\Models\Notifications;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateNotificationStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $orderId;
    protected $notificationId;
    public function __construct($orderId,$notificationId)
    {
        $this->orderId = $orderId;
        $this->notificationId = $notificationId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $order = Order::find($this->orderId,$this->notificationId);
        if ($order && $order->status_denda !== 2) {
            Notifications::where('order_id', $this->orderId)
                ->where('notification_id',$this->notificationId)
                ->update(['status' => 'active']);
        }
    }
}
