<?php

namespace Dusterio\AwsWorker\Integrations;

use Dusterio\AwsWorker\Wrappers\DefaultWorker;
use Dusterio\AwsWorker\Wrappers\Laravel53Worker;
use Dusterio\AwsWorker\Wrappers\WorkerInterface;
use Dusterio\PlainSqs\Sqs\Connector;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Queue;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\QueueManager;
use Illuminate\Queue\Worker;
use Illuminate\Contracts\Debug\ExceptionHandler;

/**
 * Class CustomQueueServiceProvider
 * @package App\Providers
 */
class LaravelServiceProvider extends ServiceProvider
{
    use BindsWorker;

    /**
     * @return void
     */
    public function register()
    {
        if (function_exists('env') && ! env('REGISTER_WORKER_ROUTES', true)) return;

        $this->bindWorker();
        $this->addRoutes();
    }

    /**
     * @return void
     */
    protected function addRoutes()
    {
        $this->app['router']->post('/worker/schedule', 'Dusterio\AwsWorker\Controllers\WorkerController@schedule');
        $this->app['router']->post('/worker/queue', 'Dusterio\AwsWorker\Controllers\WorkerController@queue');
    }

    /**
     * @return void
     */
    public function boot()
    {
        $this->app->singleton(QueueManager::class, function() {
            return new QueueManager($this->app);
        });

        // If laravel version is 6 or above then the worker bindings change. So we initiate it here
        if ($this->app->version() >= 6) {
            $this->app->singleton(Worker::class, function () {
                $isDownForMaintenance = function () {
                    return $this->app->isDownForMaintenance();
                };

                return new Worker(
                    $this->app['queue'],
                    $this->app['events'],
                    $this->app[ExceptionHandler::class],
                    $isDownForMaintenance
                );
            });
        }
    }
}
