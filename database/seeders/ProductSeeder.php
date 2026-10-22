<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // [nama, harga, stok, category_id, file gambar, deskripsi]
        $data = [
            ['Urban Walker', 450000, 12, 1, 'sepatu-01-urban-walker.jpg', 'Sepatu kets harian dengan sol empuk dan desain bersih yang cocok untuk kuliah maupun nongkrong.'],
            ['Street Classic', 520000, 8, 1, 'sepatu-02-street-classic.jpg', 'Sepatu kets bergaya klasik dengan bahan kuat dan mudah dipadukan dengan pakaian apa pun.'],
            ['Swift Runner', 680000, 15, 2, 'sepatu-03-swift-runner.jpg', 'Sepatu lari ringan dengan bantalan responsif dan bahan berpori agar kaki tetap nyaman.'],
            ['Trail Max', 750000, 0, 2, 'sepatu-04-trail-max.jpg', 'Sepatu lari medan alam dengan cengkeraman kuat untuk jalur yang tidak rata.'],
            ['Oxford Prime', 890000, 6, 3, 'sepatu-05-oxford-prime.jpg', 'Sepatu formal kulit sintetis premium untuk presentasi, wawancara, dan acara resmi.'],
            ['Derby Elegant', 820000, 4, 3, 'sepatu-06-derby-elegant.jpg', 'Sepatu pantofel dengan jahitan rapi dan sol nyaman untuk dipakai seharian.'],
            ['Slip-On Easy', 320000, 20, 4, 'sepatu-07-slip-on-easy.jpg', 'Sepatu selop praktis tanpa tali, ringan dan cocok untuk aktivitas santai.'],
            ['Canvas Daily', 280000, 3, 4, 'sepatu-08-canvas-daily.jpg', 'Sepatu kanvas simpel dengan banyak pilihan gaya untuk keseharian.'],
            ['Skyline High', 580000, 10, 1, 'sepatu-09-skyline-high.jpg', 'Sepatu kets model tinggi dengan bantalan tebal dan siluet tegas untuk gaya jalanan.'],
            ['Retro Court', 495000, 14, 1, 'sepatu-10-retro-court.jpg', 'Sepatu kets bergaya lapangan klasik dengan sol karet yang awet dan nyaman.'],
            ['Aero Sprint', 720000, 9, 2, 'sepatu-11-aero-sprint.jpg', 'Sepatu lari super ringan untuk kecepatan, dengan sol yang responsif.'],
            ['Pace Lite', 560000, 18, 2, 'sepatu-12-pace-lite.jpg', 'Sepatu lari harian dengan bantalan empuk untuk jarak menengah.'],
            ['Loafer Classic', 760000, 7, 3, 'sepatu-13-loafer-classic.jpg', 'Sepatu selop kulit sintetis tanpa tali yang rapi untuk kantor dan acara semiformal.'],
            ['Weekend Moc', 340000, 16, 4, 'sepatu-14-weekend-moc.jpg', 'Sepatu mokasin santai yang ringan untuk jalan-jalan akhir pekan.'],
            ['Hiker Pro', 850000, 5, 5, 'sepatu-15-hiker-pro.jpg', 'Bot luar ruangan tahan air dengan sol bergerigi untuk jalur mendaki.'],
            ['Chelsea Daily', 690000, 11, 5, 'sepatu-16-chelsea-daily.jpg', 'Bot dengan karet elastis di samping, mudah dipakai dan cocok untuk gaya kasual yang rapi.'],
        ];

        Storage::disk('public')->makeDirectory('products');

        foreach ($data as [$name, $price, $stock, $categoryId, $file, $description]) {
            $sumber = database_path('seeders/images/'.$file);
            $img = null;

            // salin gambar ke storage/app/public/products
            if (File::exists($sumber)) {
                Storage::disk('public')->put('products/'.$file, File::get($sumber));
                $img = 'products/'.$file;
            }

            Product::create([
                'name' => $name,
                'slug' => Product::makeSlug($name),
                'description' => $description,
                'category_id' => $categoryId,
                'price' => $price,
                'stock' => $stock,
                'img' => $img,
            ]);
        }
    }
}
