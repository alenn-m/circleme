<?php

use App\Http\Models\Event;
use Faker\Factory;
use Illuminate\Database\Seeder;

class EventTableSeeder extends Seeder
{
    public function run()
    {
        Event::truncate();
        $faker = Factory::create();

        for($i=0;$i<=30;$i++){
            $event = new Event;
            $event->user_id = 1;
            $event->title = $faker->text(20);
            $event->description = $faker->paragraph(3);
            $event->image = 'http://lorempixel.com/640/400/';
            $event->lat = 40.7127837;
            $event->lng = -74.00594130000002;
            $event->time = 2200;
            $event->guestCanInvite = 1;
            $event->guestCanPublish = 1;
            $event->type = "public";
            $event->time = $faker->dateTimeBetween('now', '+20 days');
            $event->date = $faker->dateTimeBetween('now', '+20 days');

            $event->save();
        }
    }
}
