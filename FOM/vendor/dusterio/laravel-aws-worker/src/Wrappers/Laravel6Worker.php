<?php

namespace Dusterio\AwsWorker\Wrappers;

use Illuminate\Queue\Worker;
use Illuminate\Queue\WorkerOptions;
use Illuminate\Contracts\Cache\Repository as Cache;

/**
 * Class Laravel6Worker
 * @package Dusterio\AwsWorker\Wrappers
 */
class Laravel6Worker implements WorkerInterface
{
    /**
     * DefaultWorker constructor.
     * @param Worker $worker
     * @param  \Illuminate\Contracts\Cache\Repository  $cache
     */
    public function __construct(Worker $worker, Cache $cache)
    {
        $this->cache = $cache;
        $this->worker = $worker;
    }

    /**
     * @param $queue
     * @param $job
     * @param array $options
     * @return void
     */
    public function process($queue, $job, array $options)
    {
        $workerOptions = new WorkerOptions($options['delay'], 128, 60, 3, $options['maxTries']);

        $this->worker->process(
            $queue, $job, $workerOptions
        );
    }
}
