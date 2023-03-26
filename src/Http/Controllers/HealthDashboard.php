<?php

namespace Cxj\LookingGlass\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Contracts\View\View;
use Spatie\Health\Commands\RunHealthChecksCommand;
use Spatie\Health\Health;
use Spatie\Health\ResultStores\ResultStore;

class HealthDashboard
{
    public function __invoke(
        Request $request,
        ResultStore $resultStore,
        Health $health
    ): JsonResponse|View {
        if ($request->has('fresh')) {
            Artisan::call(RunHealthChecksCommand::class);
        }

        $checkResults = $resultStore->latestResults();

        return view('dashboard', [
            'lastRanAt'    => new Carbon($checkResults?->finishedAt),
            'checkResults' => $checkResults,
            'assets'       => $health->assets(),
            'theme'        => config('health.theme'),
        ]);
    }
}
