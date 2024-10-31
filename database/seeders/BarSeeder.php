<?php

namespace Database\Seeders;

use App\Models\Bar;
use Illuminate\Database\Seeder;

class BarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // Zona 1: Benidorm
            [
                'name' => 'Amanecer',
                'zone_id' => 1,
                'holder' => 'Amanecer 2017, S.L',
                'dni_cif' => 'B09948175',
                'address' => 'C/ Xalo Edf, Las Mimosas Bloque 1 Locales A0-B0-F0-G0',
                'town' => 'Finestrat',
            ],
            [
                'name' => '8 de Copes',
                'zone_id' => 1,
                'holder' => 'Jorge Ferrer Lloret',
                'dni_cif' => '48297885R',
                'address' => 'C/ San Pere, 8 bajo',
                'town' => 'Altea',
            ],
            [
                'name' => 'Pedrera',
                'zone_id' => 1,
                'holder' => 'Rte. La Pedrera S.C',
                'dni_cif' => 'G03327467',
                'address' => 'Pol. Industrial Pedrera',
                'town' => 'Benissa',
            ],
            [
                'name' => 'Maya',
                'zone_id' => 1,
                'holder' => 'Alexandra Daniela Luca',
                'dni_cif' => 'Y0860608P',
                'address' => 'Av Marina Baixa, 42 Esc. 1 Local 6 Edif. Cardenal III',
                'town' => 'Finestrat',
            ],
            [
                'name' => 'Pulpo Pirata',
                'zone_id' => 1,
                'holder' => 'Aperador Hnos. C.B',
                'dni_cif' => 'E53068433',
                'address' => 'Tomas Ortuño, 59',
                'town' => 'Benidorm',
            ],
            [
                'name' => 'Angel de Benidorm',
                'zone_id' => 1,
                'holder' => 'Jose Delgado Diaz',
                'dni_cif' => '48299344B',
                'address' => 'Esperanto, Local 10 Edif. Zeus',
                'town' => 'Benidorm',
            ],
            [
                'name' => 'Picadilly Mediterráneo',
                'zone_id' => 1,
                'holder' => 'Juan Berenguer Saval y Otros, C.B',
                'dni_cif' => 'E53994604',
                'address' => 'Av/ Mediterráneo, 23, Edif. Circo, L.5,6,7,8',
                'town' => 'Benidorm',
            ],
            [
                'name' => 'Las Tablas',
                'zone_id' => 1,
                'holder' => 'Frederick Alexandre Larre',
                'dni_cif' => 'Y8812560D',
                'address' => 'Av/ Cuenca, Edif. Monver VI L-2',
                'town' => 'Benidorm',
            ],
            [
                'name' => 'Picadilly',
                'zone_id' => 1,
                'holder' => 'Berenguer Aznar, S.C',
                'dni_cif' => 'J54706767',
                'address' => 'Av/ Ametlla de Mar C.C. Mercaloix Ent. C/ Gerona Nº11 L-5,6,7.',
                'town' => 'Benidorm',
            ],
            [
                'name' => 'Veneto',
                'zone_id' => 1,
                'holder' => 'Jofran, S.C',
                'dni_cif' => 'G03882891',
                'address' => 'Av/ Filipinas, Edif Trebol, Local 4-5',
                'town' => 'Benidorm',
            ],
            [
                'name' => 'Zarcar',
                'zone_id' => 1,
                'holder' => 'Zarcar SL',
                'dni_cif' => 'B03787710',
                'address' => 'Pais Valencia, 120 Bajo Local 1',
                'town' => 'Finestrat',
            ],
            [
                'name' => 'Albeniz',
                'zone_id' => 1,
                'holder' => 'Jose Miguel Garcia Gomez',
                'dni_cif' => '46694162E',
                'address' => 'Herreria Edif. Albeniz L-8A',
                'town' => 'Alfaz del Pi',
            ],
            [
                'name' => 'Puntxaetes',
                'zone_id' => 1,
                'holder' => 'Julian Jimenez Garcia',
                'dni_cif' => '48679635C',
                'address' => 'C/ Pianista Gonzalo Soriano Nº3 Local 2',
                'town' => 'Villajoyosa',
            ],
            [
                'name' => 'Yorkos',
                'zone_id' => 1,
                'holder' => 'Plamenov Services 2015, S.L',
                'dni_cif' => 'B54885207',
                'address' => 'Av/ Rosa Dels Vents, 7 Edif. Gemelos 24 Bq 1 Esq C/ Marinada L14',
                'town' => 'Villajoyosa',
            ],
            [
                'name' => 'El Sol',
                'zone_id' => 1,
                'holder' => 'Victoria Perez Selles',
                'dni_cif' => '20027337H',
                'address' => 'Evaristo Manero, 9 Bajo',
                'town' => 'Relleu',
            ],
            [
                'name' => 'La Grada Deportiva',
                'zone_id' => 1,
                'holder' => 'Bar Grada Deportiva, S.L',
                'dni_cif' => 'B44623023',
                'address' => 'Av/ Marina Baixa, 2 Local 3',
                'town' => 'La Nucia',
            ],
            [
                'name' => 'Bulevar Benidorm',
                'zone_id' => 1,
                'holder' => 'Luz Yanett Gordillo Ordoñez',
                'dni_cif' => 'Y7885635F',
                'address' => 'Av.Alfonso Puchadas Edif. Marina Finestrat Nº2 Bajo Local 2',
                'town' => 'Benidorm',
            ],
            [
                'name' => 'New Litte',
                'zone_id' => 1,
                'holder' => 'Victor Oswaldo Benitez Navarro',
                'dni_cif' => '29026313Z',
                'address' => 'Les Aigües, Local 3, Edif. Coblança, 28',
                'town' => 'Benidorm',
            ],

            // Zona 2: Alicante
            [
                'name' => 'Maigmo',
                'zone_id' => 2,
                'holder' => 'Jose Torres Moreno',
                'dni_cif' => '21415145Y',
                'address' => 'Ctra. Castalla A-213, Km 0,8',
                'town' => 'Tibi',
            ],
            [
                'name' => 'Canto',
                'zone_id' => 2,
                'holder' => 'Sisp Oe',
                'dni_cif' => 'E72541212',
                'address' => 'Ibi, 13 Bajo Izquierda L-1 Esc D',
                'town' => 'San Vicente',
            ],
            [
                'name' => 'Angel de Santa Pola',
                'zone_id' => 2,
                'holder' => 'Angel Ramon Rodenas Rico',
                'dni_cif' => '74235696E',
                'address' => 'Caridad, 26',
                'town' => 'Santa Pola',
            ],
            [
                'name' => 'Picaeta',
                'zone_id' => 2,
                'holder' => 'Francisco Rico Aliaga',
                'dni_cif' => '48343779X',
                'address' => 'Vicente Alexandre, 13 Urb. Res. Parque Lo Morant',
                'town' => 'Alicante',
            ],
            [
                'name' => 'Starkoffe',
                'zone_id' => 2,
                'holder' => 'Marcos Hernandez Pastor',
                'dni_cif' => '48627660W',
                'address' => 'C/ Maestro Latorre, 28 Bajo',
                'town' => 'Alicante',
            ],
            [
                'name' => 'Caballer',
                'zone_id' => 2,
                'holder' => 'Raquel Caballer Herrero',
                'dni_cif' => '48578283Y',
                'address' => 'C/ Xalo Edf, Las Mimosas Bloque 1 Locales A0-B0-F0-G0',
                'town' => 'Finestrat',
            ],
            [
                'name' => 'Bulevar',
                'zone_id' => 2,
                'holder' => 'Di Tella y Di Mare C.B.',
                'dni_cif' => 'E54167572',
                'address' => 'Deportista Kiko Sanchez, 1 Edif. Park Lane',
                'town' => 'Alicante',
            ],
            [
                'name' => 'Parada',
                'zone_id' => 2,
                'holder' => 'Arguirus Group, S.L',
                'dni_cif' => 'B56205727',
                'address' => 'C/ Isidoro de Sevilla, 44 Esquina Beato de Cadiz',
                'town' => 'Alicante',
            ],
            [
                'name' => 'D´Angelo',
                'zone_id' => 2,
                'holder' => 'Rio Vista S.L.U',
                'dni_cif' => 'B42620146',
                'address' => 'Gabriel y Galan, 1',
                'town' => 'Alicante',
            ],
            [
                'name' => 'De Aca y Alla',
                'zone_id' => 2,
                'holder' => 'Pulpo Investment S.L',
                'dni_cif' => 'B72451032',
                'address' => 'C/ Deportista Manuel Suarez, Local 1',
                'town' => 'Alicante',
            ],

            // Zona 3: Javea
            [
                'name' => 'Sport',
                'zone_id' => 3,
                'holder' => 'Maria Lucia Morales Lopez',
                'dni_cif' => '74005647L',
                'address' => 'Pza Ifach, 4 Edif. Garbimar, Esc 1 Bj Local 3, Entrada por C/ Jazmines, 8A',
                'town' => 'Calpe',
            ],
            [
                'name' => 'Mas y Mas',
                'zone_id' => 3,
                'holder' => 'Jose Vicente Navarro Todoli',
                'dni_cif' => '19988826D',
                'address' => 'Ctra. Valencia-Alicante, N-332, Km.164 (Ds Oqui, 31)',
                'town' => 'Pedreguer',
            ],

            // Zona 4: Denia
            [
                'name' => 'Casa Llauis',
                'zone_id' => 4,
                'holder' => 'Carlos Sanchez Soriano',
                'dni_cif' => '28992366S',
                'address' => 'Av/ de Gandia, 20, Esc 3 Local 4 Entrada por C/ Lliber',
                'town' => 'Denia',
            ],
            [
                'name' => 'Havanna',
                'zone_id' => 4,
                'holder' => 'Juan Carlos Hernandez Melia',
                'dni_cif' => '28992351T',
                'address' => 'C/ Patricio Ferrandiz, 69 Bajo Local 3 Entrada por C/ La Via 36 A',
                'town' => 'Denia',
            ],
            [
                'name' => 'Coratge',
                'zone_id' => 4,
                'holder' => 'Maria Angeles Femenia Rosello',
                'dni_cif' => '28994316X',
                'address' => 'Av/ Denia, 25',
                'town' => 'Beniarbeig',
            ],
            [
                'name' => 'Tramusser',
                'zone_id' => 4,
                'holder' => 'Luis Miguel Rivas Rivas',
                'dni_cif' => '11894404T',
                'address' => 'C/ Santa Ana Nº6 Bajo',
                'town' => 'Vall de L´Aguar',
            ],
            [
                'name' => 'Karma',
                'zone_id' => 4,
                'holder' => 'Ruben Ribes Garcia',
                'dni_cif' => '53217500P',
                'address' => 'C/ Segaria, 8 Esc. 1 Bajo Local 1',
                'town' => 'Ondara',
            ],
            [
                'name' => 'Madrigueres 64',
                'zone_id' => 4,
                'holder' => 'Gheorghe Alin Stanca',
                'dni_cif' => 'Z0112175D',
                'address' => 'Ptda Madrigueres Sud, 64A Local 1',
                'town' => 'Denia',
            ],

            // Zona 5: Taller
            [
                'name' => 'Bar 1 Taller',
                'zone_id' => 5,
                'holder' => 'xxx',
                'dni_cif' => 'xxxxx',
                'address' => 'xxxxxxxx',
                'town' => 'xxxxxxxxxx',
            ],
            [
                'name' => 'Bar 2 Taller',
                'zone_id' => 5,
                'holder' => 'xxx',
                'dni_cif' => 'xxxxx',
                'address' => 'xxxxxxxx',
                'town' => 'xxxxxxxxxx',
            ],
            [
                'name' => 'Bar 3 Taller',
                'zone_id' => 5,
                'holder' => 'xxx',
                'dni_cif' => 'xxxxx',
                'address' => 'xxxxxxxx',
                'town' => 'xxxxxxxxxx',
            ],
            [
                'name' => 'Bar 4 Taller',
                'zone_id' => 5,
                'holder' => 'xxx',
                'dni_cif' => 'xxxxx',
                'address' => 'xxxxxxxx',
                'town' => 'xxxxxxxxxx',
            ],
        ];

        // Recorremos los datos y creamos los registros correspondientes en la base de datos.
        collect($data)->each(function ($bar) {
            Bar::create([
                'name' => $bar['name'],
                'zone_id' => $bar['zone_id'],
                'holder' => $bar['holder'],
                'dni_cif' => $bar['dni_cif'],
                'address' => $bar['address'],
                'town' => $bar['town'],
            ]);
        });
    }
}
