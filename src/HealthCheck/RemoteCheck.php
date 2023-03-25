<?php

namespace Cxj\LookingGlass\HealthCheck;

use App\Models\RemoteHealthCheckModel;
use Spatie\Health\Checks\Check;
use Spatie\Health\Checks\Result;

class RemoteCheck extends Check
{
    private Result $result;


    public function __construct(private RemoteHealthCheckModel $remote)
    {
        $this->result = Result::make();

        $this->name  = $remote->app_name . $remote->check_name;
        $this->label = $remote->app_name . ':' . $remote->check_name;

        parent::__construct();
    }

    public function run(): Result
    {
        $obj = json_decode($this->remote->result);
        switch ($obj->status ?? null) {
            case 'ok':
                $this->result->ok($obj->shortSummary);
                break;
            case 'warning':
                $this->result->warning($obj->shortSummary);
                break;
            case 'failed':
                $this->result->failed($obj->shortSummary);
                break;
            default:
                $this->result->warning('offline');
        }

        return $this->result;
    }
}
