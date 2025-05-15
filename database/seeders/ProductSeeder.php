<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Producte;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Disfressa de gamba
        $disfressaGamba = Producte::create([
            'nom' => 'Disfressa de gamba',
            'descr' => 'Es tracta d\'una disfressa de talla estàndard amb una confecció folgada, i menys ajustada, que és vàlida per a diferents mesures.',
            'preu' => 34.99,
            'enviament' => 3.00,
            'dies' => 3,
            'devolucio' => true,
            'devolucioGratis' => false,
            'categoria_id' => 4,
            'destacat' => true,
            'vendedor_id' => 1
        ]);

        $disfressaGamba->caracteristiques()->createMany([
            [
                'nom' => 'S',
                'stock' => 25,
                'oferta' => 20,
                'propietats' => json_encode([
                    'talla' => 'S',
                    'material' => 'Polièster',
                    'rentat' => '30°C',
                    'altura_recomanada' => '150-160cm'
                ]),
                'img' => [
                    'images/products/gamba1.jpg',
                    'images/products/gamba2.jpg',
                    'images/products/gamba3.jpg',
                    'images/products/gamba4.jpg'
                ]
            ],
            [
                'nom' => 'M',
                'stock' => 25,
                'oferta' => 20,
                'propietats' => json_encode([
                    'talla' => 'M',
                    'material' => 'Polièster',
                    'rentat' => '30°C',
                    'altura_recomanada' => '160-170cm'
                ]),
                'img' => [
                    'images/products/gamba1.jpg',
                    'images/products/gamba2.jpg',
                    'images/products/gamba3.jpg',
                    'images/products/gamba4.jpg'
                ]
            ],
            [
                'nom' => 'L',
                'stock' => 25,
                'oferta' => 20,
                'propietats' => json_encode([
                    'talla' => 'L',
                    'material' => 'Polièster',
                    'rentat' => '30°C',
                    'altura_recomanada' => '170-180cm'
                ]),
                'img' => [
                    'images/products/gamba1.jpg',
                    'images/products/gamba2.jpg',
                    'images/products/gamba3.jpg',
                    'images/products/gamba4.jpg'
                ]
            ],
            [
                'nom' => 'XL',
                'stock' => 20,
                'oferta' => 20,
                'propietats' => json_encode([
                    'talla' => 'XL',
                    'material' => 'Polièster',
                    'rentat' => '30°C',
                    'altura_recomanada' => '180-190cm'
                ]),
                'img' => [
                    'images/products/gamba1.jpg',
                    'images/products/gamba2.jpg',
                    'images/products/gamba3.jpg',
                    'images/products/gamba4.jpg'
                ]
            ]
        ]);

        // Disfressa de Porc Inflable
        $disfressaPorc = Producte::create([
            'nom' => 'Disfressa de Porc Inflable',
            'descr' => 'Disfressa inflable està fet de polièster 100%. S\'adapta a tots els adults de 150 cm a 190 cm.',
            'preu' => 39.99,
            'enviament' => 0.00,
            'dies' => 2,
            'devolucio' => true,
            'devolucioGratis' => true,
            'categoria_id' => 4,
            'destacat' => true,
            'vendedor_id' => 2
        ]);

        $disfressaPorc->caracteristiques()->createMany([
            [
                'nom' => 'Talla Única',
                'stock' => 75,
                'oferta' => 0,
                'propietats' => json_encode([
                    'talla' => 'Única',
                    'material' => 'Polièster 100%',
                    'bateria' => 'AA x4 (no incloses)',
                    'altura_recomanada' => '150-190cm'
                ]),
                'img' => [
                    'images/products/porc1.jpg',
                    'images/products/porc2.jpg',
                    'images/products/porc3.jpg',
                    'images/products/porc4.jpg',
                    'images/products/porc5.jpg'
                ]
            ]
        ]);

        // Disfressa La Reina
        $disfressaReina = Producte::create([
            'nom' => 'Disfressa La Reina',
            'descr' => 'Aquesta disfressa de reina de inglanterra per a home és l\'elecció ideal per a qualsevol carnestoltes o comiat de solter.',
            'preu' => 32.22,
            'enviament' => 3.00,
            'dies' => 2,
            'devolucio' => true,
            'devolucioGratis' => false,
            'categoria_id' => 4,
            'destacat' => false,
            'vendedor_id' => 3
        ]);

        $disfressaReina->caracteristiques()->createMany([
            [
                'nom' => 'M',
                'stock' => 40,
                'oferta' => 15,
                'propietats' => json_encode([
                    'talla' => 'M',
                    'material' => 'Polièster',
                    'rentat' => '30°C',
                    'inclou' => 'Vestit i corona'
                ]),
                'img' => [
                    'images/products/reina1.jpg',
                    'images/products/reina2.jpg',
                    'images/products/reina3.jpg',
                    'images/products/reina4.jpg'
                ]
            ],
            [
                'nom' => 'L',
                'stock' => 35,
                'oferta' => 15,
                'propietats' => json_encode([
                    'talla' => 'L',
                    'material' => 'Polièster',
                    'rentat' => '30°C',
                    'inclou' => 'Vestit i corona'
                ]),
                'img' => [
                    'images/products/reina1.jpg',
                    'images/products/reina2.jpg',
                    'images/products/reina3.jpg',
                    'images/products/reina4.jpg'
                ]
            ]
        ]);

        // Disfressa de Pota de Pernil
        $disfressaPernil = Producte::create([
            'nom' => 'Disfressa de Pota de Pernil',
            'descr' => 'Inclou: Disfressa per a adults. Disfressa d\'una sola peça. Color Marró. Fet de 100% Polièster.',
            'preu' => 26.99,
            'enviament' => 3.00,
            'dies' => 2,
            'devolucio' => true,
            'devolucioGratis' => false,
            'categoria_id' => 4,
            'destacat' => false,
            'vendedor_id' => 4
        ]);

        $disfressaPernil->caracteristiques()->createMany([
            [
                'nom' => 'S',
                'stock' => 15,
                'oferta' => 0,
                'propietats' => json_encode([
                    'talla' => 'S',
                    'material' => 'Polièster 100%',
                    'rentat' => '30°C',
                    'color' => 'Marró'
                ]),
                'img' => [
                    'images/products/PERNIL1.jpg',
                    'images/products/PERNIL2.jpg',
                    'images/products/PERNIL3.jpg',
                    'images/products/PERNIL4.jpg'
                ]
            ],
            [
                'nom' => 'M',
                'stock' => 15,
                'oferta' => 0,
                'propietats' => json_encode([
                    'talla' => 'M',
                    'material' => 'Polièster 100%',
                    'rentat' => '30°C',
                    'color' => 'Marró'
                ]),
                'img' => [
                    'images/products/PERNIL1.jpg',
                    'images/products/PERNIL2.jpg',
                    'images/products/PERNIL3.jpg',
                    'images/products/PERNIL4.jpg'
                ]
            ],
            [
                'nom' => 'L',
                'stock' => 15,
                'oferta' => 0,
                'propietats' => json_encode([
                    'talla' => 'L',
                    'material' => 'Polièster 100%',
                    'rentat' => '30°C',
                    'color' => 'Marró'
                ]),
                'img' => [
                    'images/products/PERNIL1.jpg',
                    'images/products/PERNIL2.jpg',
                    'images/products/PERNIL3.jpg',
                    'images/products/PERNIL4.jpg'
                ]
            ],
            [
                'nom' => 'XL',
                'stock' => 10,
                'oferta' => 0,
                'propietats' => json_encode([
                    'talla' => 'XL',
                    'material' => 'Polièster 100%',
                    'rentat' => '30°C',
                    'color' => 'Marró'
                ]),
                'img' => [
                    'images/products/PERNIL1.jpg',
                    'images/products/PERNIL2.jpg',
                    'images/products/PERNIL3.jpg',
                    'images/products/PERNIL4.jpg'
                ]
            ]
        ]);

        // Disfressa de Radar
        $disfressaRadar = Producte::create([
            'nom' => 'Disfressa de Radar',
            'descr' => 'Material 100% polièster, es pot rentar a màquina (temperatura máxima30º)',
            'preu' => 22.62,
            'enviament' => 3.00,
            'dies' => 2,
            'devolucio' => true,
            'devolucioGratis' => false,
            'categoria_id' => 4,
            'destacat' => false,
            'vendedor_id' => 5
        ]);

        $disfressaRadar->caracteristiques()->createMany([
            [
                'nom' => 'Talla Única',
                'stock' => 60,
                'oferta' => 25,
                'propietats' => json_encode([
                    'talla' => 'Única',
                    'material' => 'Polièster 100%',
                    'rentat' => '30°C',
                    'tipus' => 'Una peça'
                ]),
                'img' => [
                    'images/products/radar1.jpg',
                    'images/products/radar2.jpg'
                ]
            ]
        ]);
        // JBL Auriculars sense fil
        $auricularsJBL = Producte::create([
            'nom' => 'Auriculars sense fil JBL',
            'descr' => 'JBL Signature Sound: dotats d\'uns potents amplificadors de 40 mm',
            'preu' => 109.00,
            'enviament' => 0.00,
            'dies' => 2,
            'devolucio' => true,
            'devolucioGratis' => true,
            'categoria_id' => 1,
            'destacat' => true,
            'vendedor_id' => 1
        ]);

        $auricularsJBL->caracteristiques()->createMany([
            [
                'nom' => 'Negre Mat',
                'stock' => 50,
                'oferta' => 15,
                'propietats' => json_encode([
                    'color' => 'Negre Mat',
                    'bluetooth' => '5.0',
                    'bateria' => '30 hores',
                    'resistencia_aigua' => 'IPX4'
                ]),
                'img' => [
                    'images/products/jbl_1.jpg',
                    'images/products/jbl_2.jpg',
                    'images/products/jbl_3.jpg',
                    'images/products/jbl_4.jpg'
                ]
            ]
        ]);

        // Auriculars amb fil
        $auricularsBasic = Producte::create([
            'nom' => 'Auriculars amb fil Basic',
            'descr' => 'Auriculars interns lleugers amb diafragma de 9 mm, 8 hz-22 khz, taps de silicona, en color negre.',
            'preu' => 6.35,
            'enviament' => 3.00,
            'dies' => 3,
            'devolucio' => true,
            'devolucioGratis' => false,
            'categoria_id' => 1,
            'destacat' => false,
            'vendedor_id' => 2
        ]);

        $auricularsBasic->caracteristiques()->createMany([
            [
                'nom' => 'Clàssic',
                'stock' => 200,
                'oferta' => 0,
                'propietats' => json_encode([
                    'color' => 'Negre',
                    'longitud_cable' => '1.2m',
                    'connector' => '3.5mm'
                ]),
                'img' => [
                    'images/products/auriculars1.jpg',
                    'images/products/auriculars2.jpg',
                    'images/products/auriculars3.jpg'
                ]
            ]
        ]);

        // Altaveu Bluetooth RIENOK
        $altaveuRienok = Producte::create([
            'nom' => 'Altaveu Bluetooth RIENOK',
            'descr' => 'Equipat amb dos radiadors de baixos i una alta potència de 30 W, el RIENOK altaveu bluetooth li brinda un so Hi-*Fi potent i ric.',
            'preu' => 28.89,
            'enviament' => 3.00,
            'dies' => 2,
            'devolucio' => true,
            'devolucioGratis' => true,
            'categoria_id' => 1,
            'destacat' => false,
            'vendedor_id' => 3
        ]);

        $altaveuRienok->caracteristiques()->createMany([
            [
                'nom' => 'Pro Edition',
                'stock' => 75,
                'oferta' => 20,
                'propietats' => json_encode([
                    'color' => 'Negre',
                    'potencia' => '30W',
                    'bateria' => '12 hores',
                    'bluetooth' => '5.0'
                ]),
                'img' => [
                    'images/products/altaveu1.jpg',
                    'images/products/altaveu2.jpg',
                    'images/products/altaveu3.jpg'
                ]
            ]
        ]);

        // JBL Go 4
        $altaveuJBL = Producte::create([
            'nom' => 'Altaveu sense fil portàtil JBL Go 4',
            'descr' => 'Que el ritme no pari: el JBL Go 4 amb un cridaner disseny està a punt de convertir-se en el teu altaveu d\'ús diari',
            'preu' => 38.99,
            'enviament' => 0.00,
            'dies' => 1,
            'devolucio' => true,
            'devolucioGratis' => true,
            'categoria_id' => 1,
            'destacat' => true,
            'vendedor_id' => 1
        ]);

        $altaveuJBL->caracteristiques()->createMany([
            [
                'nom' => 'Standard',
                'stock' => 100,
                'oferta' => 0,
                'propietats' => json_encode([
                    'color' => 'Blau',
                    'potencia' => '15W',
                    'resistencia_aigua' => 'IPX67',
                    'bluetooth' => '5.1'
                ]),
                'img' => [
                    'images/products/altavoz1.jpg',
                    'images/products/altavoz2.jpg',
                    'images/products/altavoz3.jpg'
                ]
            ]
        ]);

        // Logitech G PRO X SUPERLIGHT
        $ratoliLogitech = Producte::create([
            'nom' => 'Logitech G PRO X SUPERLIGHT ratolí',
            'descr' => 'Fet per i per a jugadors professionals: Dissenyat amb els principals professionals desports electrònics.',
            'preu' => 115.00,
            'enviament' => 0.00,
            'dies' => 1,
            'devolucio' => true,
            'devolucioGratis' => true,
            'categoria_id' => 1,
            'destacat' => true,
            'vendedor_id' => 4
        ]);

        $ratoliLogitech->caracteristiques()->createMany([
            [
                'nom' => 'Gaming Edition',
                'stock' => 30,
                'oferta' => 10,
                'propietats' => json_encode([
                    'color' => 'Blanc',
                    'dpi' => '25600',
                    'pes' => '63g',
                    'sensor' => 'HERO 25K'
                ]),
                'img' => [
                    'images/products/ratoli-gaming-1.jpg',
                    'images/products/ratoli-gaming-2.jpg',
                    'images/products/ratoli-gaming-3.jpg',
                    'images/products/ratoli-gaming-4.jpg',
                    'images/products/ratoli-gaming-5.jpg'
                ]
            ]
        ]);

        // Logitech K120
        $teclatLogitech = Producte::create([
            'nom' => 'Logitech K120 teclat amb cable',
            'descr' => 'Escriptura Còmoda: Aquest teclat USB que permet escriure còmodament durant molt de temps.',
            'preu' => 16.99,
            'enviament' => 3.00,
            'dies' => 2,
            'devolucio' => true,
            'devolucioGratis' => false,
            'categoria_id' => 1,
            'destacat' => false,
            'vendedor_id' => 4
        ]);

        $teclatLogitech->caracteristiques()->createMany([
            [
                'nom' => 'Standard',
                'stock' => 150,
                'oferta' => 0,
                'propietats' => json_encode([
                    'layout' => 'QWERTY Español',
                    'tipus' => 'Membrana',
                    'longitud_cable' => '1.5m'
                ]),
                'img' => [
                    'images/products/teclat_cable-1.jpg',
                    'images/products/teclat_cable-2.jpg',
                    'images/products/teclat_cable-3.jpg',
                    'images/products/teclat_cable-4.jpg',
                    'images/products/teclat_cable-5.jpg'
                ]
            ]
        ]);

        // Monitor Ultragear
        $monitorLG = Producte::create([
            'nom' => 'Monitor Ultragear, 27 Polzades',
            'descr' => 'Panell IPS de freqüència d\'actualització de 144Hz, i amb 1ms de màxima velocitat de resposta (GtG).',
            'preu' => 463.15,
            'enviament' => 0.00,
            'dies' => 4,
            'devolucio' => true,
            'devolucioGratis' => true,
            'categoria_id' => 1,
            'destacat' => true,
            'vendedor_id' => 5
        ]);

        $monitorLG->caracteristiques()->createMany([
            [
                'nom' => 'Gaming',
                'stock' => 25,
                'oferta' => 5,
                'propietats' => json_encode([
                    'resolucio' => '2560x1440',
                    'temps_resposta' => '1ms',
                    'taxa_refresc' => '144Hz',
                    'hdr' => 'HDR10'
                ]),
                'img' => [
                    'images/products/monitor_ultragear-1.jpg',
                    'images/products/monitor_ultragear-2.jpg',
                    'images/products/monitor_ultragear-3.jpg',
                    'images/products/monitor_ultragear-4.jpg',
                    'images/products/monitor_ultragear-5.jpg'
                ]
            ]
        ]);

        // Fregidora d'aire
        $fregidora = Producte::create([
            'nom' => 'Fregidora d\'aire',
            'descr' => 'Fregidora dietètica que permet cuinar amb una sola cullerada d\'oli, aconseguint uns resultats més sans',
            'preu' => 60.00,
            'enviament' => 3.00,
            'dies' => 2,
            'devolucio' => true,
            'devolucioGratis' => false,
            'categoria_id' => 2,
            'destacat' => true,
            'vendedor_id' => 2
        ]);

        $fregidora->caracteristiques()->createMany([
            [
                'nom' => 'Model Standard',
                'stock' => 45,
                'oferta' => 10,
                'propietats' => json_encode([
                    'capacitat' => '3.5L',
                    'potencia' => '1500W',
                    'temperatura' => '80-200°C',
                    'temporizador' => '60 min'
                ]),
                'img' => [
                    'images/products/fregidora_aire-1.png',
                    'images/products/fregidora_aire-2.png',
                    'images/products/fregidora_aire-3.png',
                    'images/products/fregidora_aire-4.png',
                    'images/products/fregidora_aire-5.png'
                ]
            ]
        ]);

        // Cecotec cafetera express
        $cafeteraCecotec = Producte::create([
            'nom' => 'Cecotec cafetera express',
            'descr' => 'Cafetera express per a cafè espresso i cappuccino, prepara tot tipus de cafès amb només prémer un botó',
            'preu' => 76.78,
            'enviament' => 0.00,
            'dies' => 3,
            'devolucio' => true,
            'devolucioGratis' => true,
            'categoria_id' => 2,
            'destacat' => true,
            'vendedor_id' => 3
        ]);

        $cafeteraCecotec->caracteristiques()->createMany([
            [
                'nom' => 'Professional',
                'stock' => 30,
                'oferta' => 0,
                'propietats' => json_encode([
                    'pressio' => '20 bars',
                    'potencia' => '1350W',
                    'capacitat' => '1.5L',
                    'tipus_cafe' => 'Mòlt i càpsules'
                ]),
                'img' => [
                    'images/products/cecotec_cafetera-1.jpg',
                    'images/products/cecotec_cafetera-2.jpg',
                    'images/products/cecotec_cafetera-3.jpg',
                    'images/products/cecotec_cafetera-4.jpg',
                    'images/products/cecotec_cafetera-5.jpg',
                    'images/products/cecotec_cafetera-6.jpg'
                ]
            ]
        ]);

        // Envasadora al buit 4 en 1
        $envasadora = Producte::create([
            'nom' => 'Envasadora al buit 4 en 1',
            'descr' => 'Sellado rápido y trabajo continuo: equipada con tecnología Globefish para un trabajo continuo de alta velocidad',
            'preu' => 39.99,
            'enviament' => 3.00,
            'dies' => 2,
            'devolucio' => true,
            'devolucioGratis' => false,
            'categoria_id' => 2,
            'destacat' => false,
            'vendedor_id' => 4
        ]);

        $envasadora->caracteristiques()->createMany([
            [
                'nom' => 'Blanc',
                'stock' => 60,
                'oferta' => 15,
                'propietats' => json_encode([
                    'color' => 'Blanc',
                    'potencia' => '120W',
                    'pressio' => '-0.8 bar',
                    'modes' => '4 funcions'
                ]),
                'img' => [
                    'images/products/envasadora_buit-blanc-1.jpg',
                    'images/products/envasadora_buit-blanc-2.jpg',
                    'images/products/envasadora_buit-blanc-3.jpg',
                    'images/products/envasadora_buit-blanc-4.jpg',
                    'images/products/envasadora_buit-blanc-5.jpg'
                ]
            ],
            [
                'nom' => 'Gris',
                'stock' => 45,
                'oferta' => 15,
                'propietats' => json_encode([
                    'color' => 'Gris',
                    'potencia' => '120W',
                    'pressio' => '-0.8 bar',
                    'modes' => '4 funcions'
                ]),
                'img' => [
                    'images/products/envasadora_buit-gris-1.jpg',
                    'images/products/envasadora_buit-gris-2.jpg',
                    'images/products/envasadora_buit-gris-3.jpg',
                    'images/products/envasadora_buit-gris-4.jpg',
                    'images/products/envasadora_buit-gris-5.jpg'
                ]
            ]
        ]);

        // Cafetera espresso de càpsules
        $cafeteraEspresso = Producte::create([
            'nom' => 'Cafetera espresso de càpsules',
            'descr' => 'Gaudeix de la versatilitat amb aquesta cafetera que prepara dos cafès simultàniament o un espresso doble en una sola tassa per a una experiència de cafè a la teva mesura.',
            'preu' => 119.99,
            'enviament' => 0.00,
            'dies' => 2,
            'devolucio' => true,
            'devolucioGratis' => true,
            'categoria_id' => 2,
            'destacat' => true,
            'vendedor_id' => 5
        ]);

        $cafeteraEspresso->caracteristiques()->createMany([
            [
                'nom' => 'Blanc',
                'stock' => 35,
                'oferta' => 0,
                'propietats' => json_encode([
                    'color' => 'Blanc',
                    'pressio' => '19 bars',
                    'potencia' => '1450W',
                    'capacitat' => '1.1L'
                ]),
                'img' => [
                    'images/products/cafetera_espresso-blanc-1.jpg',
                    'images/products/cafetera_espresso-blanc-2.jpg',
                    'images/products/cafetera_espresso-blanc-3.jpg',
                    'images/products/cafetera_espresso-blanc-4.jpg',
                    'images/products/cafetera_espresso-blanc-5.jpg'
                ]
            ],
            [
                'nom' => 'Negre',
                'stock' => 40,
                'oferta' => 0,
                'propietats' => json_encode([
                    'color' => 'Negre',
                    'pressio' => '19 bars',
                    'potencia' => '1450W',
                    'capacitat' => '1.1L'
                ]),
                'img' => [
                    'images/products/cafetera_espresso-negre-1.jpg',
                    'images/products/cafetera_espresso-negre-2.jpg',
                    'images/products/cafetera_espresso-negre-3.jpg',
                    'images/products/cafetera_espresso-negre-4.jpg',
                    'images/products/cafetera_espresso-negre-5.jpg'
                ]
            ]
        ]);

        // Paperera de Metall
        $paperera = Producte::create([
            'nom' => 'Paperera de Metall',
            'descr' => 'Elegància i Estil al teu Espai: La nostra paperera combina metall resistent amb una tapa de bambú elegant',
            'preu' => 16.95,
            'enviament' => 3.00,
            'dies' => 3,
            'devolucio' => true,
            'devolucioGratis' => false,
            'categoria_id' => 2,
            'destacat' => false,
            'vendedor_id' => 2
        ]);

        $paperera->caracteristiques()->createMany([
            [
                'nom' => 'Negre',
                'stock' => 100,
                'oferta' => 0,
                'propietats' => json_encode([
                    'color' => 'Negre',
                    'material' => 'Metall i bambú',
                    'capacitat' => '12L',
                    'dimensions' => '25x35cm'
                ]),
                'img' => [
                    'images/products/paperera_metall-negre-1.jpg',
                    'images/products/paperera_metall-negre-2.jpg',
                    'images/products/paperera_metall-negre-3.jpg',
                    'images/products/paperera_metall-negre-4.jpg'
                ]
            ],
            [
                'nom' => 'Blanc',
                'stock' => 85,
                'oferta' => 0,
                'propietats' => json_encode([
                    'color' => 'Blanc',
                    'material' => 'Metall i bambú',
                    'capacitat' => '12L',
                    'dimensions' => '25x35cm'
                ]),
                'img' => [
                    'images/products/paperera_metall-blanc-1.jpg',
                    'images/products/paperera_metall-blanc-2.jpg',
                    'images/products/paperera_metall-blanc-3.jpg',
                    'images/products/paperera_metall-blanc-4.jpg'
                ]
            ]
        ]);

        // A GAMBA
        $gamba = Producte::create([
            'nom' => 'A GAMBA',
            'descr' => 'Samarreta de màniga curta en punt de cotó suau, coll rodó rivetat i baix recte. El seu suau teixit de cotó aconseguirà que et sentis còmoda en qualsevol època de l\'any.',
            'preu' => 16.99,
            'enviament' => 3.00,
            'dies' => 2,
            'devolucio' => true,
            'devolucioGratis' => false,
            'categoria_id' => 3,
            'destacat' => true,
            'vendedor_id' => 2
        ]);

        $gamba->caracteristiques()->createMany([
            [
                'nom' => 'S',
                'stock' => 50,
                'oferta' => 0,
                'propietats' => json_encode([
                    'talla' => 'S',
                    'material' => '100% cotó',
                    'rentat' => '30°C',
                    'tipus' => 'Unisex'
                ]),
                'img' => [
                    'images/products/G1.png',
                    'images/products/G2.png',
                    'images/products/G3.png',
                    'images/products/G4.png'
                ]
            ],
            [
                'nom' => 'M',
                'stock' => 75,
                'oferta' => 0,
                'propietats' => json_encode([
                    'talla' => 'M',
                    'material' => '100% cotó',
                    'rentat' => '30°C',
                    'tipus' => 'Unisex'
                ]),
                'img' => [
                    'images/products/G1.png',
                    'images/products/G2.png',
                    'images/products/G3.png',
                    'images/products/G4.png'
                ]
            ],
            [
                'nom' => 'L',
                'stock' => 75,
                'oferta' => 0,
                'propietats' => json_encode([
                    'talla' => 'L',
                    'material' => '100% cotó',
                    'rentat' => '30°C',
                    'tipus' => 'Unisex'
                ]),
                'img' => [
                    'images/products/G1.png',
                    'images/products/G2.png',
                    'images/products/G3.png',
                    'images/products/G4.png'
                ]
            ],
            [
                'nom' => 'XL',
                'stock' => 40,
                'oferta' => 0,
                'propietats' => json_encode([
                    'talla' => 'XL',
                    'material' => '100% cotó',
                    'rentat' => '30°C',
                    'tipus' => 'Unisex'
                ]),
                'img' => [
                    'images/products/G1.png',
                    'images/products/G2.png',
                    'images/products/G3.png',
                    'images/products/G4.png'
                ]
            ]
        ]);

        // Ino exploradino
        $ino = Producte::create([
            'nom' => 'Ino exploradino',
            'descr' => 'Samarreta de màniga curta en punt de cotó suau, coll rodó rivetat i baix recte. El seu suau teixit de cotó aconseguirà que et sentis còmoda en qualsevol època de l\'any.',
            'preu' => 17.99,
            'enviament' => 3.00,
            'dies' => 2,
            'devolucio' => true,
            'devolucioGratis' => false,
            'categoria_id' => 3,
            'destacat' => true,
            'vendedor_id' => 3
        ]);

        $ino->caracteristiques()->createMany([
            [
                'nom' => 'S',
                'stock' => 45,
                'oferta' => 10,
                'propietats' => json_encode([
                    'talla' => 'S',
                    'material' => '100% cotó',
                    'rentat' => '30°C',
                    'tipus' => 'Unisex'
                ]),
                'img' => [
                    'images/products/D1.png',
                    'images/products/D2.png',
                    'images/products/D3.png',
                    'images/products/D4.png'
                ]
            ],
            [
                'nom' => 'M',
                'stock' => 80,
                'oferta' => 10,
                'propietats' => json_encode([
                    'talla' => 'M',
                    'material' => '100% cotó',
                    'rentat' => '30°C',
                    'tipus' => 'Unisex'
                ]),
                'img' => [
                    'images/products/D1.png',
                    'images/products/D2.png',
                    'images/products/D3.png',
                    'images/products/D4.png'
                ]
            ],
            [
                'nom' => 'L',
                'stock' => 70,
                'oferta' => 10,
                'propietats' => json_encode([
                    'talla' => 'L',
                    'material' => '100% cotó',
                    'rentat' => '30°C',
                    'tipus' => 'Unisex'
                ]),
                'img' => [
                    'images/products/D1.png',
                    'images/products/D2.png',
                    'images/products/D3.png',
                    'images/products/D4.png'
                ]
            ],
            [
                'nom' => 'XL',
                'stock' => 35,
                'oferta' => 10,
                'propietats' => json_encode([
                    'talla' => 'XL',
                    'material' => '100% cotó',
                    'rentat' => '30°C',
                    'tipus' => 'Unisex'
                ]),
                'img' => [
                    'images/products/D1.png',
                    'images/products/D2.png',
                    'images/products/D3.png',
                    'images/products/D4.png'
                ]
            ]
        ]);

        // Felino
        $felino = Producte::create([
            'nom' => 'Felino',
            'descr' => 'Samarreta de màniga curta en punt de cotó suau, coll rodó rivetat i baix recte.',
            'preu' => 15.85,
            'enviament' => 3.00,
            'dies' => 2,
            'devolucio' => true,
            'devolucioGratis' => false,
            'categoria_id' => 3,
            'destacat' => false,
            'vendedor_id' => 4
        ]);

        $felino->caracteristiques()->createMany([
            [
                'nom' => 'S',
                'stock' => 40,
                'oferta' => 15,
                'propietats' => json_encode([
                    'talla' => 'S',
                    'material' => '100% cotó',
                    'rentat' => '30°C',
                    'tipus' => 'Unisex'
                ]),
                'img' => [
                    'images/products/F1.png',
                    'images/products/F2.png',
                    'images/products/F3.png',
                    'images/products/F4.png'
                ]
            ],
            [
                'nom' => 'M',
                'stock' => 65,
                'oferta' => 15,
                'propietats' => json_encode([
                    'talla' => 'M',
                    'material' => '100% cotó',
                    'rentat' => '30°C',
                    'tipus' => 'Unisex'
                ]),
                'img' => [
                    'images/products/F1.png',
                    'images/products/F2.png',
                    'images/products/F3.png',
                    'images/products/F4.png'
                ]
            ],
            [
                'nom' => 'L',
                'stock' => 60,
                'oferta' => 15,
                'propietats' => json_encode([
                    'talla' => 'L',
                    'material' => '100% cotó',
                    'rentat' => '30°C',
                    'tipus' => 'Unisex'
                ]),
                'img' => [
                    'images/products/F1.png',
                    'images/products/F2.png',
                    'images/products/F3.png',
                    'images/products/F4.png'
                ]
            ],
            [
                'nom' => 'XL',
                'stock' => 30,
                'oferta' => 15,
                'propietats' => json_encode([
                    'talla' => 'XL',
                    'material' => '100% cotó',
                    'rentat' => '30°C',
                    'tipus' => 'Unisex'
                ]),
                'img' => [
                    'images/products/F1.png',
                    'images/products/F2.png',
                    'images/products/F3.png',
                    'images/products/F4.png'
                ]
            ]
        ]);

        // Advocado
        $advocado = Producte::create([
            'nom' => 'Advocado',
            'descr' => 'Samarreta de màniga curta en punt de cotó suau, coll rodó rivetat i baix recte.',
            'preu' => 15.85,
            'enviament' => 3.00,
            'dies' => 2,
            'devolucio' => true,
            'devolucioGratis' => false,
            'categoria_id' => 3,
            'destacat' => false,
            'vendedor_id' => 5
        ]);

        $advocado->caracteristiques()->createMany([
            [
                'nom' => 'S',
                'stock' => 40,
                'oferta' => 0,
                'propietats' => json_encode([
                    'talla' => 'S',
                    'material' => '100% cotó',
                    'rentat' => '30°C',
                    'tipus' => 'Unisex'
                ]),
                'img' => [
                    'images/products/A1.png',
                    'images/products/A2.png',
                    'images/products/A3.png',
                    'images/products/A4.png'
                ]
            ],
            [
                'nom' => 'M',
                'stock' => 70,
                'oferta' => 0,
                'propietats' => json_encode([
                    'talla' => 'M',
                    'material' => '100% cotó',
                    'rentat' => '30°C',
                    'tipus' => 'Unisex'
                ]),
                'img' => [
                    'images/products/A1.png',
                    'images/products/A2.png',
                    'images/products/A3.png',
                    'images/products/A4.png'
                ]
            ],
            [
                'nom' => 'L',
                'stock' => 65,
                'oferta' => 0,
                'propietats' => json_encode([
                    'talla' => 'L',
                    'material' => '100% cotó',
                    'rentat' => '30°C',
                    'tipus' => 'Unisex'
                ]),
                'img' => [
                    'images/products/A1.png',
                    'images/products/A2.png',
                    'images/products/A3.png',
                    'images/products/A4.png'
                ]
            ],
            [
                'nom' => 'XL',
                'stock' => 35,
                'oferta' => 0,
                'propietats' => json_encode([
                    'talla' => 'XL',
                    'material' => '100% cotó',
                    'rentat' => '30°C',
                    'tipus' => 'Unisex'
                ]),
                'img' => [
                    'images/products/A1.png',
                    'images/products/A2.png',
                    'images/products/A3.png',
                    'images/products/A4.png'
                ]
            ]
        ]);

        // TOMATO
        $tomato = Producte::create([
            'nom' => 'TOMATO',
            'descr' => 'Samarreta de màniga curta en punt de cotó suau, coll rodó rivetat i baix recte.',
            'preu' => 17.99,
            'enviament' => 3.00,
            'dies' => 2,
            'devolucio' => true,
            'devolucioGratis' => false,
            'categoria_id' => 3,
            'destacat' => true,
            'vendedor_id' => 1
        ]);

        $tomato->caracteristiques()->createMany([
            [
                'nom' => 'S',
                'stock' => 45,
                'oferta' => 20,
                'propietats' => json_encode([
                    'talla' => 'S',
                    'material' => '100% cotó',
                    'rentat' => '30°C',
                    'tipus' => 'Unisex'
                ]),
                'img' => [
                    'images/products/tomate1.png',
                    'images/products/tomate2.png',
                    'images/products/tomate3.png',
                    'images/products/tomate4.png'
                ]
            ],
            [
                'nom' => 'M',
                'stock' => 75,
                'oferta' => 20,
                'propietats' => json_encode([
                    'talla' => 'M',
                    'material' => '100% cotó',
                    'rentat' => '30°C',
                    'tipus' => 'Unisex'
                ]),
                'img' => [
                    'images/products/tomate1.png',
                    'images/products/tomate2.png',
                    'images/products/tomate3.png',
                    'images/products/tomate4.png'
                ]
            ],
            [
                'nom' => 'L',
                'stock' => 70,
                'oferta' => 20,
                'propietats' => json_encode([
                    'talla' => 'L',
                    'material' => '100% cotó',
                    'rentat' => '30°C',
                    'tipus' => 'Unisex'
                ]),
                'img' => [
                    'images/products/tomate1.png',
                    'images/products/tomate2.png',
                    'images/products/tomate3.png',
                    'images/products/tomate4.png'
                ]
            ],
            [
                'nom' => 'XL',
                'stock' => 35,
                'oferta' => 20,
                'propietats' => json_encode([
                    'talla' => 'XL',
                    'material' => '100% cotó',
                    'rentat' => '30°C',
                    'tipus' => 'Unisex'
                ]),
                'img' => [
                    'images/products/tomate1.png',
                    'images/products/tomate2.png',
                    'images/products/tomate3.png',
                    'images/products/tomate4.png'
                ]
            ]
        ]);
    }
}
