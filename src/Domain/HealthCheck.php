<?php

namespace Cxj\LookingGlass\Domain;

use App\HealthCheck\RemoteCheck;
use App\Models\RemoteHealthCheckModel;
use Spatie\Health\Checks\Checks\DatabaseCheck;
use Spatie\Health\Checks\Checks\OptimizedAppCheck;
use Spatie\Health\Checks\Checks\UsedDiskSpaceCheck;
use Spatie\Health\Facades\Health;

class HealthCheck
{
    public function __construct()
    {
    }

    public function init(): void
    {
        $staticList = [
            UsedDiskSpaceCheck::new()->label('Local used disk space'),
            DatabaseCheck::new()->label('Local database'),
            OptimizedAppCheck::new(),
        ];

        $remoteList = [];
        foreach (RemoteHealthCheckModel::all() as $remote) {
            // Add a new Check to list for each remote item.
            echo sprintf(
                "%d: %s:%s\n",
                $remote->id,
                $remote->app_name,
                $remote->check_name
            ); // debug
            $remoteList[] = new RemoteCheck($remote);
        }

        Health::checks(array_merge($staticList, $remoteList));
    }
}
