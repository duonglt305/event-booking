<?php


namespace DG\Dissertation\Api\Providers;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'DG\Dissertation\Api\Events\Registered' => [
            'DG\Dissertation\Api\Listeners\SendEmailVerificationNotification',
        ],
        'DG\Dissertation\Api\Events\Verified' => [
            'DG\Dissertation\Api\Listeners\LogVerifiedAttendee',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}

