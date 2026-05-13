<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ADMIN
        DB::table('admin')->insert([
            'name' => 'Admin Principal',
            'email' => 'admin@botica.com',
            'pw' => 'hashed_pw_1',
            'phone' => '600111111',
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
            ['name' => 'Medicamentos', 'description' => 'Productos farmacéuticos', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Cosmética', 'description' => 'Cuidado personal', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Herbolario', 'description' => 'Productos naturales', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // SUBCATEGORY
        DB::table('subcategory')->insert([
            ['id' => 1, 'parent_id' => 1],
            ['id' => 2, 'parent_id' => 2],
            ['id' => 3, 'parent_id' => 3],
        ]);

        // PRODUCT
        DB::table('product')->insert([
            ['promotion_id' => NULL, 'name' => 'Paracetamol 500mg', 'status' => 1, 'price' => 2.50, 'stock' => 100, 'created_at' => now(), 'updated_at' => now()],
            ['promotion_id' => NULL, 'name' => 'Ibuprofeno 600mg', 'status' => 1, 'price' => 3.20, 'stock' => 80, 'created_at' => now(), 'updated_at' => now()],
            ['promotion_id' => NULL, 'name' => 'Crema hidratante aloe', 'status' => 1, 'price' => 5.99, 'stock' => 50, 'created_at' => now(), 'updated_at' => now()],
            ['promotion_id' => 1, 'name' => 'Vitamina C 1000mg', 'status' => 1, 'price' => 4.50, 'stock' => 120, 'created_at' => now(), 'updated_at' => now()],
            ['promotion_id' => 2, 'name' => 'Jabón natural aloe', 'status' => 1, 'price' => 3.75, 'stock' => 60, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // PRODUCT_CATEGORY
        DB::table('product_category')->insert([
            ['product_id' => 1, 'category_id' => 1],
            ['product_id' => 2, 'category_id' => 1],
            ['product_id' => 3, 'category_id' => 2],
            ['product_id' => 4, 'category_id' => 3],
            ['product_id' => 5, 'category_id' => 3],
        ]);

        // ORDERS
        DB::table('orders')->insert([
            ['user_id' => 1, 'total_price' => 15.70, 'status' => 1, 'order_date' => now(), 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 2, 'total_price' => 9.99, 'status' => 1, 'order_date' => now(), 'created_at' => now(), 'updated_at' => now()],
        ]);

        // ORDER_LINE
        DB::table('order_line')->insert([
            ['order_id' => 1, 'num_line' => 1, 'product_id' => 1, 'unit' => 2, 'price' => 2.50, 'total_price' => 5.00],
            ['order_id' => 1, 'num_line' => 2, 'product_id' => 2, 'unit' => 3, 'price' => 3.20, 'total_price' => 9.60],
            ['order_id' => 1, 'num_line' => 3, 'product_id' => 3, 'unit' => 1, 'price' => 1.10, 'total_price' => 1.10],
            ['order_id' => 2, 'num_line' => 1, 'product_id' => 4, 'unit' => 2, 'price' => 4.50, 'total_price' => 9.00],
        ]);

        // PAYMENT
        DB::table('payment')->insert([
            ['order_id' => 1, 'payment_details' => 'Tarjeta Visa', 'payment_status' => 1, 'reference' => 'REF001', 'amount' => 15.70, 'created_at' => now(), 'updated_at' => now()],
            ['order_id' => 2, 'payment_details' => 'PayPal', 'payment_status' => 1, 'reference' => 'REF002', 'amount' => 9.99, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
