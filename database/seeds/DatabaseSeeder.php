<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//        Artisan::call('migrate:rollback');
        Artisan::call('migrate');
        factory(\DG\Dissertation\Admin\Models\Organizer::class, 10)
            ->create()
            ->each(function ($organizer) {
                factory(\DG\Dissertation\Admin\Models\Event::class, rand(10, 20))
                    ->create(['organizer_id' => $organizer->id])
                    ->each(function ($event) {
                        $validities = collect([
                            null,
                            json_encode([
                                'type' => 'both',
                                'date' => \Carbon\Carbon::parse($event->date)->subDay()->toDateTimeString(),
                                'amount' => rand(100, 460),
                            ]),
                            json_encode([
                                'type' => 'date',
                                'date' => \Carbon\Carbon::parse($event->date)->subDay()->toDateTimeString(),
                            ]),
                            json_encode([
                                'type' => 'amount',
                                'amount' => rand(100, 557),
                            ]),
                        ]);
                        /* Create ticket foreach event */
                        factory(\DG\Dissertation\Admin\Models\Ticket::class, rand(3, 5))->create([
                            'special_validity' => $validities->random(),
                            'event_id' => $event->id,
                        ]);
                        /* Create channel foreach event */
                        factory(\DG\Dissertation\Admin\Models\Channel::class, rand(3, 5))->create([
                            'event_id' => $event->id,
                        ])->each(function ($channel) {
                            factory(\DG\Dissertation\Admin\Models\Room::class, rand(5, 10))->create([
                                'channel_id' => $channel->id
                            ]);
                        });
                        /* Create speaker foreach event */
                        factory(\DG\Dissertation\Admin\Models\Speaker::class, rand(5, 10))->create([
                            'event_id' => $event->id,
                        ]);
                        /* Create speaker foreach event */
                        factory(\DG\Dissertation\Admin\Models\Partner::class, rand(5, 10))->create([
                            'event_id' => $event->id,
                        ]);
                        /* Create session type foreach event */
                        factory(\DG\Dissertation\Admin\Models\SessionType::class, 2)->create([
                            'event_id' => $event->id,
                        ]);
                        /* Create article foreach event */
                        factory(\DG\Dissertation\Admin\Models\Article::class, rand(10, 50))->create([
                            'event_id' => $event->id,
                        ]);
                    });
            });

        $events = \DG\Dissertation\Admin\Models\Event::all()->pluck('id');

        factory(\DG\Dissertation\Api\Models\Attendee::class, 200)->create()
            ->each(function ($attendee) use ($events) {
                $num = rand(50,120);
                for ($i = 0; $i <= $num; $i++) {
                    $event = $events->random();
                    $events = $events->filter(function ($item) use ($event) {
                        return $item != $event;
                    });
                    $tickets = \DG\Dissertation\Admin\Models\Event::find($event)->tickets->pluck('id');
                    $registration = new \DG\Dissertation\Admin\Models\Registration;
                    $registration->attendee_id = $attendee->id;
                    $registration->ticket_id = $tickets->random();
                    $registration->save();
                }
            });
    }
}
