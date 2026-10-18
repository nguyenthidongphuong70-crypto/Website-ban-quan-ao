<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['category' => 'Áo thun', 'name' => 'Áo thun trơn nam', 'description' => 'Chất liệu cotton 100%, thoáng mát', 'price' => 150000, 'image' => 'ao_thun_01.jpg', 'size' => 'M', 'color' => 'Trắng', 'stock' => 50],
            ['category' => 'Áo thun', 'name' => 'Áo thun in hình', 'description' => 'In hình cá tính, form regular', 'price' => 180000, 'image' => 'ao_thun_02.jpg', 'size' => 'L', 'color' => 'Đen', 'stock' => 40],
            ['category' => 'Áo sơ mi', 'name' => 'Áo sơ mi công sở', 'description' => 'Vải kate không nhăn, lịch sự', 'price' => 250000, 'image' => 'ao_somi_01.jpg', 'size' => 'M', 'color' => 'Xanh nhạt', 'stock' => 30],
            ['category' => 'Áo sơ mi', 'name' => 'Áo sơ mi caro', 'description' => 'Kiểu dáng trẻ trung, năng động', 'price' => 230000, 'image' => 'ao_somi_02.jpg', 'size' => 'L', 'color' => 'Đỏ', 'stock' => 25],
            ['category' => 'Áo khoác', 'name' => 'Áo khoác dù 2 lớp', 'description' => 'Chống nước nhẹ, form rộng', 'price' => 350000, 'image' => 'ao_khoac_01.jpg', 'size' => 'XL', 'color' => 'Đen', 'stock' => 20],
            ['category' => 'Áo polo', 'name' => 'Áo polo nam', 'description' => 'Vải cá sấu cao cấp, thoáng khí', 'price' => 220000, 'image' => 'ao_polo_01.jpg', 'size' => 'M', 'color' => 'Xanh navy', 'stock' => 35],
        ];

        foreach ($products as $product) {
            $categoryId = DB::table('categories')->where('name', $product['category'])->value('id');
            if ($categoryId === null) {
                throw new RuntimeException('Chưa có danh mục: ' . $product['category'] . '. Chạy CategorySeeder trước.');
            }
            $exists = DB::table('products')
                ->where('category_id', $categoryId)
                ->where('name', $product['name'])
                ->where('size', $product['size'])
                ->where('color', $product['color'])
                ->exists();
            if (!$exists) {
                unset($product['category']);
                DB::table('products')->insert(array_merge($product, [
                    'category_id' => $categoryId,
                    'created_at' => now(),
                ]));
            }
        }
    }
}
