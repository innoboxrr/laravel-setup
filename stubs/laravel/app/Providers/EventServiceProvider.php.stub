<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Cache;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        $this->registerEventsAndObservers();
    }

    private function registerEventsAndObservers()
    {
        $cacheKey = 'app_events_and_observers';

        $data = Cache::remember($cacheKey, now()->addDay(), function () {
            return [
                'events' => $this->customDiscoverEvents(),
                'observers' => $this->customDiscoverObservers()
            ];
        });

        foreach ($data['events'] as $event => $listeners) {
            foreach ($listeners as $listener) {
                Event::listen($event, $listener);
            }
        }

        foreach ($data['observers'] as $model => $observer) {
            $model::observe($observer);
        }
    }

    protected function customDiscoverEvents()
    {
        $events = [];
        $basePath = realpath(__DIR__ . '/../Http/Events');
        $namespace = 'App\Http\Events\\';

        $modelDirs = glob("{$basePath}/*", GLOB_ONLYDIR);
        foreach ($modelDirs as $modelDir) {
            $modelName = basename($modelDir);
            $eventFiles = glob("{$modelDir}/Events/*.php", GLOB_BRACE);

            foreach ($eventFiles as $eventFile) {
                $eventName = pathinfo($eventFile, PATHINFO_FILENAME);
                $eventClass = "{$namespace}{$modelName}\\Events\\{$eventName}";

                $listenerFiles = glob("{$modelDir}/Listeners/{$eventName}/*.php", GLOB_BRACE);
                foreach ($listenerFiles as $listenerFile) {
                    $listenerName = pathinfo($listenerFile, PATHINFO_FILENAME);
                    $listenerClass = "{$namespace}{$modelName}\\Listeners\\{$eventName}\\{$listenerName}";

                    $events[$eventClass][] = $listenerClass;
                }
            }
        }

        return $events;
    }

    protected function customDiscoverObservers()
    {
        $observers = [];
        $modelsPath = realpath(__DIR__ . '/../Models');
        $observersPath = realpath(__DIR__ . '/../Observers');
        $namespaceModel = 'App\Models\\';
        $namespaceObserver = 'App\Observers\\';

        $modelFiles = glob("{$modelsPath}/*.php");
        foreach ($modelFiles as $modelFile) {
            $modelName = pathinfo($modelFile, PATHINFO_FILENAME);
            $modelClass = "{$namespaceModel}{$modelName}";
            $observerClass = "{$namespaceObserver}{$modelName}Observer";

            if (file_exists("{$observersPath}/{$modelName}Observer.php") && class_exists($modelClass) && class_exists($observerClass)) {
                $observers[$modelClass] = $observerClass;
            }
        }

        return $observers;
    }

}
