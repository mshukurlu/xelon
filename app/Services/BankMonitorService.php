<?php
namespace App\Services;
use App\Events\MonitorBankSystem;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BankMonitorService
{
    public function checkUpdates() : void
    {
        /*Remember the last update time*/

        $cached_time = Cache::get('monitor_last_update_time');

        $response = Http::get(config('monitor_system.api_url'));

        if($response->status()==200) {
            $this->processResponseAndDispatchEvent($cached_time,$response->body());
        }else{
            Log::info('A problem occured during fethcing data from Mono Bank API');
        }
    }

    private function processResponseAndDispatchEvent($cached_time,$body) : void
    {
        $result = json_decode($body);
        $last_update = array_column((array)$result, 'date');
        arsort($last_update);
        $last_updated_time = array_slice($last_update, 0, 1);

        if (($cached_time && $last_updated_time > $cached_time) or is_null($cached_time)) {
            event(new MonitorBankSystem('You have a new update'));
            Cache::set('monitor_last_update_time', $last_updated_time[0]);
            Log::info('Updated and BroadCasted successfully');
        }
    }
}
