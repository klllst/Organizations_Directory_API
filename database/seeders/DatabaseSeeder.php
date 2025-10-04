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
        $buildings = [
            [
                'address' => [
                    'city' => 'Москва',
                    'street' => 'ул. Ленина',
                    'house' => '1',
                ],
                'latitude' => 55.755826,
                'longitude' => 37.617299,
            ],
            [
                'address' => [
                    'city' => 'Москва',
                    'street' => 'ул. Блюхера',
                    'house' => '32/1',
                ],
                'latitude' => 55.751244,
                'longitude' => 37.618423,
            ],
            [
                'address' => [
                    'city' => 'Москва',
                    'street' => 'ул. Тверская',
                    'house' => '15, стр. 1',
                ],
                'latitude' => 55.760241,
                'longitude' => 37.607421,
            ],
            [
                'address' => [
                    'city' => 'Москва',
                    'street' => 'пр. Мира',
                    'house' => '25',
                ],
                'latitude' => 55.781568,
                'longitude' => 37.633324,
            ],
            [
                'address' => [
                    'city' => 'Москва',
                    'street' => 'ул. Новый Арбат',
                    'house' => '21',
                ],
                'latitude' => 55.752220,
                'longitude' => 37.592579,
            ],
            [
                'address' => [
                    'city' => 'Москва',
                    'street' => 'ул. Пушкина',
                    'house' => '10',
                ],
                'latitude' => 55.764912,
                'longitude' => 37.606857,
            ],
            [
                'address' => [
                    'city' => 'Москва',
                    'street' => 'Кутузовский проспект',
                    'house' => '32',
                ],
                'latitude' => 55.742046,
                'longitude' => 37.534121,
            ],
            [
                'address' => [
                    'city' => 'Москва',
                    'street' => 'Ленинградский проспект',
                    'house' => '47',
                ],
                'latitude' => 55.796391,
                'longitude' => 37.535351,
            ],
        ];

        $buildingModels = [];
        foreach ($buildings as $building) {
            $buildingModels[] = Building::create($building);
        }

        $food = Activity::create(['name' => 'Еда', 'level' => 1]);
        $meat = Activity::create(['name' => 'Мясная продукция', 'parent_id' => $food->id, 'level' => 2]);
        $dairy = Activity::create(['name' => 'Молочная продукция', 'parent_id' => $food->id, 'level' => 2]);
        $bakery = Activity::create(['name' => 'Хлебобулочные изделия', 'parent_id' => $food->id, 'level' => 2]);
        $beverages = Activity::create(['name' => 'Напитки', 'parent_id' => $food->id, 'level' => 2]);

        $beef = Activity::create(['name' => 'Говядина', 'parent_id' => $meat->id, 'level' => 3]);
        $pork = Activity::create(['name' => 'Свинина', 'parent_id' => $meat->id, 'level' => 3]);
        $poultry = Activity::create(['name' => 'Птица', 'parent_id' => $meat->id, 'level' => 3]);

        $milk = Activity::create(['name' => 'Молоко', 'parent_id' => $dairy->id, 'level' => 3]);
        $cheese = Activity::create(['name' => 'Сыры', 'parent_id' => $dairy->id, 'level' => 3]);
        $yogurt = Activity::create(['name' => 'Йогурты', 'parent_id' => $dairy->id, 'level' => 3]);

        $cars = Activity::create(['name' => 'Автомобили', 'level' => 1]);
        $trucks = Activity::create(['name' => 'Грузовые', 'parent_id' => $cars->id, 'level' => 2]);
        $passenger = Activity::create(['name' => 'Легковые', 'parent_id' => $cars->id, 'level' => 2]);
        $parts = Activity::create(['name' => 'Запчасти', 'parent_id' => $passenger->id, 'level' => 3]);
        $accessories = Activity::create(['name' => 'Аксессуары', 'parent_id' => $passenger->id, 'level' => 3]);
        $tires = Activity::create(['name' => 'Шины и диски', 'parent_id' => $passenger->id, 'level' => 3]);

        $electronics = Activity::create(['name' => 'Электроника', 'level' => 1]);
        $computers = Activity::create(['name' => 'Компьютеры', 'parent_id' => $electronics->id, 'level' => 2]);
        $phones = Activity::create(['name' => 'Телефоны', 'parent_id' => $electronics->id, 'level' => 2]);
        $homeAppliances = Activity::create(['name' => 'Бытовая техника', 'parent_id' => $electronics->id, 'level' => 2]);

        $laptops = Activity::create(['name' => 'Ноутбуки', 'parent_id' => $computers->id, 'level' => 3]);
        $desktops = Activity::create(['name' => 'Настольные компьютеры', 'parent_id' => $computers->id, 'level' => 3]);
        $components = Activity::create(['name' => 'Комплектующие', 'parent_id' => $computers->id, 'level' => 3]);

        $clothing = Activity::create(['name' => 'Одежда', 'level' => 1]);
        $mensClothing = Activity::create(['name' => 'Мужская одежда', 'parent_id' => $clothing->id, 'level' => 2]);
        $womensClothing = Activity::create(['name' => 'Женская одежда', 'parent_id' => $clothing->id, 'level' => 2]);
        $childrensClothing = Activity::create(['name' => 'Детская одежда', 'parent_id' => $clothing->id, 'level' => 2]);

        $services = Activity::create(['name' => 'Услуги', 'level' => 1]);
        $financial = Activity::create(['name' => 'Финансовые услуги', 'parent_id' => $services->id, 'level' => 2]);
        $legal = Activity::create(['name' => 'Юридические услуги', 'parent_id' => $services->id, 'level' => 2]);
        $medical = Activity::create(['name' => 'Медицинские услуги', 'parent_id' => $services->id, 'level' => 2]);

        $organizations = [
            [
                'name' => 'ООО "Рога и Копыта"',
                'building_id' => $buildingModels[0]->id,
                'phones' => ['2-222-222', '3-333-333', '8-923-666-13-13'],
                'activities' => [$meat->id, $dairy->id],
            ],
            [
                'name' => 'ЗАО "Мясной двор"',
                'building_id' => $buildingModels[1]->id,
                'phones' => ['5-555-555', '8-900-123-45-67'],
                'activities' => [$beef->id, $pork->id],
            ],
            [
                'name' => 'ОАО "Молокозавод №1"',
                'building_id' => $buildingModels[2]->id,
                'phones' => ['6-666-666', '8-901-234-56-78'],
                'activities' => [$milk->id, $cheese->id, $yogurt->id],
            ],
            [
                'name' => 'ИП Сидоров "Свежий хлеб"',
                'building_id' => $buildingModels[3]->id,
                'phones' => ['7-777-777'],
                'activities' => [$bakery->id],
            ],
            [
                'name' => 'ООО "Напитки Сибири"',
                'building_id' => $buildingModels[4]->id,
                'phones' => ['8-888-888', '8-902-345-67-89'],
                'activities' => [$beverages->id],
            ],

            [
                'name' => 'АвтоМир',
                'building_id' => $buildingModels[5]->id,
                'phones' => ['4-444-444'],
                'activities' => [$parts->id, $accessories->id],
            ],
            [
                'name' => 'ООО "Грузовики-Сервис"',
                'building_id' => $buildingModels[6]->id,
                'phones' => ['9-999-999', '8-903-456-78-90'],
                'activities' => [$trucks->id],
            ],
            [
                'name' => 'Автосалон "Престиж"',
                'building_id' => $buildingModels[7]->id,
                'phones' => ['1-111-111', '8-904-567-89-01'],
                'activities' => [$passenger->id],
            ],
            [
                'name' => 'Магазин "Шины-Онлайн"',
                'building_id' => $buildingModels[0]->id,
                'phones' => ['2-123-456'],
                'activities' => [$tires->id],
            ],

            [
                'name' => 'ООО "Компьютерный мир"',
                'building_id' => $buildingModels[1]->id,
                'phones' => ['3-234-567', '8-905-678-90-12'],
                'activities' => [$laptops->id, $desktops->id],
            ],
            [
                'name' => 'Салон связи "МегаФон"',
                'building_id' => $buildingModels[2]->id,
                'phones' => ['4-345-678'],
                'activities' => [$phones->id],
            ],
            [
                'name' => 'Магазин "Бытовая техника"',
                'building_id' => $buildingModels[3]->id,
                'phones' => ['5-456-789', '8-906-789-01-23'],
                'activities' => [$homeAppliances->id],
            ],
            [
                'name' => 'Интернет-магазин "Комплектующие.ру"',
                'building_id' => $buildingModels[4]->id,
                'phones' => ['6-567-890'],
                'activities' => [$components->id],
            ],

            [
                'name' => 'Бутик "Мужская классика"',
                'building_id' => $buildingModels[5]->id,
                'phones' => ['7-678-901'],
                'activities' => [$mensClothing->id],
            ],
            [
                'name' => 'Магазин "Женский стиль"',
                'building_id' => $buildingModels[6]->id,
                'phones' => ['8-789-012', '8-907-890-12-34'],
                'activities' => [$womensClothing->id],
            ],
            [
                'name' => 'Детский мир "Радуга"',
                'building_id' => $buildingModels[7]->id,
                'phones' => ['9-890-123'],
                'activities' => [$childrensClothing->id],
            ],

            [
                'name' => 'Банк "Финансовый партнер"',
                'building_id' => $buildingModels[0]->id,
                'phones' => ['1-901-234', '8-908-901-23-45'],
                'activities' => [$financial->id],
            ],
            [
                'name' => 'Юридическая фирма "Право и закон"',
                'building_id' => $buildingModels[1]->id,
                'phones' => ['2-012-345'],
                'activities' => [$legal->id],
            ],
            [
                'name' => 'Медицинский центр "Здоровье"',
                'building_id' => $buildingModels[2]->id,
                'phones' => ['3-123-456', '8-909-012-34-56'],
                'activities' => [$medical->id],
            ],

            [
                'name' => 'Супермаркет "Продукты 24/7"',
                'building_id' => $buildingModels[3]->id,
                'phones' => ['4-234-567'],
                'activities' => [$food->id, $beverages->id],
            ],
            [
                'name' => 'Автосервис "Мастер"',
                'building_id' => $buildingModels[4]->id,
                'phones' => ['5-345-678', '8-910-123-45-67'],
                'activities' => [$parts->id],
            ],
            [
                'name' => 'IT компания "ТехноСофт"',
                'building_id' => $buildingModels[5]->id,
                'phones' => ['6-456-789'],
                'activities' => [$computers->id, $components->id],
            ],
            [
                'name' => 'Аптека "Фармацевт"',
                'building_id' => $buildingModels[6]->id,
                'phones' => ['7-567-890'],
                'activities' => [$medical->id],
            ],
            [
                'name' => 'Строительная компания "СтройГарант"',
                'building_id' => $buildingModels[7]->id,
                'phones' => ['8-678-901', '8-911-234-56-78'],
                'activities' => [$services->id],
            ],
        ];

        foreach ($organizations as $orgData) {
            $org = Organization::create([
                'name' => $orgData['name'],
                'building_id' => $orgData['building_id'],
            ]);

            foreach ($orgData['phones'] as $phone) {
                $org->phones()->create(['number' => $phone]);
            }

            $org->activities()->attach($orgData['activities']);
        }

        $additionalOrgs = [
            [
                'name' => 'Кафе "Уют"',
                'building_id' => $buildingModels[0]->id,
                'phones' => ['1-234-567'],
                'activities' => [$food->id],
            ],
            [
                'name' => 'Ресторан "Гурман"',
                'building_id' => $buildingModels[1]->id,
                'phones' => ['2-345-678'],
                'activities' => [$food->id, $beverages->id],
            ],
            [
                'name' => 'Столовая "Вкусно и точка"',
                'building_id' => $buildingModels[2]->id,
                'phones' => ['3-456-789'],
                'activities' => [$food->id],
            ],
        ];

        foreach ($additionalOrgs as $orgData) {
            $org = Organization::create([
                'name' => $orgData['name'],
                'building_id' => $orgData['building_id'],
            ]);

            foreach ($orgData['phones'] as $phone) {
                $org->phones()->create(['number' => $phone]);
            }

            $org->activities()->attach($orgData['activities']);
        }

        $this->command->info('База данных заполнена тестовыми данными:');
        $this->command->info('- '.count($buildingModels).' зданий');
        $this->command->info('- '.Activity::count().' видов деятельности');
        $this->command->info('- '.Organization::count().' организаций');
    }
}
