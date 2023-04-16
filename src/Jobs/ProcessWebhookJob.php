<?php

namespace Cxj\LookingGlass\Jobs;

use Cxj\LookingGlass\Models\RemoteHealthCheckModel;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Spatie\WebhookClient\Jobs\ProcessWebhookJob as SpatieProcessWebhookJob;

class ProcessWebhookJob extends SpatieProcessWebhookJob
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::debug(__METHOD__);                                      // debug
        Log::debug(
            'webhookCall: '.json_encode($this->webhookCall, JSON_PRETTY_PRINT)
        );                                                           // debug

        // 🤬 arrays
        $result = (object) $this->webhookCall->payload['result'];

        // Insert into DB table of health
        RemoteHealthCheckModel::updateOrCreate(
            [
                'app_name'   => $this->webhookCall->payload['name'],
                'check_name' => $this->webhookCall->payload['label'],
            ],
            ['result' => json_encode($result)]
        );
    }
}
