<?php

namespace Database\Seeders;

use App\Models\Bar;
use App\Models\Local;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Machine;


class MachinesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $maquinasSalones = [
            // Denia
            ['identificador' => 'B:GNQ:14 V:009662', 'alias' => 'GNOMOS MIX', 'nombre' => 'GNOMOS MIX 500', 'local' => 'Denia'],
            ['identificador' => 'B:BLQ:16 V:016641', 'alias' => 'BURLESQUE', 'nombre' => 'BURLESQUE 500', 'local' => 'Denia'],
            ['identificador' => 'B:MB3:18AV:001845', 'alias' => 'M-BOX A', 'nombre' => 'MERKUR BOX 1000', 'local' => 'Denia'],
            ['identificador' => 'B:MB3:18BV:001845', 'alias' => 'M-BOX B', 'nombre' => 'MERKUR BOX 1000', 'local' => 'Denia'],
            ['identificador' => 'B:MB3:18CV:001845', 'alias' => 'M-BOX C', 'nombre' => 'MERKUR BOX 1000', 'local' => 'Denia'],
            ['identificador' => 'B:DR8:18 V:006083', 'alias' => 'RULETA', 'nombre' => 'MINISTAR 1000', 'local' => 'Denia'],
            ['identificador' => 'B:CHM:18 V:002829', 'alias' => 'CHIRINGUITO', 'nombre' => 'CHIRINGUITO 1000', 'local' => 'Denia'],
            ['identificador' => 'B:MA3:21AV:103883', 'alias' => 'M-MAX A', 'nombre' => 'MERKUR MAX 1000', 'local' => 'Denia'],
            ['identificador' => 'B:MA3:21BV:103883', 'alias' => 'M-MAX B', 'nombre' => 'MERKUR MAX 1000', 'local' => 'Denia'],
            ['identificador' => 'B:MA3:21CV:103883', 'alias' => 'M-MAX C', 'nombre' => 'MERKUR MAX 1000', 'local' => 'Denia'],
            ['identificador' => 'B:IX3:21AV:025090', 'alias' => 'IMPERA A', 'nombre' => 'IMPERA LINK 1000', 'local' => 'Denia'],
            ['identificador' => 'B:IX3:21BV:025090', 'alias' => 'IMPERA B', 'nombre' => 'IMPERA LINK 1000', 'local' => 'Denia'],
            ['identificador' => 'B:IX3:21CV:025090', 'alias' => 'IMPERA C', 'nombre' => 'IMPERA LINK 1000', 'local' => 'Denia'],
            ['identificador' => 'B:REY:19 V:003325', 'alias' => 'REY DE LA SUERTE', 'nombre' => 'REY DE LA SUERTE 500', 'local' => 'Denia'],

            // Javea
            ['identificador' => 'B:DOQ:16 V:015604', 'alias' => 'DORADO', 'nombre' => 'EL DORADO 500', 'local' => 'Javea'],
            ['identificador' => 'B:MB3:18AV:001853', 'alias' => 'M-BOX A', 'nombre' => 'MERKUR-BOX 100', 'local' => 'Javea'],
            ['identificador' => 'B:MB3:18BV:001853', 'alias' => 'M-BOX B', 'nombre' => 'MERKUR-BOX 100', 'local' => 'Javea'],
            ['identificador' => 'B:MB3:18CV:001853', 'alias' => 'M-BOX C', 'nombre' => 'MERKUR-BOX 100', 'local' => 'Javea'],
            ['identificador' => 'B:CHM:18 V:002828', 'alias' => 'CHIRINGUITO', 'nombre' => 'CHIRINGUITO SALON1000', 'local' => 'Javea'],
            ['identificador' => 'B:RG8:18 :000128', 'alias' => 'RULETA', 'nombre' => 'RULETA COMATEL 1000', 'local' => 'Javea'],
            ['identificador' => 'B:PN3:20AV:021128', 'alias' => 'POWER LINK A', 'nombre' => 'POWER LINK 1000', 'local' => 'Javea'],
            ['identificador' => 'B:PN3:20BV:021128', 'alias' => 'POWER LINK B', 'nombre' => 'POWER LINK 1000', 'local' => 'Javea'],
            ['identificador' => 'B:PN3:20CV:021128', 'alias' => 'POWER LINK C', 'nombre' => 'POWER LINK 1000', 'local' => 'Javea'],
            ['identificador' => 'B:IX3:21AV:024244', 'alias' => 'IMPERA A', 'nombre' => 'IMPERA LINK 1000', 'local' => 'Javea'],
            ['identificador' => 'B:IX3:21BV:024244', 'alias' => 'IMPERA B', 'nombre' => 'IMPERA LINK 1000', 'local' => 'Javea'],
            ['identificador' => 'B:IX3:21CV:024244', 'alias' => 'IMPERA C', 'nombre' => 'IMPERA LINK 1000', 'local' => 'Javea'],
            ['identificador' => 'B:MA3:21AV:104193', 'alias' => 'M-MAX A', 'nombre' => 'MERKUR MAX 3000', 'local' => 'Javea'],
            ['identificador' => 'B:MA3:21BV:104193', 'alias' => 'M-MAX B', 'nombre' => 'MERKUR MAX 3000', 'local' => 'Javea'],
            ['identificador' => 'B:MA3:21CV:104193', 'alias' => 'M-MAX C', 'nombre' => 'MERKUR MAX 3000', 'local' => 'Javea'],
            ['identificador' => 'B:AS3:18AV:000045', 'alias' => 'ACTION STAR A', 'nombre' => 'ACTION STAR 1000', 'local' => 'Javea'],
            ['identificador' => 'B:AS3:18BV:000045', 'alias' => 'ACTION STAR B', 'nombre' => 'ACTION STAR 1000', 'local' => 'Javea'],
            ['identificador' => 'B:AS3:18CV:000045', 'alias' => 'ACTION STAR C', 'nombre' => 'ACTION STAR 1000', 'local' => 'Javea'],
            ['identificador' => 'B:NEQ:16 V:003802', 'alias' => 'NEOPOLIS', 'nombre' => 'NEOPOLIS 500', 'local' => 'Javea'],
            ['identificador' => 'B:LT3:23AV:001327', 'alias' => 'LINK MASTER A', 'nombre' => 'LINK MASTER 3000', 'local' => 'Javea'],
            ['identificador' => 'B:LT3:23BV:001327', 'alias' => 'LINK MASTER B', 'nombre' => 'LINK MASTER 3000', 'local' => 'Javea'],
            ['identificador' => 'B:LT3:23CV:001327', 'alias' => 'LINK MASTER C', 'nombre' => 'LINK MASTER 3000', 'local' => 'Javea'],

            // Jaime Segarra
            ['identificador' => 'B:GNM:06 V:007854', 'alias' => 'GNOMOS', 'nombre' => 'GNOMO TRIPLE 240', 'local' => 'Jaime Segarra'],
            ['identificador' => 'B:SFL:07 V:003670', 'alias' => 'SANTA FE', 'nombre' => 'SANTA FE LOTO TRIPLE 240', 'local' => 'Jaime Segarra'],
            ['identificador' => 'B:WOT:12 V:000193', 'alias' => 'WOONSTERS', 'nombre' => 'GIGAMES WOONSTERS SALON 500', 'local' => 'Jaime Segarra'],
            ['identificador' => 'B:GNQ:14 V:007844', 'alias' => 'GNOMOS MIX', 'nombre' => 'GNOMOS MIX 500', 'local' => 'Jaime Segarra'],
            ['identificador' => 'B:BLQ:16 V:016630', 'alias' => 'BURLESQUE', 'nombre' => 'BURLESQUE 500', 'local' => 'Jaime Segarra'],
            ['identificador' => 'B:AS3:17AV:000029', 'alias' => 'ACTION STAR A', 'nombre' => 'ACTION STAR 1000', 'local' => 'Jaime Segarra'],
            ['identificador' => 'B:AS3:17BV:000029', 'alias' => 'ACTION STAR B', 'nombre' => 'ACTION STAR 1000', 'local' => 'Jaime Segarra'],
            ['identificador' => 'B:AS3:17CV:000029', 'alias' => 'ACTION STAR C', 'nombre' => 'ACTION STAR 1000', 'local' => 'Jaime Segarra'],
            ['identificador' => 'B:MA3:21AV:103654', 'alias' => 'M-MAX A', 'nombre' => 'MERKUR MAX 1000', 'local' => 'Jaime Segarra'],
            ['identificador' => 'B:MA3:21BV:103654', 'alias' => 'M-MAX B', 'nombre' => 'MERKUR MAX 1000', 'local' => 'Jaime Segarra'],
            ['identificador' => 'B:MA3:21CV:103654', 'alias' => 'M-MAX C', 'nombre' => 'MERKUR MAX 1000', 'local' => 'Jaime Segarra'],
            ['identificador' => 'B:DR8:18 V:002021', 'alias' => 'RULETA', 'nombre' => 'MINISTAR 1000', 'local' => 'Jaime Segarra'],
            ['identificador' => 'B:LT3:23AV:001123', 'alias' => 'LINK MASTER A', 'nombre' => 'LINK MASTER 3000', 'local' => 'Jaime Segarra'],
            ['identificador' => 'B:LT3:23BV:001123', 'alias' => 'LINK MASTER B', 'nombre' => 'LINK MASTER 3000', 'local' => 'Jaime Segarra'],
            ['identificador' => 'B:LT3:23CV:001123', 'alias' => 'LINK MASTER C', 'nombre' => 'LINK MASTER 3000', 'local' => 'Jaime Segarra'],

            // Villajoyosa
            ['identificador' => 'B:SFL:07 V:002244', 'alias' => 'SANTA FE', 'nombre' => 'SANTA FE LOTO TRIPLE 240', 'local' => 'Villajoyosa'],
            ['identificador' => 'B:WOT:12 V:000202', 'alias' => 'WOONSTERS', 'nombre' => 'GIGAMES WOONSTERS SALON 500', 'local' => 'Villajoyosa'],
            ['identificador' => 'B:DOQ:16 V:016642', 'alias' => 'DORADO', 'nombre' => 'EL DORADO 500', 'local' => 'Villajoyosa'],
            ['identificador' => 'B:BLQ:16 V:016642', 'alias' => 'BURLESQUE', 'nombre' => 'BURLESQUE 500', 'local' => 'Villajoyosa'],
            ['identificador' => 'B:AS3:17AV:000033', 'alias' => 'ACTION STAR A', 'nombre' => 'ACTION STAR 600', 'local' => 'Villajoyosa'],
            ['identificador' => 'B:AS3:17BV:000033', 'alias' => 'ACTION STAR B', 'nombre' => 'ACTION STAR 600', 'local' => 'Villajoyosa'],
            ['identificador' => 'B:AS3:17CV:000033', 'alias' => 'ACTION STAR C', 'nombre' => 'ACTION STAR 600', 'local' => 'Villajoyosa'],
            ['identificador' => 'B:MB3:18AV:001850', 'alias' => 'MERKUR BOX A', 'nombre' => 'M-BOX 600', 'local' => 'Villajoyosa'],
            ['identificador' => 'B:MB3:18BV:001850', 'alias' => 'MERKUR BOX B', 'nombre' => 'M-BOX 600', 'local' => 'Villajoyosa'],
            ['identificador' => 'B:MB3:18CV:001850', 'alias' => 'MERKUR BOX C', 'nombre' => 'M-BOX 600', 'local' => 'Villajoyosa'],
            ['identificador' => 'B:PT3:21AV:025244', 'alias' => 'POWER LINK A', 'nombre' => 'POWER LINK 3000', 'local' => 'Villajoyosa'],
            ['identificador' => 'B:PT3:21BV:025244', 'alias' => 'POWER LINK B', 'nombre' => 'POWER LINK 3000', 'local' => 'Villajoyosa'],
            ['identificador' => 'B:PT3:21CV:025244', 'alias' => 'POWER LINK C', 'nombre' => 'POWER LINK 3000', 'local' => 'Villajoyosa'],
            ['identificador' => 'B:GX8:23 V:000096', 'alias' => 'RULETA', 'nombre' => 'RULETA INFINITY 3000', 'local' => 'Villajoyosa'],
            ['identificador' => 'B:DI3:24AV:000296', 'alias' => 'DIAMOND A', 'nombre' => 'DIAMOND MANIA 3000', 'local' => 'Villajoyosa'],
            ['identificador' => 'B:DI3:24BV:000296', 'alias' => 'DIAMOND B', 'nombre' => 'DIAMOND MANIA 3000', 'local' => 'Villajoyosa'],
            ['identificador' => 'B:DI3:24CV:000296', 'alias' => 'DIAMOND C', 'nombre' => 'DIAMOND MANIA 3000', 'local' => 'Villajoyosa'],

            // Ondara
            ['identificador' => 'B:WOT:12 V:000199', 'alias' => 'WOONSTER', 'nombre' => 'GIGAMES WOONSTERS SALON 500', 'local' => 'Ondara'],
            ['identificador' => 'B:GNS:14 V:000053', 'alias' => 'GNOMOS ROJA', 'nombre' => 'GNOMO MIX SALON 600', 'local' => 'Ondara'],
            ['identificador' => 'B:DOQ:16 V:017581', 'alias' => 'DORADO', 'nombre' => 'EL DORADO 500', 'local' => 'Ondara'],
            ['identificador' => 'B:M33:16AV:000938', 'alias' => 'MERKUR III A', 'nombre' => 'MERKUR III 600', 'local' => 'Ondara'],
            ['identificador' => 'B:M33:16BV:000938', 'alias' => 'MERKUR III B', 'nombre' => 'MERKUR III 600', 'local' => 'Ondara'],
            ['identificador' => 'B:M33:16CV:000938', 'alias' => 'MERKUR III C', 'nombre' => 'MERKUR III 600', 'local' => 'Ondara'],
            ['identificador' => 'B:MTQ:16 V:000397', 'alias' => 'MAQUINA DEL TIEMPO', 'nombre' => 'MAQUINA DEL TIEMPO 500', 'local' => 'Ondara'],
            ['identificador' => 'B:AS3:17AV:000030', 'alias' => 'ACTION STAR A', 'nombre' => 'ACTION STAR 1000', 'local' => 'Ondara'],
            ['identificador' => 'B:AS3:17BV:000030', 'alias' => 'ACTION STAR B', 'nombre' => 'ACTION STAR 1000', 'local' => 'Ondara'],
            ['identificador' => 'B:AS3:17CV:000030', 'alias' => 'ACTION STAR C', 'nombre' => 'ACTION STAR 1000', 'local' => 'Ondara'],
            ['identificador' => 'B:PN3:20AV:021134', 'alias' => 'POWER LINK A', 'nombre' => 'POWER LINK 1000', 'local' => 'Ondara'],
            ['identificador' => 'B:PN3:20BV:021134', 'alias' => 'POWER LINK B', 'nombre' => 'POWER LINK 1000', 'local' => 'Ondara'],
            ['identificador' => 'B:PN3:20CV:021134', 'alias' => 'POWER LINK C', 'nombre' => 'POWER LINK 1000', 'local' => 'Ondara'],
            ['identificador' => 'B:IX3:21AV:024245', 'alias' => 'IMPERA A', 'nombre' => 'IMPERA LINK 3000', 'local' => 'Ondara'],
            ['identificador' => 'B:IX3:21BV:024245', 'alias' => 'IMPERA B', 'nombre' => 'IMPERA LINK 3000', 'local' => 'Ondara'],
            ['identificador' => 'B:IX3:21CV:024245', 'alias' => 'IMPERA C', 'nombre' => 'IMPERA LINK 3000', 'local' => 'Ondara'],
            ['identificador' => 'B:RG8:22 V:000056', 'alias' => 'RULETA', 'nombre' => 'RULETA COMATEL 1000', 'local' => 'Ondara'],
            ['identificador' => 'B:MK3:24AV:013348', 'alias' => 'ZITRO A', 'nombre' => 'MULTILINK 1000', 'local' => 'Ondara'],
            ['identificador' => 'B:MK3:24BV:013348', 'alias' => 'ZITRO B', 'nombre' => 'MULTILINK 1000', 'local' => 'Ondara'],
            ['identificador' => 'B:MK3:24CV:013348', 'alias' => 'ZITRO C', 'nombre' => 'MULTILINK 1000', 'local' => 'Ondara'],

            // Pardo Gimeno
            ['identificador' => 'B:M23:15AV:600994', 'alias' => 'MERKUR II A', 'nombre' => 'MERKUR II 600', 'local' => 'Pardo Gimeno'],
            ['identificador' => 'B:M23:15BV:600994', 'alias' => 'MERKUR II B', 'nombre' => 'MERKUR II 600', 'local' => 'Pardo Gimeno'],
            ['identificador' => 'B:M23:15CV:600994', 'alias' => 'MERKUR II C', 'nombre' => 'MERKUR II 600', 'local' => 'Pardo Gimeno'],
            ['identificador' => 'B:CHM:18 V:002827', 'alias' => 'CHIRINGUITO', 'nombre' => 'CHIRINGUITO SALON 1000', 'local' => 'Pardo Gimeno'],
            ['identificador' => 'B:IL3:18AV:011594', 'alias' => 'IMPERA A', 'nombre' => 'IMPERA 1000', 'local' => 'Pardo Gimeno'],
            ['identificador' => 'B:IL3:18BV:011594', 'alias' => 'IMPERA B', 'nombre' => 'IMPERA 1000', 'local' => 'Pardo Gimeno'],
            ['identificador' => 'B:IL3:18CV:011594', 'alias' => 'IMPERA C', 'nombre' => 'IMPERA 1000', 'local' => 'Pardo Gimeno'],
            ['identificador' => 'B:MMU:19 V:100357', 'alias' => 'MERKUR MULTI', 'nombre' => 'MERKUR MULTI 500', 'local' => 'Pardo Gimeno'],
            ['identificador' => 'B:RG8:20 V:000033', 'alias' => 'RULETA', 'nombre' => 'RULETA COMATEL 1000', 'local' => 'Pardo Gimeno'],
            ['identificador' => 'B:LME:23 V:068891', 'alias' => 'LINK ME A', 'nombre' => 'LINK ME 1000', 'local' => 'Pardo Gimeno'],
            ['identificador' => 'B:LME:23 V:068892', 'alias' => 'LINK ME B', 'nombre' => 'LINK ME 1000', 'local' => 'Pardo Gimeno'],
            ['identificador' => 'B:MK3:23AV:011246', 'alias' => 'ZITRO A', 'nombre' => 'MULTILINK 1000', 'local' => 'Pardo Gimeno'],
            ['identificador' => 'B:MK3:23BV:011246', 'alias' => 'ZITRO B', 'nombre' => 'MULTILINK 1000', 'local' => 'Pardo Gimeno'],
            ['identificador' => 'B:MK3:23CV:011246', 'alias' => 'ZITRO C', 'nombre' => 'MULTILINK 1000', 'local' => 'Pardo Gimeno'],
            ['identificador' => 'B:LT3:23AV:001150', 'alias' => 'LINK MASTER A', 'nombre' => 'LINK MASTER 3000', 'local' => 'Pardo Gimeno'],
            ['identificador' => 'B:LT3:23BV:001150', 'alias' => 'LINK MASTER B', 'nombre' => 'LINK MASTER 3000', 'local' => 'Pardo Gimeno'],
            ['identificador' => 'B:LT3:23CV:001150', 'alias' => 'LINK MASTER C', 'nombre' => 'LINK MASTER 3000', 'local' => 'Pardo Gimeno'],
            ['identificador' => 'B:RK3:23AV:004644', 'alias' => 'ROCKET LINK A', 'nombre' => 'ISLA ROCKET 3000', 'local' => 'Pardo Gimeno'],
            ['identificador' => 'B:RK3:23BV:004644', 'alias' => 'ROCKET LINK B', 'nombre' => 'ISLA ROCKET 3000', 'local' => 'Pardo Gimeno'],
            ['identificador' => 'B:RK3:23CV:004644', 'alias' => 'ROCKET LINK C', 'nombre' => 'ISLA ROCKET 3000', 'local' => 'Pardo Gimeno'],
            ['identificador' => 'B:AK3:21AV:000073', 'alias' => 'ACTION STAR A', 'nombre' => 'ACTION STAR 2 3000', 'local' => 'Pardo Gimeno'],
            ['identificador' => 'B:AK3:21BV:000073', 'alias' => 'ACTION STAR B', 'nombre' => 'ACTION STAR 2 3000', 'local' => 'Pardo Gimeno'],
            ['identificador' => 'B:AK3:21CV:000073', 'alias' => 'ACTION STAR C', 'nombre' => 'ACTION STAR 2 3000', 'local' => 'Pardo Gimeno'],
            ['identificador' => 'B:PAM:24 V:000082', 'alias' => 'MANHATTAN', 'nombre' => 'MANHATTAN PARTY SALON 1000', 'local' => 'Pardo Gimeno'],

            // Muchamiel
            ['identificador' => 'B:IX3:21AV:024246', 'alias' => 'IMPERA A', 'nombre' => 'IMPERA 3000', 'local' => 'Muchamiel'],
            ['identificador' => 'B:IX3:21BV:024246', 'alias' => 'IMPERA B', 'nombre' => 'IMPERA 3000', 'local' => 'Muchamiel'],
            ['identificador' => 'B:IX3:21CV:024246', 'alias' => 'IMPERA C', 'nombre' => 'IMPERA 3000', 'local' => 'Muchamiel'],
            ['identificador' => 'B:AS3:18AV:000043', 'alias' => 'ACTION STAR A', 'nombre' => 'ACTION STAR 600', 'local' => 'Muchamiel'],
            ['identificador' => 'B:AS3:18BV:000043', 'alias' => 'ACTION STAR B', 'nombre' => 'ACTION STAR 600', 'local' => 'Muchamiel'],
            ['identificador' => 'B:AS3:18CV:000043', 'alias' => 'ACTION STAR C', 'nombre' => 'ACTION STAR 600', 'local' => 'Muchamiel'],
            ['identificador' => 'B:RG8:18 V:000113', 'alias' => 'RULETA', 'nombre' => 'RULETA COMATEL 1000', 'local' => 'Muchamiel'],
            ['identificador' => 'B:MA3:21AV:104098', 'alias' => 'MERKUR MAX A', 'nombre' => 'MERKUR MAX 3000', 'local' => 'Muchamiel'],
            ['identificador' => 'B:MA3:21BV:104098', 'alias' => 'MERKUR MAX B', 'nombre' => 'MERKUR MAX 3000', 'local' => 'Muchamiel'],
            ['identificador' => 'B:MA3:21CV:104098', 'alias' => 'MERKUR MAX C', 'nombre' => 'MERKUR MAX 3000', 'local' => 'Muchamiel'],
            ['identificador' => 'B:NEQ:15 V:008590', 'alias' => 'NEOPOLIS', 'nombre' => 'NEOPOLIS 500', 'local' => 'Muchamiel'],
            ['identificador' => 'B:LT3:24AV:000168', 'alias' => 'LINK MASTER A', 'nombre' => 'LINK MASTER 3000', 'local' => 'Muchamiel'],
            ['identificador' => 'B:LT3:24BV:000168', 'alias' => 'LINK MASTER B', 'nombre' => 'LINK MASTER 3000', 'local' => 'Muchamiel'],
            ['identificador' => 'B:LT3:24CV:000168', 'alias' => 'LINK MASTER C', 'nombre' => 'LINK MASTER 3000', 'local' => 'Muchamiel'],
            ['identificador' => 'B:MK3:24AV:013349', 'alias' => 'ZITRO A', 'nombre' => 'MULTILINK 1000', 'local' => 'Muchamiel'],
            ['identificador' => 'B:MK3:24BV:013349', 'alias' => 'ZITRO B', 'nombre' => 'MULTILINK 1000', 'local' => 'Muchamiel'],
            ['identificador' => 'B:MK3:24CV:013349', 'alias' => 'ZITRO C', 'nombre' => 'MULTILINK 1000', 'local' => 'Muchamiel'],
            ['identificador' => 'B:MMU:19 V:100353', 'alias' => 'MERKUR MULTI', 'nombre' => 'MERKUR MULTI 500', 'local' => 'Muchamiel'],
            ['identificador' => 'B:LXQ:15 V:000957', 'alias' => 'LUXOR', 'nombre' => 'LUXOR 500', 'local' => 'Muchamiel'],

            // Florida
            ['identificador' => 'B:GJK:14 V:001773', 'alias' => 'GRANJA', 'nombre' => 'GRANJA 500', 'local' => 'Florida'],
            ['identificador' => 'B:M23:15AV:600997', 'alias' => 'MERKUR II A', 'nombre' => 'MERKUR II 1000', 'local' => 'Florida'],
            ['identificador' => 'B:M23:15BV:600997', 'alias' => 'MERKUR II B', 'nombre' => 'MERKUR II 1000', 'local' => 'Florida'],
            ['identificador' => 'B:M23:15CV:600997', 'alias' => 'MERKUR II C', 'nombre' => 'MERKUR II 1000', 'local' => 'Florida'],
            ['identificador' => 'B:NEQ:15 V:008593', 'alias' => 'NEOPOLIS', 'nombre' => 'NEOPOLIS 500', 'local' => 'Florida'],
            ['identificador' => 'B:DOQ:16 V:015874', 'alias' => 'DORADO', 'nombre' => 'EL DORADO 500', 'local' => 'Florida'],
            ['identificador' => 'B:M33:16AV:001001', 'alias' => 'MERKUR III A', 'nombre' => 'MERKUR III 600', 'local' => 'Florida'],
            ['identificador' => 'B:M33:16BV:001001', 'alias' => 'MERKUR III B', 'nombre' => 'MERKUR III 600', 'local' => 'Florida'],
            ['identificador' => 'B:M33:16CV:001001', 'alias' => 'MERKUR III C', 'nombre' => 'MERKUR III 600', 'local' => 'Florida'],
            ['identificador' => 'B:WHQ:16 V:025798', 'alias' => 'WOONSTER', 'nombre' => 'WOONSTER HOTEL 500', 'local' => 'Florida'],
            ['identificador' => 'B:MMU:19 V:100352', 'alias' => 'MERKUR MULTI', 'nombre' => 'MERKUR MULTI', 'local' => 'Florida'],
            ['identificador' => 'B:PN3:20AV:021127', 'alias' => 'POWER LINK A', 'nombre' => 'POWER LINK 1000', 'local' => 'Florida'],
            ['identificador' => 'B:PN3:20BV:021127', 'alias' => 'POWER LINK B', 'nombre' => 'POWER LINK 1000', 'local' => 'Florida'],
            ['identificador' => 'B:PN3:20CV:021127', 'alias' => 'POWER LINK C', 'nombre' => 'POWER LINK 1000', 'local' => 'Florida'],
            ['identificador' => 'B:RJ8:21 V:000050', 'alias' => 'RULETA', 'nombre' => 'RULETA COMATEL 1000', 'local' => 'Florida'],
            ['identificador' => 'B:IX3:21AV:025094', 'alias' => 'IMPERA A', 'nombre' => 'IMPERA 3000', 'local' => 'Florida'],
            ['identificador' => 'B:IX3:21BV:025094', 'alias' => 'IMPERA B', 'nombre' => 'IMPERA 3000', 'local' => 'Florida'],
            ['identificador' => 'B:IX3:21CV:025094', 'alias' => 'IMPERA C', 'nombre' => 'IMPERA 3000', 'local' => 'Florida'],
            ['identificador' => 'B:MMS:22 V:104644', 'alias' => 'MERKUR MULTI', 'nombre' => 'MERKUR MULTI 500', 'local' => 'Florida'],
            ['identificador' => 'B:MT3:22AV:000030', 'alias' => 'MAGIC FORTUNE A', 'nombre' => 'MAGIC FORTUNE 3000', 'local' => 'Florida'],
            ['identificador' => 'B:MT3:22BV:000030', 'alias' => 'MAGIC FORTUNE B', 'nombre' => 'MAGIC FORTUNE 3000', 'local' => 'Florida'],
            ['identificador' => 'B:MT3:22CV:000030', 'alias' => 'MAGIC FORTUNE C', 'nombre' => 'MAGIC FORTUNE 3000', 'local' => 'Florida'],
            ['identificador' => 'B:MK3:23AV:011936', 'alias' => 'ZITRO A', 'nombre' => 'MULTILINK 1000', 'local' => 'Florida'],
            ['identificador' => 'B:MK3:23BV:011936', 'alias' => 'ZITRO B', 'nombre' => 'MULTILINK 1000', 'local' => 'Florida'],
            ['identificador' => 'B:MK3:23CV:011936', 'alias' => 'ZITRO C', 'nombre' => 'MULTILINK 1000', 'local' => 'Florida'],

            // Primo de Rivera
            ['identificador' => 'B:SFL:08 V:000017', 'alias' => 'SANTA FE', 'nombre' => 'SANTA FE LOTO TRIPLE 240', 'local' => 'Primo de Rivera'],
            ['identificador' => 'B:YEQ:15 V:000270', 'alias' => 'YETIMANIA', 'nombre' => 'YETIMANIA 500', 'local' => 'Primo de Rivera'],
            ['identificador' => 'B:NEQ:15 V:008591', 'alias' => 'NEOPOLIS', 'nombre' => 'NEOPOLIS 500', 'local' => 'Primo de Rivera'],
            ['identificador' => 'B:BLQ:16 V:016639', 'alias' => 'BURLESQUE', 'nombre' => 'BURLESQUE 500', 'local' => 'Primo de Rivera'],
            ['identificador' => 'B:RG8:18 V:000112', 'alias' => 'RULETA', 'nombre' => 'RULETA COMATEL 1000', 'local' => 'Primo de Rivera'],
            ['identificador' => 'B:MMU:19 V:100358', 'alias' => 'MERKUR MULTI', 'nombre' => 'MERKUR MULTI 500', 'local' => 'Primo de Rivera'],
            ['identificador' => 'B:PN3:20AV:021136', 'alias' => 'POWER LINK A', 'nombre' => 'POWER LINK 1000', 'local' => 'Primo de Rivera'],
            ['identificador' => 'B:PN3:20BV:021136', 'alias' => 'POWER LINK B', 'nombre' => 'POWER LINK 1000', 'local' => 'Primo de Rivera'],
            ['identificador' => 'B:PN3:20CV:021136', 'alias' => 'POWER LINK C', 'nombre' => 'POWER LINK 1000', 'local' => 'Primo de Rivera'],
            ['identificador' => 'B:REY:19 V:003331', 'alias' => 'REY DE LA SUERTE', 'nombre' => 'REY DE LA SUERTE 500', 'local' => 'Primo de Rivera'],
            ['identificador' => 'B:IX3:21AV:025093', 'alias' => 'IMPERA A', 'nombre' => 'IMPERA 3000', 'local' => 'Primo de Rivera'],
            ['identificador' => 'B:IX3:21BV:025093', 'alias' => 'IMPERA B', 'nombre' => 'IMPERA 3000', 'local' => 'Primo de Rivera'],
            ['identificador' => 'B:IX3:21CV:025093', 'alias' => 'IMPERA C', 'nombre' => 'IMPERA 3000', 'local' => 'Primo de Rivera'],
            ['identificador' => 'B:NEQ:15 V:008597', 'alias' => 'NEOPOLIS', 'nombre' => 'NEOPOLIS 500', 'local' => 'Primo de Rivera'],
            ['identificador' => 'B:BS3:23AV:107982', 'alias' => 'M-BOX A', 'nombre' => 'MERKUR BOX 3000', 'local' => 'Primo de Rivera'],
            ['identificador' => 'B:BS3:23BV:107982', 'alias' => 'M-BOX B', 'nombre' => 'MERKUR BOX 3000', 'local' => 'Primo de Rivera'],
            ['identificador' => 'B:BS3:23CV:107982', 'alias' => 'M-BOX C', 'nombre' => 'MERKUR BOX 3000', 'local' => 'Primo de Rivera'],
            ['identificador' => 'B:PAM:24 V:000084', 'alias' => 'MANHATTAN', 'nombre' => 'MANHATTAN PARTY 1000', 'local' => 'Primo de Rivera'],

            //Pego
            ['identificador' => 'B:WOT:12 V:000200', 'alias' => 'WOONSTERS', 'nombre' => 'GIGAMES WOONSTERS 500', 'local' => 'Pego'],
            ['identificador' => 'B:M33:16AV:000905', 'alias' => 'MERKUR III A', 'nombre' => 'MERKUR III 600', 'local' => 'Pego'],
            ['identificador' => 'B:M33:16BV:000905', 'alias' => 'MERKUR III B', 'nombre' => 'MERKUR III 600', 'local' => 'Pego'],
            ['identificador' => 'B:M33:16CV:000905', 'alias' => 'MERKUR III C', 'nombre' => 'MERKUR III 600', 'local' => 'Pego'],
            ['identificador' => 'B:LGT:19AV:002293', 'alias' => 'GRAN LUX A', 'nombre' => 'GRAN LUX 1000', 'local' => 'Pego'],
            ['identificador' => 'B:LGT:19BV:002293', 'alias' => 'GRAN LUX B', 'nombre' => 'GRAN LUX 1000', 'local' => 'Pego'],
            ['identificador' => 'B:LGT:19CV:002293', 'alias' => 'GRAN LUX C', 'nombre' => 'GRAN LUX 1000', 'local' => 'Pego'],
            ['identificador' => 'B:MK3:19AV:003515', 'alias' => 'ZITRO A', 'nombre' => 'MULTILINK 1000', 'local' => 'Pego'],
            ['identificador' => 'B:MK3:19BV:003515', 'alias' => 'ZITRO B', 'nombre' => 'MULTILINK 1000', 'local' => 'Pego'],
            ['identificador' => 'B:MK3:19CV:003515', 'alias' => 'ZITRO C', 'nombre' => 'MULTILINK 1000', 'local' => 'Pego'],
            ['identificador' => 'B:PT3:21AV:025248', 'alias' => 'POWER LINK A', 'nombre' => 'POWER LINK 3000', 'local' => 'Pego'],
            ['identificador' => 'B:PT3:21BV:025248', 'alias' => 'POWER LINK B', 'nombre' => 'POWER LINK 3000', 'local' => 'Pego'],
            ['identificador' => 'B:PT3:21CV:025248', 'alias' => 'POWER LINK C', 'nombre' => 'POWER LINK 3000', 'local' => 'Pego'],
            ['identificador' => 'B:GX8:23 V:000092', 'alias' => 'RULETA', 'nombre' => 'RULETA INFINITY 3000', 'local' => 'Pego'],
            ['identificador' => 'B:NEQ:16 V:003800', 'alias' => 'NEOPOLIS', 'nombre' => 'NEOPOLIS 500', 'local' => 'Pego'],
            ['identificador' => 'B:GNS:14 V:000048', 'alias' => 'GNOMOS ROJA', 'nombre' => 'GNOMO MIX SALON 600', 'local' => 'Pego'],
            ['identificador' => 'B:LI3:24AV:108660', 'alias' => 'MYSTIC LINK A', 'nombre' => 'MERKUR MYSTIC LINK 3000', 'local' => 'Pego'],
            ['identificador' => 'B:LI3:24BV:108660', 'alias' => 'MYSTIC LINK B', 'nombre' => 'MERKUR MYSTIC LINK 3000', 'local' => 'Pego'],
            ['identificador' => 'B:LI3:24CV:108660', 'alias' => 'MYSTIC LINK C', 'nombre' => 'MERKUR MYSTIC LINK 3000', 'local' => 'Pego'],

            //Benisa
            ['identificador' => 'B:DOQ:16 V:017672', 'nombre' => 'EL DORADO 500', 'alias' => 'DORADO', 'local' => 'Benisa'],
            ['identificador' => 'B:AS3:17AV:000034', 'nombre' => 'ACTION STAR 600', 'alias' => 'ACTION STAR A', 'local' => 'Benisa'],
            ['identificador' => 'B:AS3:17BV:000034', 'nombre' => 'ACTION STAR 600', 'alias' => 'ACTION STAR B', 'local' => 'Benisa'],
            ['identificador' => 'B:AS3:17CV:000034', 'nombre' => 'ACTION STAR 600', 'alias' => 'ACTION STAR C', 'local' => 'Benisa'],
            ['identificador' => 'B:CHM:18 V:002867', 'nombre' => 'CHIRINGUITO SALON 1000', 'alias' => 'CHIRINGUITO', 'local' => 'Benisa'],
            ['identificador' => 'B:RX8:19 V:000136', 'nombre' => 'RULETA COMATEL 3000', 'alias' => 'RUELTA', 'local' => 'Benisa'],
            ['identificador' => 'B:MT3:23AV:000001', 'nombre' => 'MAGIC FORTUNE 3000', 'alias' => 'MAGIC FORTUNE A', 'local' => 'Benisa'],
            ['identificador' => 'B:MT3:23BV:000001', 'nombre' => 'MAGIC FORTUNE 3000', 'alias' => 'MAGIC FORTUNE B', 'local' => 'Benisa'],
            ['identificador' => 'B:MT3:23CV:000001', 'nombre' => 'MAGIC FORTUNE 3000', 'alias' => 'MAGIC FORTUNE C', 'local' => 'Benisa'],
            ['identificador' => 'B:N3B:19 V:035955', 'nombre' => 'NOVOLINE BAR III 500', 'alias' => 'NOVOLINE', 'local' => 'Benisa'],
            ['identificador' => 'B:LT3:23AV:001148', 'nombre' => 'LINK MASTER 3000', 'alias' => 'LINK MASTER A', 'local' => 'Benisa'],
            ['identificador' => 'B:LT3:23BV:001148', 'nombre' => 'LINK MASTER 3000', 'alias' => 'LINK MASTER B', 'local' => 'Benisa'],
            ['identificador' => 'B:LT3:23CV:001148', 'nombre' => 'LINK MASTER 3000', 'alias' => 'LINK MASTER C', 'local' => 'Benisa'],
            ['identificador' => 'B:RK3:24AV:001132', 'nombre' => 'ISLA ROCKET 3000', 'alias' => 'ROCKET LINK A', 'local' => 'Benisa'],
            ['identificador' => 'B:RK3:24BV:001132', 'nombre' => 'ISLA ROCKET 3000', 'alias' => 'ROCKET LINK B', 'local' => 'Benisa'],
            ['identificador' => 'B:RK3:24CV:001132', 'nombre' => 'ISLA ROCKET 3000', 'alias' => 'ROCKET LINK C', 'local' => 'Benisa'],

            //La Nucia
            ['identificador' => 'B:DOQ:16 V:016644', 'nombre' => 'EL DORADO 500', 'alias' => 'DORADO', 'local' => 'La Nucia'],
            ['identificador' => 'B:M23:15CV:601304', 'nombre' => 'MERKUR II 600', 'alias' => 'MERKUR II A', 'local' => 'La Nucia'],
            ['identificador' => 'B:M23:15BV:601304', 'nombre' => 'MERKUR II 600', 'alias' => 'MERKUR II B', 'local' => 'La Nucia'],
            ['identificador' => 'B:M23:15AV:601304', 'nombre' => 'MERKUR II 600', 'alias' => 'MERKUR II C', 'local' => 'La Nucia'],
            ['identificador' => 'B:AS3:17AV:000031', 'nombre' => 'ACTION STAR 600', 'alias' => 'ACTION STAR A', 'local' => 'La Nucia'],
            ['identificador' => 'B:AS3:17BV:000031', 'nombre' => 'ACTION STAR 600', 'alias' => 'ACTION STAR A', 'local' => 'La Nucia'],
            ['identificador' => 'B:AS3:17CV:000031', 'nombre' => 'ACTION STAR 600', 'alias' => 'ACTION STAR A', 'local' => 'La Nucia'],
            ['identificador' => 'B:MB3:18AV:001838', 'nombre' => 'M-BOX 600', 'alias' => 'M-BOX A', 'local' => 'La Nucia'],
            ['identificador' => 'B:MB3:18BV:001838', 'nombre' => 'M-BOX 600', 'alias' => 'M-BOX B', 'local' => 'La Nucia'],
            ['identificador' => 'B:MB3:18CV:001838', 'nombre' => 'M-BOX 600', 'alias' => 'M-BOX C', 'local' => 'La Nucia'],
            ['identificador' => 'B:RG8:18 V:000129', 'nombre' => 'RULETA COMATEL 1000', 'alias' => 'RULETA', 'local' => 'La Nucia'],
            ['identificador' => 'B:IX3:21BV:023305', 'nombre' => 'IMPERA LINK 3000', 'alias' => 'IMPERA A', 'local' => 'La Nucia'],
            ['identificador' => 'B:IX3:21CV:023305', 'nombre' => 'IMPERA LINK 3000', 'alias' => 'IMPERA B', 'local' => 'La Nucia'],
            ['identificador' => 'B:IX3:21 V:023305', 'nombre' => 'IMPERA LINK 3000', 'alias' => 'IMPERA C', 'local' => 'La Nucia'],
            ['identificador' => 'B:PT3:21AV:025245', 'nombre' => 'POWER LINK 3000', 'alias' => 'POWER LINK A', 'local' => 'La Nucia'],
            ['identificador' => 'B:PT3:21BV:025245', 'nombre' => 'POWER LINK 3000', 'alias' => 'POWER LINK B', 'local' => 'La Nucia'],
            ['identificador' => 'B:PT3:21CV:025245', 'nombre' => 'POWER LINK 3000', 'alias' => 'POWER LINK C', 'local' => 'La Nucia'],
            ['identificador' => 'B:REY:19 V:003336', 'nombre' => 'REY DE LA SUERTE 500', 'alias' => 'REY DE LA SUERTE', 'local' => 'La Nucia'],
            ['identificador' => 'B:OP2:23AV:000008', 'nombre' => 'ZUUM OPERA 1000', 'alias' => 'ZUUM A', 'local' => 'La Nucia'],
            ['identificador' => 'B:OP2:23BV:000008', 'nombre' => 'ZUUM OPERA 1000', 'alias' => 'ZUMM B', 'local' => 'La Nucia'],

            //Gata de gorgos
            ['identificador' => 'B:GNQ:14 V:007845', 'nombre' => 'GNOMOS MIX 500', 'alias' => 'GNOMOS', 'local' => 'Gata de Gorgos'],
            ['identificador' => 'B:MTQ:16 V:000768', 'nombre' => 'MAQUINA DELTIEMPO 500', 'alias' => 'MAQUINA DEL TIEMPO', 'local' => 'Gata de Gorgos'],
            ['identificador' => 'B:M33:16AV:000911', 'nombre' => 'MERKUR III 600', 'alias' => 'MERKUR III A', 'local' => 'Gata de Gorgos'],
            ['identificador' => 'B:M33:16BV:000911', 'nombre' => 'MERKUR III 600', 'alias' => 'MERKUR III B', 'local' => 'Gata de Gorgos'],
            ['identificador' => 'B:M33:16CV:000911', 'nombre' => 'MERKUR III 600', 'alias' => 'MERKUR III C', 'local' => 'Gata de Gorgos'],
            ['identificador' => 'B:GJK:14 V:001781', 'nombre' => 'GRANJA 500', 'alias' => 'GRANJA', 'local' => 'Gata de Gorgos'],
            ['identificador' => 'B:MB3:18AV:003157', 'nombre' => 'M-BOX 600', 'alias' => 'M-BOX A', 'local' => 'Gata de Gorgos'],
            ['identificador' => 'B:MB3:18BV:003157', 'nombre' => 'M-BOX 600', 'alias' => 'M-BOX B', 'local' => 'Gata de Gorgos'],
            ['identificador' => 'B:MB3:18CV:003157', 'nombre' => 'M-BOX 600', 'alias' => 'M-BOX C', 'local' => 'Gata de Gorgos'],
            ['identificador' => 'B:SFL:07 V:003824', 'nombre' => 'SANTA FE LOTO TRIPLE 240', 'alias' => 'SANTA FE', 'local' => 'Gata de Gorgos'],
            ['identificador' => 'B:PN3:20AV:021137', 'nombre' => 'POWER LINK 600', 'alias' => 'POWER LINK A', 'local' => 'Gata de Gorgos'],
            ['identificador' => 'B:PN3:20BV:021137', 'nombre' => 'POWER LINK 600', 'alias' => 'POWER LINK B', 'local' => 'Gata de Gorgos'],
            ['identificador' => 'B:PN3:20CV:021137', 'nombre' => 'POWER LINK 600', 'alias' => 'POWER LINK C', 'local' => 'Gata de Gorgos'],
            ['identificador' => 'B:IX3:21AV:024243', 'nombre' => 'IMPERA LINK 3000', 'alias' => 'IMPERA A', 'local' => 'Gata de Gorgos'],
            ['identificador' => 'B:IX3:21BV:024243', 'nombre' => 'IMPERA LINK 3000', 'alias' => 'IMPERA B', 'local' => 'Gata de Gorgos'],
            ['identificador' => 'B:IX3:21CV:024243', 'nombre' => 'IMPERA LINK 3000', 'alias' => 'IMPERA C', 'local' => 'Gata de Gorgos'],
            ['identificador' => 'B:GX8:23 V:000088', 'nombre' => 'RULETA INFINITY 3000', 'alias' => 'RULETA', 'local' => 'Gata de Gorgos'],

            // Teulada
            ['identificador' => 'B:M23:16AV:601524', 'nombre' => 'MERKUR II 600', 'alias' => 'MERKUR II A', 'local' => 'Teulada'],
            ['identificador' => 'B:M23:16BV:601524', 'nombre' => 'MERKUR II 600', 'alias' => 'MERKUR II B', 'local' => 'Teulada'],
            ['identificador' => 'B:M23:16CV:601524', 'nombre' => 'MERKUR II 600', 'alias' => 'MERKUR II C', 'local' => 'Teulada'],
            ['identificador' => 'B:N3B:19 V:035958', 'nombre' => 'NOVOLINE III BAR 500', 'alias' => 'NOVOLINE III BAR', 'local' => 'Teulada'],
            ['identificador' => 'B:MB3:20AV:102746', 'nombre' => 'M-BOX 600', 'alias' => 'M-BOX A', 'local' => 'Teulada'],
            ['identificador' => 'B:MB3:20BV:102746', 'nombre' => 'M-BOX 600', 'alias' => 'M-BOX B', 'local' => 'Teulada'],
            ['identificador' => 'B:MB3:20CV:102746', 'nombre' => 'M-BOX 600', 'alias' => 'M-BOX C', 'local' => 'Teulada'],
            ['identificador' => 'B:IX3:21AV:025095', 'nombre' => 'IMPERA LINK 3000', 'alias' => 'IMPERA A', 'local' => 'Teulada'],
            ['identificador' => 'B:IX3:21BV:025095', 'nombre' => 'IMPERA LINK 3000', 'alias' => 'IMPERA B', 'local' => 'Teulada'],
            ['identificador' => 'B:IX3:21CV:025095', 'nombre' => 'IMPERA LINK 3000', 'alias' => 'IMPERA C', 'local' => 'Teulada'],
            ['identificador' => 'B:AB1:19 V:001677', 'nombre' => 'ACTION STAR BAR 500', 'alias' => 'ACTION STAR BAR', 'local' => 'Teulada'],
            ['identificador' => 'B:PT3:22AV:026079', 'nombre' => 'POWER LINK 3000', 'alias' => 'POWER LINK A', 'local' => 'Teulada'],
            ['identificador' => 'B:PT3:22BV:026079', 'nombre' => 'POWER LINK 3000', 'alias' => 'POWER LINK B', 'local' => 'Teulada'],
            ['identificador' => 'B:PT3:22CV:026079', 'nombre' => 'POWER LINK 3000', 'alias' => 'POWER LINK C', 'local' => 'Teulada'],
            ['identificador' => 'B:GX8:23 V:000094', 'nombre' => 'RULETA INFINITY 3000', 'alias' => 'RULETA', 'local' => 'Teulada'],
            ['identificador' => 'B:IX3:23AV:030990', 'nombre' => 'IMPERA LINK 3000', 'alias' => 'IMPERA D', 'local' => 'Teulada'],
            ['identificador' => 'B:IX3:23BV:030990', 'nombre' => 'IMPERA LINK 3000', 'alias' => 'IMPERA E', 'local' => 'Teulada'],
            ['identificador' => 'B:IX3:23CV:030990', 'nombre' => 'IMPERA LINK 3000', 'alias' => 'IMPERA F', 'local' => 'Teulada'],
            ['identificador' => 'B:AS3:17AV:000032', 'nombre' => 'ACTION STAR 600', 'alias' => 'ACTION STAR A', 'local' => 'Teulada'],
            ['identificador' => 'B:AS3:17BV:000032', 'nombre' => 'ACTION STAR 600', 'alias' => 'ACTION STAR B', 'local' => 'Teulada'],
            ['identificador' => 'B:AS3:17CV:000032', 'nombre' => 'ACTION STAR 600', 'alias' => 'ACTION STAR C', 'local' => 'Teulada'],

            // Calpe
            ['identificador' => 'B:N3B:19 V:035947', 'nombre' => 'NOVOLINE III BAR 500', 'alias' => 'NOVOLINE III BAR', 'local' => 'Calpe'],
            ['identificador' => 'B:FGQ:14 V:003524', 'nombre' => 'FUEGO PLUS 500', 'alias' => 'FUEGO', 'local' => 'Calpe'],
            ['identificador' => 'B:PN6:21AV:023584', 'nombre' => 'POWER LINK 3000', 'alias' => 'POWER LINK A', 'local' => 'Calpe'],
            ['identificador' => 'B:PN6:21BV:023584', 'nombre' => 'POWER LINK 3000', 'alias' => 'POWER LINK B', 'local' => 'Calpe'],
            ['identificador' => 'B:PN6:21CV:023584', 'nombre' => 'POWER LINK 3000', 'alias' => 'POWER LINK C', 'local' => 'Calpe'],
            ['identificador' => 'B:PN6:21DV:023584', 'nombre' => 'POWER LINK 3000', 'alias' => 'POWER LINK D', 'local' => 'Calpe'],
            ['identificador' => 'B:PN6:21EV:023584', 'nombre' => 'POWER LINK 3000', 'alias' => 'POWER LINK E', 'local' => 'Calpe'],
            ['identificador' => 'B:PN6:21FV:023584', 'nombre' => 'POWER LINK 3000', 'alias' => 'POWER LINK F', 'local' => 'Calpe'],
            ['identificador' => 'B:IX3:21AV:023934', 'nombre' => 'IMPERA LINK 3000', 'alias' => 'IMPERA A', 'local' => 'Calpe'],
            ['identificador' => 'B:IX3:21BV:023934', 'nombre' => 'IMPERA LINK 3000', 'alias' => 'IMPERA B', 'local' => 'Calpe'],
            ['identificador' => 'B:IX3:21CV:023934', 'nombre' => 'IMPERA LINK 3000', 'alias' => 'IMPERA C', 'local' => 'Calpe'],
            ['identificador' => 'B:MA3:21AV:104191', 'nombre' => 'MERKUR MAX 3000', 'alias' => 'M-MAX A', 'local' => 'Calpe'],
            ['identificador' => 'B:MA3:21BV:104191', 'nombre' => 'MERKUR MAX 3000', 'alias' => 'M-MAX B', 'local' => 'Calpe'],
            ['identificador' => 'B:MA3:21CV:104191', 'nombre' => 'MERKUR MAX 3000', 'alias' => 'M-MAX C', 'local' => 'Calpe'],
            ['identificador' => 'B:PT3:21AV:025246', 'nombre' => 'POWER LINK 3000', 'alias' => 'POWER LINK 19', 'local' => 'Calpe'],
            ['identificador' => 'B:PT3:21BV:025246', 'nombre' => 'POWER LINK 3000', 'alias' => 'POWER LINK 20', 'local' => 'Calpe'],
            ['identificador' => 'B:PT3:21CV:025246', 'nombre' => 'POWER LINK 3000', 'alias' => 'POWER LINK 21', 'local' => 'Calpe'],
            ['identificador' => 'B:LT3:23AV:001149', 'nombre' => 'LINK MASTER 3000', 'alias' => 'LINK MASTER A', 'local' => 'Calpe'],
            ['identificador' => 'B:LT3:23BV:001149', 'nombre' => 'LINK MASTER 3000', 'alias' => 'LINK MASTER B', 'local' => 'Calpe'],
            ['identificador' => 'B:LT3:23CV:001149', 'nombre' => 'LINK MASTER 3000', 'alias' => 'LINK MASTER C', 'local' => 'Calpe'],
            ['identificador' => 'B:GC8:23 V:000131', 'nombre' => 'RULETA INFINITY 3000', 'alias' => 'RULETA', 'local' => 'Calpe'],

            // Vergel
            ['identificador' => 'B:AS3:18AV:000044', 'nombre' => 'ACTION STAR 600', 'alias' => 'ACTION STAR A', 'local' => 'Vergel'],
            ['identificador' => 'B:AS3:18BV:000044', 'nombre' => 'ACTION STAR 600', 'alias' => 'ACTION STAR B', 'local' => 'Vergel'],
            ['identificador' => 'B:AS3:18CV:000044', 'nombre' => 'ACTION STAR 600', 'alias' => 'ACTION STAR C', 'local' => 'Vergel'],
            ['identificador' => 'B:MB3:19AV:100815', 'nombre' => 'M-BOX 600', 'alias' => 'M-BOX 40', 'local' => 'Vergel'],
            ['identificador' => 'B:MB3:19BV:100815', 'nombre' => 'M-BOX 600', 'alias' => 'M-BOX 41', 'local' => 'Vergel'],
            ['identificador' => 'B:MB3:19CV:100815', 'nombre' => 'M-BOX 600', 'alias' => 'M-BOX 42', 'local' => 'Vergel'],
            ['identificador' => 'B:RG8:20 V:000043', 'nombre' => 'RULETA COMATEL 1000', 'alias' => 'RULETA', 'local' => 'Vergel'],
            ['identificador' => 'B:N3B:19 V:035961', 'nombre' => 'NOVOLINE III BAR 500', 'alias' => 'NOVOLINE III BAR', 'local' => 'Vergel'],
            ['identificador' => 'B:VEQ:19 V:016036', 'nombre' => 'GIGAMES VENECIA MIX 500', 'alias' => 'VENECIA', 'local' => 'Vergel'],
            ['identificador' => 'B:IX3:21AV:025096', 'nombre' => 'IMPERA LINK 3000', 'alias' => 'IMPERA A', 'local' => 'Vergel'],
            ['identificador' => 'B:IX3:21BV:025096', 'nombre' => 'IMPERA LINK 3000', 'alias' => 'IMPERA B', 'local' => 'Vergel'],
            ['identificador' => 'B:IX3:21CV:025096', 'nombre' => 'IMPERA LINK 3000', 'alias' => 'IMPERA C', 'local' => 'Vergel'],
            ['identificador' => 'B:PT3:21AV:025247', 'nombre' => 'POWER LINK 3000', 'alias' => 'POWER LINK A', 'local' => 'Vergel'],
            ['identificador' => 'B:PT3:21BV:025247', 'nombre' => 'POWER LINK 3000', 'alias' => 'POWER LINK B', 'local' => 'Vergel'],
            ['identificador' => 'B:PT3:21CV:025247', 'nombre' => 'POWER LINK 3000', 'alias' => 'POWER LINK C', 'local' => 'Vergel'],
            ['identificador' => 'B:HL3:23AV:000023', 'nombre' => 'LINK MIX 3000', 'alias' => 'LINK MIX A', 'local' => 'Vergel'],
            ['identificador' => 'B:HL3:23BV:000023', 'nombre' => 'LINK MIX 3000', 'alias' => 'LINK MIX B', 'local' => 'Vergel'],
            ['identificador' => 'B:HL3:23CV:000023', 'nombre' => 'LINK MIX 3000', 'alias' => 'LINK MIX C', 'local' => 'Vergel'],
            ['identificador' => 'B:DR8:18 V:008906', 'nombre' => 'RULETA MINISTAR 1000', 'alias' => 'RULETA MINISTAR', 'local' => 'Vergel'],
            ['identificador' => 'B:MB3:18A:001931', 'nombre' => 'M-BOX 600', 'alias' => 'M-BOX 30', 'local' => 'Vergel'],
            ['identificador' => 'B:MB3:18B:001931', 'nombre' => 'M-BOX 600', 'alias' => 'M-BOX 31', 'local' => 'Vergel'],
            ['identificador' => 'B:MB3:18C:001931', 'nombre' => 'M-BOX 600', 'alias' => 'M-BOX 32', 'local' => 'Vergel'],
            ['identificador' => 'B:MK3:23AV:011934', 'nombre' => 'MULTILINK 1000', 'alias' => 'ZITRO A', 'local' => 'Vergel'],
            ['identificador' => 'B:MK3:23BV:011934', 'nombre' => 'MULTILINK 1000', 'alias' => 'ZITRO B', 'local' => 'Vergel'],
            ['identificador' => 'B:MK3:23CV:011934', 'nombre' => 'MULTILINK 1000', 'alias' => 'ZITRO C', 'local' => 'Vergel'],
        ];


        foreach ($maquinasSalones as $maquina) {
            $local = Local::where('name', $maquina['local'])->first();
            $machine = Machine::create([
                'identificador' => $maquina['identificador'],
                'name' => $maquina['nombre'],
                'alias' => $maquina['alias'],
                'local_id' => $local->id,
                'delegation_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }



        $maquinasBares = [
            ['identificador' => 'B:PAQ:24 V:000843', 'alias' => 'MANHATTAN', 'nombre' => 'MANHATTAN PARTY 500', 'bar' => 'Amanecer'], //
            ['identificador' => 'B:DOQ:16 V:017679', 'alias' => 'DORADO', 'nombre' => 'DORADO 500', 'bar' => 'Casa Llauis'], //
            ['identificador' => 'B:SAQ:21 V:064266', 'alias' => 'SAMARKANDA', 'nombre' => 'SAMARKANDA 500', 'bar' => 'Casa Llauis'], //
            ['identificador' => 'B:MHR:22 V:000392', 'alias' => 'MANHATTAN', 'nombre' => 'MANHATTAN REVOLUTION 500', 'bar' => 'Havanna'], //
            ['identificador' => 'B:MSB:24 V:108501', 'alias' => 'MERKUR SELECTION', 'nombre' => 'MERKUR SELECTION 500', 'bar' => 'Havanna'], //
            ['identificador' => 'B:MHR:22 V:001422', 'alias' => 'MANHATTAN', 'nombre' => 'MANHATTAN REVOLUTION 500', 'bar' => 'Maigmo'], //
            ['identificador' => 'B:SAQ:21 V:065081', 'alias' => 'SAMARKANDA', 'nombre' => 'SAMARKANDA 500', 'bar' => 'Maigmo'], //
            ['identificador' => 'B:SAQ:21 V:065083', 'alias' => 'SAMARKANDA', 'nombre' => 'SAMARKANDA 500', 'bar' => 'Canto'], //
            ['identificador' => 'B:VEQ:19 V:016034', 'alias' => 'VENECIA', 'nombre' => 'VENECIA MIX 500', 'bar' => 'Angel de Santa Pola'], //
            ['identificador' => 'B:N3B:19 V:035951', 'alias' => 'NOVOLINE III BAR', 'nombre' => 'NOVOLINE III BAR 500', 'bar' => 'Picaeta'], //
            ['identificador' => 'B:LBQ:24 V:108724', 'alias' => 'MERKUR DELUXE BAR', 'nombre' => 'MERKUR DELUXE BAR 500', 'bar' => 'Picaeta'], //
            ['identificador' => 'B:ARC:19 V:006328', 'alias' => 'ARCADE', 'nombre' => 'ARCADE 500', 'bar' => 'Starkoffe'], //
            ['identificador' => 'B:AB1:19 V:010350', 'alias' => 'ACTION STAR BAR', 'nombre' => 'ACTION STAR BAR 500', 'bar' => 'Caballer'], //
            ['identificador' => 'B:MHR:22 V:001423', 'alias' => 'MANHATTAN', 'nombre' => 'MANHATTAN REVOLUTION 500', 'bar' => 'Bulevar'], //
            ['identificador' => 'B:PLQ:21 V:062934', 'alias' => 'PINGÜINOS', 'nombre' => 'PINGÜINOS LOCOS 500', 'bar' => 'Bulevar'], //
            ['identificador' => 'B:MHR:22 V:001421', 'alias' => 'MANHATTAN', 'nombre' => 'MANHATTAN REVOLUTION 500', 'bar' => 'Parada'], //
            ['identificador' => 'B:FXQ:23 V:004209', 'alias' => 'FENIX', 'nombre' => 'FENIX 500', 'bar' => 'D´Angelo'], //
            ['identificador' => 'B:ARC:19 V:006330', 'alias' => 'ARCADE', 'nombre' => 'ARCADE 500', 'bar' => 'Coratge'], //
            ['identificador' => 'B:RLQ:24 V:002247', 'alias' => 'ROCKET LINK BAR', 'nombre' => 'ROCKET LINK 500', 'bar' => 'Coratge'], //
            ['identificador' => 'B:NFQ:19 V:006815', 'alias' => 'NEFERTARI', 'nombre' => 'NEFERTARI 500', 'bar' => 'Tramusser'], //
            ['identificador' => 'B:PLQ:21 V:062933', 'alias' => 'PINGÜINOS', 'nombre' => 'PINGÜINOS LOCOS 500', 'bar' => 'Karma'], //
            ['identificador' => 'B:PLQ:21 V:064291', 'alias' => 'PINGÜINOS', 'nombre' => 'PINGÜINOS LOCOS 500', 'bar' => 'Madrigueres 64'], //
            ['identificador' => 'B:MBQ:24 V:000141', 'alias' => 'MANHATTAN', 'nombre' => 'MANHATTAN BOOM 500', 'bar' => 'Madrigueres 64'], //
            ['identificador' => 'B:PLQ:21 V:062931', 'alias' => 'PINGÜINOS', 'nombre' => 'PINGÜINOS LOCOS 500', 'bar' => 'Mas y Mas'], //
            ['identificador' => 'B:MHR:22 V:001234', 'alias' => 'MANHATTAN', 'nombre' => 'MANHATTAN REVOLUTION 500', 'bar' => 'Sport'], //
            ['identificador' => 'B:SAQ:21 V:065082', 'alias' => 'SAMARKANDA', 'nombre' => 'SAMARKANDA 500', 'bar' => 'Pedrera'], //
            ['identificador' => 'B:REY:19 V:003328', 'alias' => 'REY DE LA SUERTE', 'nombre' => 'MERKUR REY DE LA SUERTE 500', 'bar' => 'Maya'], //
            ['identificador' => 'B:AB1:19 V:010330', 'alias' => 'ACTION STAR', 'nombre' => 'ACTION STAR BAR 500', 'bar' => 'Maya'], //
            ['identificador' => 'B:HLQ:24 V:000039', 'alias' => 'HIT DE LINK', 'nombre' => 'HIT DE LINK 500', 'bar' => '8 de Copes'],
            ['identificador' => 'B:REY:19 V:003337', 'alias' => 'REY DE LA SUERTE', 'nombre' => 'MERKUR REY DE LA SUERTE 500', 'bar' => 'Pulpo Pirata'], //
            ['identificador' => 'B:PAQ:24 V:000847', 'alias' => 'MANHATTAN', 'nombre' => 'MANHATTAN PARTY 500', 'bar' => 'Pulpo Pirata'], //
            ['identificador' => 'B:SAQ:21 V:065084', 'alias' => 'SAMARKANDA', 'nombre' => 'SAMARKANDA 500', 'bar' => 'Angel de Benidorm'], //
            ['identificador' => 'B:REY:19 V:003333', 'alias' => 'REY DE LA SUERTE', 'nombre' => 'MERKUR REY DE LA SUERTE 500', 'bar' => 'Picadilly Mediterráneo'], //
            ['identificador' => 'B:PLQ:21 V:064289', 'alias' => 'PINGÜINOS', 'nombre' => 'PINGÜINOS LOCOS 500', 'bar' => 'Veneto'], //
            ['identificador' => 'B:MHR:22 V:001234', 'alias' => 'MANHATTAN', 'nombre' => 'MANHATTAN REVOLUTION 500', 'bar' => 'Veneto'], //
            ['identificador' => 'B:N3B:19 V:035950', 'alias' => 'NOVOLINE III BAR', 'nombre' => 'NOVOLINE III BAR 500', 'bar' => 'Zarcar'], //
            ['identificador' => 'B:REY:19 V:003335', 'alias' => 'REY DE LA SUERTE', 'nombre' => 'MERKUR REY DE LA SUERTE 500', 'bar' => 'Albeniz'], //
            ['identificador' => 'B:MHR:23 V:001363', 'alias' => 'MANHATTAN', 'nombre' => 'MANHATTAN REVOLUTION 500', 'bar' => 'Puntxaetes'], //
            ['identificador' => 'B:BLQ:17 V:006173', 'alias' => 'BURLESQUE', 'nombre' => 'BURLESQUE 500', 'bar' => 'Puntxaetes'], //
            ['identificador' => 'B:MHR:24 V:001424', 'alias' => 'MANHATTAN', 'nombre' => 'MANHATTAN REVOLUTION 500', 'bar' => 'De Aca y Alla'], //
            ['identificador' => 'B:PAQ:24 V:000842', 'alias' => 'MANHATTAN', 'nombre' => 'MANHATTAN PARTY 500', 'bar' => 'Yorkos'], //
            ['identificador' => 'B:RCQ:21 V:064255', 'alias' => 'ROYAL CASH BAR', 'nombre' => 'NOVOLINE ROYAL CASH BAR 500', 'bar' => 'Yorkos'], //
            ['identificador' => 'B:HLQ:24 V:000037', 'alias' => 'HIT DE LINK', 'nombre' => 'HIT DE LINK 500', 'bar' => 'El Sol'], //
            ['identificador' => 'B:AB1:19 V:010340', 'alias' => 'ACTION STAR', 'nombre' => 'ACTION STAR BAR 500', 'bar' => 'El Sol'], //
            ['identificador' => 'B:HLQ:24 V:000162', 'alias' => 'HIT DE LINK', 'nombre' => 'HIT DE LINK 500', 'bar' => 'La Grada Deportiva'], //
            ['identificador' => 'B:AB1:19 V:010424', 'alias' => 'ACTION STAR', 'nombre' => 'ACTION STAR BAR 500', 'bar' => 'La Grada Deportiva'], //
            ['identificador' => 'B:PLQ:21 V:062935', 'alias' => 'PINGÜINOS', 'nombre' => 'PINGÜINOS LOCOS 500', 'bar' => 'Bulevar Benidorm'], //
            ['identificador' => 'B:CHQ:18 V:039144', 'alias' => 'CHIRINGUITO', 'nombre' => 'CHIRINGUITO 500', 'bar' => 'New Litte'], //
            ['identificador' => 'B:MHR:23 V:001326', 'alias' => 'MANHATTAN', 'nombre' => 'MANHATTAN REVOLUTION 500', 'bar' => 'Las Tablas'], //
            ['identificador' => 'B:PWQ:22 V:077386', 'alias' => 'POWER CASH', 'nombre' => 'NOVOLINE POWER CASH 500', 'bar' => 'Las Tablas'], //
            ['identificador' => 'B:HLQ:24 V:000161', 'alias' => 'HIT DE LINK', 'nombre' => 'HIT DE LINK 500', 'bar' => 'Picadilly'], //

            /*['identificador' => 'B:PIQ:15 V:000359', 'alias' => 'PIRATA DEL CARIBE', 'nombre' => 'PIRATAS CARIBE 500', 'bar' => 'Almacen'],
            ['identificador' => 'B:OCQ:15 V:000193', 'alias' => 'OCEAN', 'nombre' => 'OCEAN 500', 'bar' => 'Almacen'],
            ['identificador' => 'B:HEQ:15 V:000007', 'alias' => 'GRAN HERMANO', 'nombre' => 'GRAN HERMANO 500', 'bar' => 'Almacen'],
            ['identificador' => 'B:YEQ:15 V:000271', 'alias' => 'YETIMANIA', 'nombre' => 'YETIMANIA 500', 'bar' => 'Almacen'],
            ['identificador' => 'B:NFQ:19 V:006816', 'alias' => 'NEFERTARI', 'nombre' => 'NEFERTARI 500', 'bar' => 'Almacen'],
            ['identificador' => 'B:CHQ:18 V:039142', 'alias' => 'CHIRINGUITO', 'nombre' => 'CHIRINGUITO 500 BEACH', 'bar' => 'Almacen'],
            ['identificador' => 'B:CHQ:18 V:039145', 'alias' => 'CHIRINGUITO', 'nombre' => 'CHIRINGUITO 500 BEACH', 'bar' => 'Almacen'],
            ['identificador' => 'B:CHQ:18 V:039143', 'alias' => 'CHIRINGUITO', 'nombre' => 'CHIRINGUITO 500 BEACH', 'bar' => 'Almacen'],
            ['identificador' => 'B:NLB:16 V:686780', 'alias' => 'NOVOLINE II BAR', 'nombre' => 'NOVOLINE II BAR 500', 'bar' => 'Almacen'],
            ['identificador' => 'B:CHQ:18 V:039141', 'alias' => 'CHIRINGUITO', 'nombre' => 'CHIRINGUITO 500 BEACH', 'bar' => 'Almacen'],
            ['identificador' => 'B:ARC:19 V:006325', 'alias' => 'RF ARCADE', 'nombre' => 'RF ARCADE 500', 'bar' => 'Almacen'],
            ['identificador' => 'B:PIQ:15 V:000406', 'alias' => 'PIRATA DEL CARIBE', 'nombre' => 'PIRATAS CARIBE 500', 'bar' => 'Almacen'],
            ['identificador' => 'B:REY:19 V:003334', 'alias' => 'REY DE LA SUERTE', 'nombre' => 'REY DE LA SUERTE 500', 'bar' => 'Almacen'],
            ['identificador' => 'B:DOQ:16 V:017673', 'alias' => 'DORADO', 'nombre' => 'EL DORADO 500', 'bar' => 'Almacen'],
            ['identificador' => 'B:REY:19 V:003332', 'alias' => 'REY DE LA SUERTE', 'nombre' => 'REY DE LA SUERTE 500', 'bar' => 'Almacen'],
            ['identificador' => 'B:PLQ:21 V:064285', 'alias' => 'PINGÜINOS', 'nombre' => 'GIGAMES PINGÜINOS LOCOS', 'bar' => 'Almacen'],
            ['identificador' => 'B:PLQ:21 V:064290', 'alias' => 'PINGÜINOS', 'nombre' => 'GIGAMES PINGÜINOS LOCOS', 'bar' => 'Almacen'],
            ['identificador' => 'B:DOQ:16 V:017676', 'alias' => 'DORADO', 'nombre' => 'EL DORADO 500', 'bar' => 'Almacen'],
            ['identificador' => 'B:SAQ:21 V:065085', 'alias' => 'SAMARKANDA', 'nombre' => 'GIGAMES SAMARKANDA', 'bar' => 'Almacen'],*/
        ];


        foreach ($maquinasBares as $maquina) {
            $bar = Bar::where('name', $maquina['bar'])->first();
            $machine = Machine::create([
                'identificador' => $maquina['identificador'],
                'name' => $maquina['nombre'],
                'alias' => $maquina['alias'],
                'bar_id' => $bar->id,
                'delegation_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // DATAFONO APUESTAS Y CAMBIO
        $paraRecargasAuxiliares = [
            ['identificador' => 'NoMachine', 'alias' => 'CAMBIO', 'nombre' => 'CAMBIO'],
            ['identificador' => 'NoMachine', 'alias' => 'DATAFONO', 'nombre' => 'DATAFONO'],
            ['identificador' => 'NoMachine', 'alias' => 'APUESTAS DEPORTIVAS', 'nombre' => 'APUESTAS DEPORTIVAS'],
            ['identificador' => 'NoMachine', 'alias' => 'ACUMULADO', 'nombre' => 'ACUMULADO']
        ];

        // Obtener todos los salones en la delegación 1
        $salones = Local::whereHas('zone', function ($query) {
            $query->where('delegation_id', 1);
        })->get();

        foreach ($paraRecargasAuxiliares as $Aux) {
            foreach ($salones as $local) { // Iterar sobre cada salón
                // Crear un identificador único para la máquina
                $identificadorUnico = $Aux['identificador'] . '_' . $local->name;

                $machine = Machine::create([
                    'identificador' => $identificadorUnico, // Usar identificador único
                    'name' => $Aux['nombre'], // Usar nombre del auxiliar
                    'alias' => $Aux['alias'], // Usar alias del auxiliar
                    'local_id' => $local->id, // Asociar a cada salón
                    'delegation_id' => 1, // Obtener delegation_id a través de la zona
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
