<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Vaciado seguro de todas las tablas antes de sembrar para permitir ejecuciones repetidas
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('order_line')->truncate();
        DB::table('payment')->truncate();
        DB::table('orders')->truncate();
        DB::table('product_category')->truncate();
        DB::table('product')->truncate();
        DB::table('product_img')->truncate();
        DB::table('subcategory')->truncate();
        DB::table('category')->truncate();
        DB::table('promotion')->truncate();
        DB::table('address')->truncate();
        DB::table('user')->truncate();
        DB::table('admin')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // ADMIN
        DB::table('admin')->insert([
            'name' => 'Admin Principal',
            'email' => 'admin@botica.com',
            'pw' => Hash::make('password'),
            'phone' => '600111111',
            'rol' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // USERS
        DB::table('user')->insert([
            ['name' => 'Juan Perez', 'email' => 'juan@mail.com', 'pw' => 'hashed_pw_1', 'phone' => '600222222', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Maria Lopez', 'email' => 'maria@mail.com', 'pw' => 'hashed_pw_2', 'phone' => '600333333', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Carlos Ruiz', 'email' => 'carlos@mail.com', 'pw' => 'hashed_pw_3', 'phone' => '600444444', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // ADDRESS
        DB::table('address')->insert([
            ['user_id' => 1, 'address' => 'Calle Mayor 12', 'city' => 'Merida', 'country' => 'Spain', 'phone' => '600222222', 'name_destination' => 'Casa Juan', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 2, 'address' => 'Av. Extremadura 5', 'city' => 'Merida', 'country' => 'Spain', 'phone' => '600333333', 'name_destination' => 'Casa Maria', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 3, 'address' => 'Calle Roma 8', 'city' => 'Merida', 'country' => 'Spain', 'phone' => '600444444', 'name_destination' => 'Casa Carlos', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // PROMOTION
        DB::table('promotion')->insert([
            ['name' => 'Bienvenida 10%', 'code' => 'WELCOME10', 'discount' => 10.00, 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Verano 20%', 'code' => 'SUMMER20', 'discount' => 20.00, 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // CATEGORY
        DB::table('category')->insert([
            ['name' => 'Medicamentos', 'description' => 'Productos farmacéuticos', 'img' => 'medicamentos.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Cosmética', 'description' => 'Cuidado personal', 'img' => 'cosmetica.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Herbolario', 'description' => 'Productos naturales', 'img' => 'herbolario.jpg', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // SUBCATEGORY
        DB::table('subcategory')->insert([
            ['id' => 1, 'parent_id' => 1],
            ['id' => 2, 'parent_id' => 2],
            ['id' => 3, 'parent_id' => 3],
        ]);

        // PRODUCT_IMG
        DB::table('product_img')->insert([
            ['id' => 1, 'name' => 'paracetamol_500mg.jpg'],
            ['id' => 2, 'name' => 'ibuprofeno_600mg.jpg'],
            ['id' => 3, 'name' => 'jarabe_hiedra.jpg'],
            ['id' => 4, 'name' => 'arnica_crema.jpg'],
            ['id' => 5, 'name' => 'pastillas_miel_limon.jpg'],
            ['id' => 6, 'name' => 'alcohol_romero.jpg'],
            ['id' => 7, 'name' => 'agua_mar_spray.jpg'],
            ['id' => 8, 'name' => 'carbon_activado.jpg'],
            ['id' => 9, 'name' => 'balsamo_tigre.jpg'],
            ['id' => 10, 'name' => 'crema_aloe_vera.jpg'],
            ['id' => 11, 'name' => 'aceite_rosa_mosqueta.jpg'],
            ['id' => 12, 'name' => 'champu_biotina.jpg'],
            ['id' => 13, 'name' => 'contorno_ojos_hialuronico.jpg'],
            ['id' => 14, 'name' => 'mascarilla_arcilla.jpg'],
            ['id' => 15, 'name' => 'protector_solar.jpg'],
            ['id' => 16, 'name' => 'aceite_arbol_te.jpg'],
            ['id' => 17, 'name' => 'balsamo_labial.jpg'],
            ['id' => 18, 'name' => 'crema_manos_calendula.jpg'],
            ['id' => 19, 'name' => 'exfoliante_cafe_coco.jpg'],
            ['id' => 20, 'name' => 'vitamina_c_1000mg.jpg'],
            ['id' => 21, 'name' => 'jabon_aloe_vera.jpg'],
            ['id' => 22, 'name' => 'valeriana_tila.jpg'],
            ['id' => 23, 'name' => 'curcuma_pimienta.jpg'],
            ['id' => 24, 'name' => 'jalea_real.jpg'],
            ['id' => 25, 'name' => 'colageno_magnesio.jpg'],
            ['id' => 26, 'name' => 'extracto_propolis.jpg'],
            ['id' => 27, 'name' => 'espirulina_ecologica.jpg'],
            ['id' => 28, 'name' => 'manzanilla_anis.jpg'],
            ['id' => 29, 'name' => 'melatonina_pasiflora.jpg'],
            ['id' => 30, 'name' => 'ginkgo_biloba.jpg'],
            ['id' => 31, 'name' => 'levadura_cerveza.jpg'],
        ]);

        // PRODUCT & PRODUCT_CATEGORY
        $products = [
            // MEDICAMENTOS (Category 1)
            ['id' => 1, 'promotion_id' => NULL, 'img_id' => 1, 'name' => 'Paracetamol 500mg', 'description' => 'Eficaz para el alivio del dolor ocasional leve o moderado y la fiebre.', 'status' => 1, 'price' => 2.50, 'stock' => 100, 'category_id' => 1],
            ['id' => 2, 'promotion_id' => NULL, 'img_id' => 2, 'name' => 'Ibuprofeno 600mg', 'description' => 'Indicado para el alivio del dolor moderado y procesos inflamatorios.', 'status' => 1, 'price' => 3.20, 'stock' => 80, 'category_id' => 1],
            ['id' => 3, 'promotion_id' => NULL, 'img_id' => 3, 'name' => 'Jarabe de Hiedra Natural', 'description' => 'Jarabe natural a base de extracto de hiedra para aliviar la tos y mucosidad.', 'status' => 1, 'price' => 6.50, 'stock' => 50, 'category_id' => 1],
            ['id' => 4, 'promotion_id' => NULL, 'img_id' => 4, 'name' => 'Árnica Crema Alivio', 'description' => 'Crema antiinflamatoria natural ideal para masajes musculares tras golpes o fatiga.', 'status' => 1, 'price' => 8.90, 'stock' => 75, 'category_id' => 1],
            ['id' => 5, 'promotion_id' => NULL, 'img_id' => 5, 'name' => 'Pastillas de Miel y Limón', 'description' => 'Pastillas balsámicas para suavizar la irritación de garganta y afonía.', 'status' => 1, 'price' => 4.20, 'stock' => 150, 'category_id' => 1],
            ['id' => 6, 'promotion_id' => NULL, 'img_id' => 6, 'name' => 'Alcohol de Romero 250ml', 'description' => 'Alcohol de romero tradicional para friegas, alivio muscular y piernas cansadas.', 'status' => 1, 'price' => 3.50, 'stock' => 90, 'category_id' => 1],
            ['id' => 7, 'promotion_id' => NULL, 'img_id' => 7, 'name' => 'Agua de Mar Spray Nasal', 'description' => 'Solución salina natural para la higiene nasal diaria y descongestión.', 'status' => 1, 'price' => 5.80, 'stock' => 110, 'category_id' => 1],
            ['id' => 8, 'promotion_id' => NULL, 'img_id' => 8, 'name' => 'Carbón Activo Digestivo', 'description' => 'Cápsulas de carbón vegetal activo para combatir los gases y pesadez estomacal.', 'status' => 1, 'price' => 7.20, 'stock' => 65, 'category_id' => 1],
            ['id' => 9, 'promotion_id' => NULL, 'img_id' => 9, 'name' => 'Bálsamo de Tigre Herbario', 'description' => 'Bálsamo aromático tradicional de efecto calor para aliviar dolores musculares.', 'status' => 1, 'price' => 9.95, 'stock' => 40, 'category_id' => 1],

            // COSMÉTICA (Category 2)
            ['id' => 10, 'promotion_id' => NULL, 'img_id' => 10, 'name' => 'Crema Hidratante Aloe Vera', 'description' => 'Crema facial hidratante regeneradora con extracto de aloe vera puro.', 'status' => 1, 'price' => 5.99, 'stock' => 50, 'category_id' => 2],
            ['id' => 11, 'promotion_id' => NULL, 'img_id' => 11, 'name' => 'Aceite de Rosa Mosqueta', 'description' => 'Aceite 100% puro para regenerar cicatrices, arrugas y nutrir la piel.', 'status' => 1, 'price' => 12.90, 'stock' => 40, 'category_id' => 2],
            ['id' => 12, 'promotion_id' => NULL, 'img_id' => 12, 'name' => 'Champú de Biotina y Ortiga', 'description' => 'Champú fortalecedor anticaída con biotina e ingredientes naturales.', 'status' => 1, 'price' => 8.50, 'stock' => 60, 'category_id' => 2],
            ['id' => 13, 'promotion_id' => NULL, 'img_id' => 13, 'name' => 'Contorno Ojos Hialurónico', 'description' => 'Sérum refrescante para reducir bolsas, ojeras y rellenar líneas de expresión.', 'status' => 1, 'price' => 14.99, 'stock' => 35, 'category_id' => 2],
            ['id' => 14, 'promotion_id' => NULL, 'img_id' => 14, 'name' => 'Mascarilla Arcilla Verde', 'description' => 'Mascarilla purificante para pieles mixtas o grasas, limpia y reduce poros.', 'status' => 1, 'price' => 7.50, 'stock' => 85, 'category_id' => 2],
            ['id' => 15, 'promotion_id' => NULL, 'img_id' => 15, 'name' => 'Protector Solar FPS 50+', 'description' => 'Crema solar facial con filtros minerales y alta protección contra rayos UV.', 'status' => 1, 'price' => 16.50, 'stock' => 55, 'category_id' => 2],
            ['id' => 16, 'promotion_id' => NULL, 'img_id' => 16, 'name' => 'Aceite de Árbol de Té', 'description' => 'Aceite esencial con propiedades antisépticas para imperfecciones y acné.', 'status' => 1, 'price' => 6.80, 'stock' => 100, 'category_id' => 2],
            ['id' => 17, 'promotion_id' => NULL, 'img_id' => 17, 'name' => 'Bálsamo Labial de Karité', 'description' => 'Protector labial ultra nutritivo con manteca de karité y cera de abejas.', 'status' => 1, 'price' => 2.95, 'stock' => 200, 'category_id' => 2],
            ['id' => 18, 'promotion_id' => NULL, 'img_id' => 18, 'name' => 'Crema Manos Caléndula', 'description' => 'Crema reparadora e hidratante intensiva para manos secas y agrietadas.', 'status' => 1, 'price' => 4.90, 'stock' => 120, 'category_id' => 2],
            ['id' => 19, 'promotion_id' => NULL, 'img_id' => 19, 'name' => 'Exfoliante Café y Coco', 'description' => 'Exfoliante corporal natural para eliminar células muertas y suavizar la piel.', 'status' => 1, 'price' => 9.90, 'stock' => 45, 'category_id' => 2],

            // HERBOLARIO (Category 3)
            ['id' => 20, 'promotion_id' => 1, 'img_id' => 20, 'name' => 'Vitamina C 1000mg', 'description' => 'Suplemento de vitamina C para reforzar el sistema inmunológico y defensas.', 'status' => 1, 'price' => 4.50, 'stock' => 120, 'category_id' => 3],
            ['id' => 21, 'promotion_id' => 2, 'img_id' => 21, 'name' => 'Jabón Natural Aloe Vera', 'description' => 'Jabón artesanal hidratante y calmante para pieles sensibles.', 'status' => 1, 'price' => 3.75, 'stock' => 60, 'category_id' => 3],
            ['id' => 22, 'promotion_id' => NULL, 'img_id' => 22, 'name' => 'Valeriana y Tila Infusión', 'description' => 'Mezcla de plantas naturales para ayudar a conciliar el sueño y relajarse.', 'status' => 1, 'price' => 3.80, 'stock' => 130, 'category_id' => 3],
            ['id' => 23, 'promotion_id' => NULL, 'img_id' => 23, 'name' => 'Cúrcuma y Pimienta Negra', 'description' => 'Cápsulas con propiedades antiinflamatorias y antioxidantes naturales.', 'status' => 1, 'price' => 11.50, 'stock' => 70, 'category_id' => 3],
            ['id' => 24, 'promotion_id' => NULL, 'img_id' => 24, 'name' => 'Jalea Real Fresca 100g', 'description' => 'Suplemento natural energético para combatir el cansancio y fatiga física.', 'status' => 1, 'price' => 15.90, 'stock' => 30, 'category_id' => 3],
            ['id' => 25, 'promotion_id' => NULL, 'img_id' => 25, 'name' => 'Colágeno con Magnesio', 'description' => 'Suplemento para el cuidado de articulaciones, huesos, tendones y piel.', 'status' => 1, 'price' => 19.99, 'stock' => 45, 'category_id' => 3],
            ['id' => 26, 'promotion_id' => NULL, 'img_id' => 26, 'name' => 'Extracto Própolis Gotas', 'description' => 'Extracto de própolis natural para proteger el sistema respiratorio y garganta.', 'status' => 1, 'price' => 7.80, 'stock' => 80, 'category_id' => 3],
            ['id' => 27, 'promotion_id' => NULL, 'img_id' => 27, 'name' => 'Espirulina Ecológica', 'description' => 'Superalimento en comprimidos rico en proteínas, vitaminas y minerales.', 'status' => 1, 'price' => 10.50, 'stock' => 95, 'category_id' => 3],
            ['id' => 28, 'promotion_id' => NULL, 'img_id' => 28, 'name' => 'Manzanilla y Anís Infusión', 'description' => 'Infusión tradicional digestiva de manzanilla dulce y anís verde.', 'status' => 1, 'price' => 3.40, 'stock' => 140, 'category_id' => 3],
            ['id' => 29, 'promotion_id' => NULL, 'img_id' => 29, 'name' => 'Melatonina Pasiflora', 'description' => 'Cápsulas para regular los ciclos de sueño y favorecer un descanso profundo.', 'status' => 1, 'price' => 8.90, 'stock' => 105, 'category_id' => 3],
            ['id' => 30, 'promotion_id' => NULL, 'img_id' => 30, 'name' => 'Ginkgo Biloba Concentrado', 'description' => 'Suplemento para mejorar la memoria, concentración y circulación sanguínea.', 'status' => 1, 'price' => 12.00, 'stock' => 60, 'category_id' => 3],
            ['id' => 31, 'promotion_id' => NULL, 'img_id' => 31, 'name' => 'Levadura de Cerveza Copos', 'description' => 'Excelente aporte de vitaminas del grupo B para el cabello, piel y uñas.', 'status' => 1, 'price' => 4.50, 'stock' => 80, 'category_id' => 3],
        ];

        $productInserts = [];
        $categoryInserts = [];

        foreach ($products as $p) {
            $productInserts[] = [
                'id' => $p['id'],
                'promotion_id' => $p['promotion_id'],
                'img_id' => $p['img_id'],
                'name' => $p['name'],
                'description' => $p['description'],
                'status' => $p['status'],
                'price' => $p['price'],
                'stock' => $p['stock'],
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $categoryInserts[] = [
                'product_id' => $p['id'],
                'category_id' => $p['category_id'],
            ];
        }

        DB::table('product')->insert($productInserts);
        DB::table('product_category')->insert($categoryInserts);

        // ORDERS
        DB::table('orders')->insert([
            ['id' => 1, 'user_id' => 1, 'total_price' => 24.80, 'status' => 1, 'order_date' => '2026-01-15 10:30:00', 'created_at' => '2026-01-15 10:30:00', 'updated_at' => '2026-01-15 10:30:00'],
            ['id' => 2, 'user_id' => 2, 'total_price' => 18.40, 'status' => 1, 'order_date' => '2026-01-28 14:15:00', 'created_at' => '2026-01-28 14:15:00', 'updated_at' => '2026-01-28 14:15:00'],
            ['id' => 3, 'user_id' => 3, 'total_price' => 44.18, 'status' => 1, 'order_date' => '2026-02-10 18:45:00', 'created_at' => '2026-02-10 18:45:00', 'updated_at' => '2026-02-10 18:45:00'],
            ['id' => 4, 'user_id' => 1, 'total_price' => 12.00, 'status' => 1, 'order_date' => '2026-02-22 09:00:00', 'created_at' => '2026-02-22 09:00:00', 'updated_at' => '2026-02-22 09:00:00'],
            ['id' => 5, 'user_id' => 2, 'total_price' => 32.93, 'status' => 1, 'order_date' => '2026-03-05 11:20:00', 'created_at' => '2026-03-05 11:20:00', 'updated_at' => '2026-03-05 11:20:00'],
            ['id' => 6, 'user_id' => 3, 'total_price' => 8.50, 'status' => 1, 'order_date' => '2026-03-18 16:30:00', 'created_at' => '2026-03-18 16:30:00', 'updated_at' => '2026-03-18 16:30:00'],
            ['id' => 7, 'user_id' => 1, 'total_price' => 5.99, 'status' => 1, 'order_date' => '2026-03-29 13:10:00', 'created_at' => '2026-03-29 13:10:00', 'updated_at' => '2026-03-29 13:10:00'],
            ['id' => 8, 'user_id' => 1, 'total_price' => 14.99, 'status' => 1, 'order_date' => '2026-04-12 15:40:00', 'created_at' => '2026-04-12 15:40:00', 'updated_at' => '2026-04-12 15:40:00'],
            ['id' => 9, 'user_id' => 2, 'total_price' => 7.40, 'status' => 1, 'order_date' => '2026-04-20 17:00:00', 'created_at' => '2026-04-20 17:00:00', 'updated_at' => '2026-04-20 17:00:00'],
            ['id' => 10, 'user_id' => 3, 'total_price' => 16.50, 'status' => 0, 'order_date' => '2026-04-25 10:15:00', 'created_at' => '2026-04-25 10:15:00', 'updated_at' => '2026-04-25 10:15:00'],
            ['id' => 11, 'user_id' => 3, 'total_price' => 26.49, 'status' => 1, 'order_date' => '2026-05-02 12:00:00', 'created_at' => '2026-05-02 12:00:00', 'updated_at' => '2026-05-02 12:00:00'],
            ['id' => 12, 'user_id' => 2, 'total_price' => 9.90, 'status' => 1, 'order_date' => '2026-05-08 14:50:00', 'created_at' => '2026-05-08 14:50:00', 'updated_at' => '2026-05-08 14:50:00'],
            ['id' => 13, 'user_id' => 1, 'total_price' => 15.70, 'status' => 1, 'order_date' => '2026-05-15 11:30:00', 'created_at' => '2026-05-15 11:30:00', 'updated_at' => '2026-05-15 11:30:00'],
            ['id' => 14, 'user_id' => 2, 'total_price' => 9.00, 'status' => 0, 'order_date' => '2026-05-20 19:10:00', 'created_at' => '2026-05-20 19:10:00', 'updated_at' => '2026-05-20 19:10:00'],
        ]);

        // ORDER_LINE
        DB::table('order_line')->insert([
            ['order_id' => 1, 'num_line' => 1, 'product_id' => 1, 'unit' => 2, 'price' => 2.50, 'total_price' => 5.00],
            ['order_id' => 1, 'num_line' => 2, 'product_id' => 30, 'unit' => 1, 'price' => 12.00, 'total_price' => 12.00],
            ['order_id' => 1, 'num_line' => 3, 'product_id' => 26, 'unit' => 1, 'price' => 7.80, 'total_price' => 7.80],

            ['order_id' => 2, 'num_line' => 1, 'product_id' => 12, 'unit' => 1, 'price' => 8.50, 'total_price' => 8.50],
            ['order_id' => 2, 'num_line' => 2, 'product_id' => 19, 'unit' => 1, 'price' => 9.90, 'total_price' => 9.90],

            ['order_id' => 3, 'num_line' => 1, 'product_id' => 25, 'unit' => 2, 'price' => 19.99, 'total_price' => 39.98],
            ['order_id' => 3, 'num_line' => 2, 'product_id' => 5, 'unit' => 1, 'price' => 4.20, 'total_price' => 4.20],

            ['order_id' => 4, 'num_line' => 1, 'product_id' => 30, 'unit' => 1, 'price' => 12.00, 'total_price' => 12.00],

            ['order_id' => 5, 'num_line' => 1, 'product_id' => 13, 'unit' => 2, 'price' => 14.99, 'total_price' => 29.98],
            ['order_id' => 5, 'num_line' => 2, 'product_id' => 17, 'unit' => 1, 'price' => 2.95, 'total_price' => 2.95],

            ['order_id' => 6, 'num_line' => 1, 'product_id' => 12, 'unit' => 1, 'price' => 8.50, 'total_price' => 8.50],

            ['order_id' => 7, 'num_line' => 1, 'product_id' => 10, 'unit' => 1, 'price' => 5.99, 'total_price' => 5.99],

            ['order_id' => 8, 'num_line' => 1, 'product_id' => 13, 'unit' => 1, 'price' => 14.99, 'total_price' => 14.99],

            ['order_id' => 9, 'num_line' => 1, 'product_id' => 2, 'unit' => 1, 'price' => 3.20, 'total_price' => 3.20],
            ['order_id' => 9, 'num_line' => 2, 'product_id' => 5, 'unit' => 1, 'price' => 4.20, 'total_price' => 4.20],

            ['order_id' => 10, 'num_line' => 1, 'product_id' => 15, 'unit' => 1, 'price' => 16.50, 'total_price' => 16.50],

            ['order_id' => 11, 'num_line' => 1, 'product_id' => 25, 'unit' => 1, 'price' => 19.99, 'total_price' => 19.99],
            ['order_id' => 11, 'num_line' => 2, 'product_id' => 3, 'unit' => 1, 'price' => 6.50, 'total_price' => 6.50],

            ['order_id' => 12, 'num_line' => 1, 'product_id' => 19, 'unit' => 1, 'price' => 9.90, 'total_price' => 9.90],

            ['order_id' => 13, 'num_line' => 1, 'product_id' => 1, 'unit' => 2, 'price' => 2.50, 'total_price' => 5.00],
            ['order_id' => 13, 'num_line' => 2, 'product_id' => 2, 'unit' => 3, 'price' => 3.20, 'total_price' => 9.60],
            ['order_id' => 13, 'num_line' => 3, 'product_id' => 10, 'unit' => 1, 'price' => 1.10, 'total_price' => 1.10],

            ['order_id' => 14, 'num_line' => 1, 'product_id' => 20, 'unit' => 2, 'price' => 4.50, 'total_price' => 9.00],
        ]);

        // PAYMENT
        DB::table('payment')->insert([
            ['order_id' => 1, 'payment_details' => 'Tarjeta Visa', 'payment_status' => 1, 'reference' => 'REF001', 'amount' => 24.80, 'created_at' => now(), 'updated_at' => now()],
            ['order_id' => 2, 'payment_details' => 'PayPal', 'payment_status' => 1, 'reference' => 'REF002', 'amount' => 18.40, 'created_at' => now(), 'updated_at' => now()],
            ['order_id' => 3, 'payment_details' => 'Tarjeta Mastercard', 'payment_status' => 1, 'reference' => 'REF003', 'amount' => 44.18, 'created_at' => now(), 'updated_at' => now()],
            ['order_id' => 4, 'payment_details' => 'Bizum', 'payment_status' => 1, 'reference' => 'REF004', 'amount' => 12.00, 'created_at' => now(), 'updated_at' => now()],
            ['order_id' => 5, 'payment_details' => 'Tarjeta Visa', 'payment_status' => 1, 'reference' => 'REF005', 'amount' => 32.93, 'created_at' => now(), 'updated_at' => now()],
            ['order_id' => 6, 'payment_details' => 'PayPal', 'payment_status' => 1, 'reference' => 'REF006', 'amount' => 8.50, 'created_at' => now(), 'updated_at' => now()],
            ['order_id' => 7, 'payment_details' => 'Tarjeta Visa', 'payment_status' => 1, 'reference' => 'REF007', 'amount' => 5.99, 'created_at' => now(), 'updated_at' => now()],
            ['order_id' => 8, 'payment_details' => 'Bizum', 'payment_status' => 1, 'reference' => 'REF008', 'amount' => 14.99, 'created_at' => now(), 'updated_at' => now()],
            ['order_id' => 9, 'payment_details' => 'Tarjeta Visa', 'payment_status' => 1, 'reference' => 'REF009', 'amount' => 7.40, 'created_at' => now(), 'updated_at' => now()],
            ['order_id' => 11, 'payment_details' => 'PayPal', 'payment_status' => 1, 'reference' => 'REF011', 'amount' => 26.49, 'created_at' => now(), 'updated_at' => now()],
            ['order_id' => 12, 'payment_details' => 'Tarjeta Mastercard', 'payment_status' => 1, 'reference' => 'REF012', 'amount' => 9.90, 'created_at' => now(), 'updated_at' => now()],
            ['order_id' => 13, 'payment_details' => 'Bizum', 'payment_status' => 1, 'reference' => 'REF013', 'amount' => 15.70, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
