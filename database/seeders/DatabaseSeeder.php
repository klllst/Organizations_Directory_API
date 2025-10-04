<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Building;
use App\Models\Organization;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $building1 = Building::create([
            'address' => 'г. Москва, ул. Ленина 1, офис 3',
            'latitude' => 55.755826,
            'longitude' => 37.617299
        ]);

        $building2 = Building::create([
            'address' => 'г. Москва, ул. Блюхера 32/1',
            'latitude' => 55.751244,
            'longitude' => 37.618423
        ]);

        $food = Activity::create(['name' => 'Еда', 'level' => 1]);
        $meat = Activity::create(['name' => 'Мясная продукция', 'parent_id' => $food->id, 'level' => 2]);
        $dairy = Activity::create(['name' => 'Молочная продукция', 'parent_id' => $food->id, 'level' => 2]);

        $cars = Activity::create(['name' => 'Автомобили', 'level' => 1]);
        $trucks = Activity::create(['name' => 'Грузовые', 'parent_id' => $cars->id, 'level' => 2]);
        $passenger = Activity::create(['name' => 'Легковые', 'parent_id' => $cars->id, 'level' => 2]);
        $parts = Activity::create(['name' => 'Запчасти', 'parent_id' => $passenger->id, 'level' => 3]);
        $accessories = Activity::create(['name' => 'Аксессуары', 'parent_id' => $passenger->id, 'level' => 3]);

        $org1 = Organization::create([
            'name' => 'ООО "Рога и Копыта"',
            'building_id' => $building1->id
        ]);
        $org1->phones()->createMany([
            ['number' => '2-222-222'],
            ['number' => '3-333-333'],
            ['number' => '8-923-666-13-13']
        ]);
        $org1->activities()->attach([$meat->id, $dairy->id]);

        $org2 = Organization::create([
            'name' => 'АвтоМир',
            'building_id' => $building2->id
        ]);
        $org2->phones()->create(['number' => '4-444-444']);
        $org2->activities()->attach([$parts->id, $accessories->id]);
    }
}
