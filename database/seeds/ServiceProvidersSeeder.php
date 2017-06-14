<?php

use App\Keyword;
use Illuminate\Database\Seeder;

class ServiceProvidersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $services = [
            [
                'service_code' => '172',
                'service_name' => 'Vandalism',
                'description' => 'Give feedback if you find that property or equipment is broken.',
                'group' => 'Sanitation',
                'keywords' => [
                    'bench', 'parks', 'trashbins'
                ],
            ], [
                'service_code' => '246',
                'service_name' => 'Sanitation violation',
                'description' => 'Report if you find garbage or overflowing trash bins.',
                'group' => 'Sanitation',
                'keywords' => [
                    'garbage', 'debris'
                ],
            ], [
                'service_code' => '176',
                'service_name' => 'Graffiti removal',
                'description' => 'Report if graffiti or other paintings need removal.',
                'group' => 'Sanitation',
                'keywords' => [
                    'graffiti',
                ],
            ], [
                'service_code' => '171',
                'service_name' => 'Potholes',
                'description' => 'Report potholes in public streets.',
                'group' => 'Traffic and street condition',
                'keywords' => [
                    'pothole', 'street condition'
                ],
            ], [
                'service_code' => '198',
                'service_name' => 'Traffic signs',
                'description' => 'Report broken traffic signs.',
                'group' => 'Traffic and street condition',
                'keywords' => [
                    'traffic sign',
                ],
            ], [
                'service_code' => '199',
                'service_name' => 'Info signs',
                'description' => 'Report if info signs or other signs need attention.',
                'group' => 'Traffic and street condition',
                'keywords' => [
                    'info sign',
                ],
            ], [
                'service_code' => '174',
                'service_name' => 'Parks',
                'description' => 'Report if something in the park needs fixing.',
                'group' => 'Parks and forests',
                'keywords' => [
                    'parks', 'flower', 'bush'
                ],
            ], [
                'service_code' => '211',
                'service_name' => 'Playgrounds and sports parks',
                'description' => 'Report if equipment in the playgrounds or sport parks are broken or something else there needs fixing.',
                'group' => 'Parks and forests',
                'keywords' => [
                    'leikkipuisto', 'liikuntapaikka'
                ],
            ], [
                'service_code' => '234',
                'service_name' => 'Forests',
                'description' => 'Report if something in forests needs to be taken care of.',
                'group' => 'Parks and forests',
                'keywords' => [
                    'forest', 'field'
                ],
            ], [
                'service_code' => '180',
                'service_name' => 'Other issues to be fixed',
                'description' => 'Use this category if you have found something broken and it does not fit into other categories.',
                'group' => 'Other',
                'keywords' => [
                ],
            ], [
                'service_code' => '2805',
                'service_name' => 'Education',
                'description' => 'Education.',
                'group' => 'Sectors',
                'keywords' => [
                    'education', 'basic education', 'general upper secondary education', 'vocational education', 'services in Swedish'
                ],
            ], [
                'service_code' => '2806',
                'service_name' => 'City environment',
                'description' => 'City environment',
                'group' => 'Sectors',
                'keywords' => [
                    'land use', 'city structure', 'buildings', 'public areas', 'permits'
                ],
            ], [
                'service_code' => '2807',
                'service_name' => 'Culture and leisure',
                'description' => 'Culture and leisure',
                'group' => 'Sectors',
                'keywords' => [
                    'culture', 'sports', 'youth'
                ],
            ], [
                'service_code' => '2808',
                'service_name' => 'Social services and health care',
                'description' => 'Social services and health care',
                'group' => 'Sectors',
                'keywords' => [
                    'family services', 'social services', 'health services', 'hospital services', 'rehabilitation services', 'health care services'
                ],
            ], [
                'service_code' => '2809',
                'service_name' => 'General and other feedback',
                'description' => 'Feedback concerning multiple sectors or the central administration.',
                'group' => 'Sectors',
                'keywords' => [
                    'general feedback', 'other feedback'
                ],
            ]
        ];

        foreach($services as $service) {
            $tempService = factory('App\Service')->create([
                'service_code' => $service['service_code'],
                'service_name' => $service['service_name'],
                'description' => $service['description'],
                'group' => $service['group'],
            ]);

            if(is_array($service['keywords']) && count($service['keywords']) > 0) {
                foreach($service['keywords'] as $keyword) {
                    $keywordModel = Keyword::firstOrNew(['name' => $keyword]);
                    $tempService->keywords()->save($keywordModel);
                }
            }
        }
    }
}
