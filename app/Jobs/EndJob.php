<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Mission;

class EndJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $mission;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Mission $mission)
    {
        $this->mission = $mission;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        /* if($this->mission->ends_at->format('Y-m-d H:i') == date('Y-m-d H:i')) {
            $this->mission->status = "terminée";
            $this->mission->save();
        }*/
        if ((strtotime($this->mission->ends_at) - (strtotime($this->mission->ends_at) - strtotime($this->mission->updated_at))) == strtotime($this->mission->updated_at)) {
            $this->mission->status = "terminée";
            $this->mission->save();
        }
    }
}
