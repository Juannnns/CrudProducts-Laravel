<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $products = [
            ['nombre' => 'Laptop HP Pavilion 15', 'precio' => 750.00],
            ['nombre' => 'iPhone 14 Pro Max', 'precio' => 1200.00],
            ['nombre' => 'Samsung Galaxy S23 Ultra', 'precio' => 1100.00],
            ['nombre' => 'Sony PlayStation 5', 'precio' => 499.99],
            ['nombre' => 'Nintendo Switch OLED', 'precio' => 349.99],
            ['nombre' => 'Apple MacBook Air M2', 'precio' => 1099.00],
            ['nombre' => 'Dell XPS 13 Plus', 'precio' => 1399.00],
            ['nombre' => 'iPad Air 5ta Gen', 'precio' => 599.00],
            ['nombre' => 'Monitor Samsung Odyssey G9', 'precio' => 1299.99],
            ['nombre' => 'Teclado Mecánico Keychron K2', 'precio' => 89.00],
            ['nombre' => 'Mouse Logitech MX Master 3S', 'precio' => 99.00],
            ['nombre' => 'Auriculares Sony WH-1000XM5', 'precio' => 348.00],
            ['nombre' => 'Bocina JBL Flip 6', 'precio' => 129.95],
            ['nombre' => 'Cámara Canon EOS R6', 'precio' => 2499.00],
            ['nombre' => 'Lente Sigma 24-70mm f/2.8', 'precio' => 1099.00],
            ['nombre' => 'Smartwatch Apple Watch Series 9', 'precio' => 399.00],
            ['nombre' => 'Samsung Galaxy Watch 6', 'precio' => 299.00],
            ['nombre' => 'Disco SSD Samsung 980 Pro 1TB', 'precio' => 89.99],
            ['nombre' => 'Tarjeta Gráfica NVIDIA RTX 4090', 'precio' => 1599.00],
            ['nombre' => 'Procesador AMD Ryzen 9 7950X', 'precio' => 699.00],
            ['nombre' => 'Gabinete Corsair 4000D Airflow', 'precio' => 104.99],
            ['nombre' => 'Fuente de Poder Corsair RM850x', 'precio' => 139.99],
            ['nombre' => 'Silla Gamer Secretlab Titan Evo', 'precio' => 549.00],
            ['nombre' => 'Micrófono Shure SM7B', 'precio' => 399.00],
            ['nombre' => 'Interfaz de Audio Focusrite Scarlett', 'precio' => 169.00],
            ['nombre' => 'Webcam Logitech Brio 4K', 'precio' => 199.00],
            ['nombre' => 'Router ASUS RT-AX86U', 'precio' => 249.00],
            ['nombre' => 'Tablet Samsung Galaxy Tab S9', 'precio' => 799.00],
            ['nombre' => 'E-reader Kindle Paperwhite', 'precio' => 139.99],
            ['nombre' => 'Google Pixel 8 Pro', 'precio' => 999.00],
            ['nombre' => 'Auriculares Bose QuietComfort Ultra', 'precio' => 429.00],
            ['nombre' => 'Barra de Sonido Sonos Beam Gen 2', 'precio' => 449.00],
            ['nombre' => 'Proyector Epson Home Cinema', 'precio' => 899.00],
            ['nombre' => 'Dron DJI Mini 4 Pro', 'precio' => 759.00],
            ['nombre' => 'Cámara de Acción GoPro Hero 12', 'precio' => 399.00],
            ['nombre' => 'Impresora 3D Creality Ender 3', 'precio' => 199.00],
            ['nombre' => 'Consola Xbox Series X', 'precio' => 499.99],
            ['nombre' => 'Control Xbox Elite Series 2', 'precio' => 179.99],
            ['nombre' => 'Monitor LG UltraGear 27"', 'precio' => 299.00],
            ['nombre' => 'Disco Duro Externo WD 5TB', 'precio' => 119.00],
            ['nombre' => 'Memoria RAM Corsair Vengeance 32GB', 'precio' => 99.00],
            ['nombre' => 'Refrigeración Líquida NZXT Kraken', 'precio' => 159.00],
            ['nombre' => 'Placa Madre ASUS ROG Strix B650', 'precio' => 219.00],
            ['nombre' => 'Gafas VR Meta Quest 3', 'precio' => 499.99],
            ['nombre' => 'Hub USB-C Anker 7-in-1', 'precio' => 35.00],
            ['nombre' => 'Cargador Portátil Anker 737', 'precio' => 149.00],
            ['nombre' => 'Smart TV LG OLED C3 55"', 'precio' => 1499.00],
            ['nombre' => 'Barra de Sonido Samsung Q990C', 'precio' => 1399.00],
            ['nombre' => 'Altavoz Inteligente Amazon Echo', 'precio' => 99.99],
            ['nombre' => 'Bombilla Inteligente Philips Hue', 'precio' => 45.00],
        ];

        foreach ($products as $product) {
            DB::table('products')->insert([
                'nombre' => $product['nombre'],
                'precio' => $product['precio'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }


    }
}
