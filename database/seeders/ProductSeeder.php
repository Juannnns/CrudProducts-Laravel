<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\User;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();
        $userId = $user ? $user->id : null;

        // Fetch category IDs
        $catElectronics = Category::where('name', 'Electrónica')->first()->id ?? null;
        $catClothing = Category::where('name', 'Ropa')->first()->id ?? null;
        $catHome = Category::where('name', 'Hogar')->first()->id ?? null;
        $catSports = Category::where('name', 'Deportes')->first()->id ?? null;
        $catToys = Category::where('name', 'Juguetes')->first()->id ?? null;
        $catNone = Category::where('name', 'Sin Categoría')->first()->id ?? null;

        $products = [
            // Electrónica
            ['nombre' => 'Laptop HP Pavilion 15', 'precio' => 750.00, 'category_id' => $catElectronics],
            ['nombre' => 'iPhone 14 Pro Max', 'precio' => 1200.00, 'category_id' => $catElectronics],
            ['nombre' => 'Samsung Galaxy S23 Ultra', 'precio' => 1100.00, 'category_id' => $catElectronics],
            ['nombre' => 'Sony PlayStation 5', 'precio' => 499.99, 'category_id' => $catElectronics],
            ['nombre' => 'Nintendo Switch OLED', 'precio' => 349.99, 'category_id' => $catElectronics],
            ['nombre' => 'MacBook Air M2', 'precio' => 1099.00, 'category_id' => $catElectronics],
            ['nombre' => 'Dell XPS 13 Plus', 'precio' => 1399.00, 'category_id' => $catElectronics],
            ['nombre' => 'iPad Air 5ta Gen', 'precio' => 599.00, 'category_id' => $catElectronics],
            ['nombre' => 'Monitor Samsung Odyssey G9', 'precio' => 1299.99, 'category_id' => $catElectronics],
            ['nombre' => 'Teclado Mecánico Keychron K2', 'precio' => 89.00, 'category_id' => $catElectronics],
            ['nombre' => 'Mouse Logitech MX Master 3S', 'precio' => 99.00, 'category_id' => $catElectronics],
            ['nombre' => 'Auriculares Sony WH-1000XM5', 'precio' => 348.00, 'category_id' => $catElectronics],
            ['nombre' => 'Bocina JBL Flip 6', 'precio' => 129.95, 'category_id' => $catElectronics],
            ['nombre' => 'Cámara Canon EOS R6', 'precio' => 2499.00, 'category_id' => $catElectronics],
            ['nombre' => 'Lente Sigma 24-70mm', 'precio' => 1099.00, 'category_id' => $catElectronics],
            ['nombre' => 'Apple Watch Series 9', 'precio' => 399.00, 'category_id' => $catElectronics],
            ['nombre' => 'Samsung Galaxy Watch 6', 'precio' => 299.00, 'category_id' => $catElectronics],
            ['nombre' => 'SSD Samsung 980 Pro 1TB', 'precio' => 89.99, 'category_id' => $catElectronics],
            ['nombre' => 'NVIDIA RTX 4090', 'precio' => 1599.00, 'category_id' => $catElectronics],
            ['nombre' => 'AMD Ryzen 9 7950X', 'precio' => 699.00, 'category_id' => $catElectronics],

            // Ropa
            ['nombre' => 'Camiseta Nike Dri-Fit', 'precio' => 25.00, 'category_id' => $catClothing],
            ['nombre' => 'Jeans Levi\'s 501', 'precio' => 69.99, 'category_id' => $catClothing],
            ['nombre' => 'Sudadera Adidas Originals', 'precio' => 55.00, 'category_id' => $catClothing],
            ['nombre' => 'Zapatillas Jordan Air 1', 'precio' => 180.00, 'category_id' => $catClothing],
            ['nombre' => 'Chaqueta North Face', 'precio' => 220.00, 'category_id' => $catClothing],
            ['nombre' => 'Vestido Zara Floral', 'precio' => 45.90, 'category_id' => $catClothing],
            ['nombre' => 'Botas Timberland Premium', 'precio' => 198.00, 'category_id' => $catClothing],
            ['nombre' => 'Gorra New Era Yankees', 'precio' => 35.00, 'category_id' => $catClothing],
            ['nombre' => 'Calcetines Puma Pack x3', 'precio' => 12.00, 'category_id' => $catClothing],
            ['nombre' => 'Bufanda Burberry Clásica', 'precio' => 450.00, 'category_id' => $catClothing],
            ['nombre' => 'Camisa Ralph Lauren Polo', 'precio' => 89.00, 'category_id' => $catClothing],
            ['nombre' => 'Pantalón Cargo H&M', 'precio' => 29.99, 'category_id' => $catClothing],
            ['nombre' => 'Abrigo Largo Lana', 'precio' => 120.00, 'category_id' => $catClothing],
            ['nombre' => 'Shorts Deportivos Under Armour', 'precio' => 30.00, 'category_id' => $catClothing],
            ['nombre' => 'Bañador Speedo', 'precio' => 40.00, 'category_id' => $catClothing],
            ['nombre' => 'Guantes de Cuero', 'precio' => 45.00, 'category_id' => $catClothing],
            ['nombre' => 'Cinturón Gucci Marmont', 'precio' => 450.00, 'category_id' => $catClothing],
            ['nombre' => 'Zapatos Clarks Oxford', 'precio' => 95.00, 'category_id' => $catClothing],
            ['nombre' => 'Sujetador Deportivo Reebok', 'precio' => 35.00, 'category_id' => $catClothing],
            ['nombre' => 'Pijama de Algodón', 'precio' => 25.00, 'category_id' => $catClothing],

            // Hogar
            ['nombre' => 'Sofá Ikea Kivik', 'precio' => 499.00, 'category_id' => $catHome],
            ['nombre' => 'Lámpara de Pie Industrial', 'precio' => 89.00, 'category_id' => $catHome],
            ['nombre' => 'Juego de Sábanas 1000 Hilos', 'precio' => 120.00, 'category_id' => $catHome],
            ['nombre' => 'Cafetera Nespresso Vertuo', 'precio' => 159.00, 'category_id' => $catHome],
            ['nombre' => 'Robot Aspirador Roomba j7', 'precio' => 599.00, 'category_id' => $catHome],
            ['nombre' => 'Batidora KitchenAid Artisan', 'precio' => 349.00, 'category_id' => $catHome],
            ['nombre' => 'Sartén Antiadherente Tefal', 'precio' => 35.00, 'category_id' => $catHome],
            ['nombre' => 'Toalla de Baño Grande', 'precio' => 15.00, 'category_id' => $catHome],
            ['nombre' => 'Almohada Memory Foam', 'precio' => 45.00, 'category_id' => $catHome],
            ['nombre' => 'Espejo de Pared Redondo', 'precio' => 70.00, 'category_id' => $catHome],
            ['nombre' => 'Mesa de Centro Madera', 'precio' => 150.00, 'category_id' => $catHome],
            ['nombre' => 'Cortinas Blackout (Par)', 'precio' => 40.00, 'category_id' => $catHome],
            ['nombre' => 'Alfombra Persa Sintética', 'precio' => 90.00, 'category_id' => $catHome],
            ['nombre' => 'Cuadro Decorativo Abstracto', 'precio' => 55.00, 'category_id' => $catHome],
            ['nombre' => 'Planta Artificial Ficus', 'precio' => 65.00, 'category_id' => $catHome],
            ['nombre' => 'Velas Aromáticas Pack x3', 'precio' => 20.00, 'category_id' => $catHome],
            ['nombre' => 'Juego de Cubiertos 24pzs', 'precio' => 45.00, 'category_id' => $catHome],
            ['nombre' => 'Copas de Vino Cristal x6', 'precio' => 30.00, 'category_id' => $catHome],
            ['nombre' => 'Organizador de Zapatos', 'precio' => 25.00, 'category_id' => $catHome],
            ['nombre' => 'Purificador de Aire Philips', 'precio' => 180.00, 'category_id' => $catHome],

            // Deportes
            ['nombre' => 'Balón de Fútbol Adidas', 'precio' => 30.00, 'category_id' => $catSports],
            ['nombre' => 'Raqueta de Tenis Wilson', 'precio' => 120.00, 'category_id' => $catSports],
            ['nombre' => 'Bicicleta de Montaña Trek', 'precio' => 650.00, 'category_id' => $catSports],
            ['nombre' => 'Mancuernas Ajustables (Par)', 'precio' => 200.00, 'category_id' => $catSports],
            ['nombre' => 'Esterilla de Yoga Manduka', 'precio' => 80.00, 'category_id' => $catSports],
            ['nombre' => 'Casco de Ciclismo Giro', 'precio' => 60.00, 'category_id' => $catSports],
            ['nombre' => 'Guantes de Boxeo Everlast', 'precio' => 40.00, 'category_id' => $catSports],
            ['nombre' => 'Cuerda de Saltar Velocidad', 'precio' => 15.00, 'category_id' => $catSports],
            ['nombre' => 'Botella de Agua Yeti', 'precio' => 35.00, 'category_id' => $catSports],
            ['nombre' => 'Reloj Garmin Fenix 7', 'precio' => 699.00, 'category_id' => $catSports],
            ['nombre' => 'Patines en Línea Rollerblade', 'precio' => 110.00, 'category_id' => $catSports],
            ['nombre' => 'Tabla de Skate Element', 'precio' => 85.00, 'category_id' => $catSports],
            ['nombre' => 'Pelota de Pilates', 'precio' => 20.00, 'category_id' => $catSports],
            ['nombre' => 'Banda de Resistencia Set', 'precio' => 18.00, 'category_id' => $catSports],
            ['nombre' => 'Mochila de Senderismo Osprey', 'precio' => 140.00, 'category_id' => $catSports],
            ['nombre' => 'Tienda de Campaña 2 Personas', 'precio' => 99.00, 'category_id' => $catSports],
            ['nombre' => 'Saco de Dormir Coleman', 'precio' => 45.00, 'category_id' => $catSports],
            ['nombre' => 'Linterna Frontal Black Diamond', 'precio' => 35.00, 'category_id' => $catSports],
            ['nombre' => 'Traje de Neopreno O\'Neill', 'precio' => 160.00, 'category_id' => $catSports],
            ['nombre' => 'Tabla de Surf Foamie', 'precio' => 250.00, 'category_id' => $catSports],

            // Juguetes
            ['nombre' => 'LEGO Star Wars Halcón Milenario', 'precio' => 169.99, 'category_id' => $catToys],
            ['nombre' => 'Muñeca Barbie Fashionista', 'precio' => 15.00, 'category_id' => $catToys],
            ['nombre' => 'Hot Wheels Pista Tiburón', 'precio' => 45.00, 'category_id' => $catToys],
            ['nombre' => 'Juego de Mesa Catan', 'precio' => 49.00, 'category_id' => $catToys],
            ['nombre' => 'Peluche Oso Gigante', 'precio' => 30.00, 'category_id' => $catToys],
            ['nombre' => 'Pistola Nerf Elite 2.0', 'precio' => 25.00, 'category_id' => $catToys],
            ['nombre' => 'Puzzle 1000 Piezas Paisaje', 'precio' => 18.00, 'category_id' => $catToys],
            ['nombre' => 'Coche Teledirigido 4x4', 'precio' => 55.00, 'category_id' => $catToys],
            ['nombre' => 'Casa de Muñecas Madera', 'precio' => 120.00, 'category_id' => $catToys],
            ['nombre' => 'Plastilina Play-Doh Set', 'precio' => 15.00, 'category_id' => $catToys],
            ['nombre' => 'Juego de Cartas UNO', 'precio' => 8.00, 'category_id' => $catToys],
            ['nombre' => 'Dron de Juguete para Niños', 'precio' => 40.00, 'category_id' => $catToys],
            ['nombre' => 'Figura de Acción Spider-Man', 'precio' => 20.00, 'category_id' => $catToys],
            ['nombre' => 'Set de Cocina de Juguete', 'precio' => 35.00, 'category_id' => $catToys],
            ['nombre' => 'Bicicleta de Equilibrio', 'precio' => 60.00, 'category_id' => $catToys],
            ['nombre' => 'Pizarra Magnética Dibujo', 'precio' => 12.00, 'category_id' => $catToys],
            ['nombre' => 'Microscopio Educativo', 'precio' => 45.00, 'category_id' => $catToys],
            ['nombre' => 'Telescopio Básico', 'precio' => 70.00, 'category_id' => $catToys],
            ['nombre' => 'Robot Programable Educativo', 'precio' => 90.00, 'category_id' => $catToys],
            ['nombre' => 'Cubo de Rubik 3x3', 'precio' => 10.00, 'category_id' => $catToys],

            // Sin Categoría (Algunos ejemplos)
            ['nombre' => 'Caja Misteriosa', 'precio' => 50.00, 'category_id' => $catNone],
            ['nombre' => 'Antigüedad Sin Clasificar', 'precio' => 200.00, 'category_id' => null], // Null o user selected 'sin categoria'
        ];

        foreach ($products as $data) {
            DB::table('products')->insert([
                'nombre' => $data['nombre'],
                'precio' => $data['precio'],
                'user_id' => $userId,
                'category_id' => $data['category_id'] ?? $catNone, // Default to Sin Categoría category if null
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
