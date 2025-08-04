<?php

namespace App\Services\RealtimeRoutine;

use App\Jobs\CloseRealtimeRoutineJob;
use App\Jobs\EndRealtimeRoutineJob;
use App\Jobs\HoldRealtimeRoutineJob;
use App\Jobs\StartRealtimeRoutineJob;
use App\Models\RealtimeRoutine;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;

class EventSchedulerService
{
    /**
     * 全ジョブをスケジューリングまたは即時実行
     */
    public function scheduleAllJobs(RealtimeRoutine $realtimeRoutine): void
    {
        $now = Carbon::now();
        $startAt = Carbon::parse($realtimeRoutine->start_time);
        $endAt = Carbon::parse($realtimeRoutine->end_time);
        $routineId = $realtimeRoutine->realtime_routine_id;
        $holdOffset = Config::get('constants.REALTIME_ROUTINE.HOLD_MINUTES_BEFORE');
        $closeOffset = Config::get('constants.REALTIME_ROUTINE.CLOSE_MINUTES_AFTER');

        // HOLDINGジョブ（開始時刻の HOLD_MINUTES_BEFORE 分前）
        $holdTime = $startAt->copy()->subMinutes($holdOffset);
        // $holdTime = $startAt->copy()->subSeconds(10); // 開始10秒前に変更
        $this->dispatchJob(new HoldRealtimeRoutineJob($routineId), $holdTime, $now);

        // STARTジョブ（開始時刻）
        $this->dispatchJob(new StartRealtimeRoutineJob($routineId), $startAt, $now);

        // ENDジョブ（終了時刻）
        $this->dispatchJob(new EndRealtimeRoutineJob($routineId), $endAt, $now);

        // CLOSEジョブ（終了時刻の CLOSE_MINUTES_AFTER 分後）
        $closeTime = $endAt->copy()->addMinutes($closeOffset);
        // $closeTime = $endAt->copy()->addSeconds(10); // 終了10秒後に変更
        $this->dispatchJob(new CloseRealtimeRoutineJob($routineId), $closeTime, $now);
    }

    /**
     * 実行時刻に応じて即時または遅延ディスパッチ
     */
    private function dispatchJob(object $job, Carbon $scheduledTime, Carbon $now): void
    {
        if ($scheduledTime->greaterThan($now)) {
            dispatch($job->delay($scheduledTime));
        } else {
            dispatch($job);
        }
    }
}
