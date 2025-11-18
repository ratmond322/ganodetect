<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    // daftar produk sementara (hard-coded)
    private function productList()
    {
        return [
            [
                'slug' => 'ag-450s',
                'title' => 'GANODETECT AG-450S',
                'name' => 'GANODETECT AG-450S',
                'excerpt' => 'An Autonomous AI Inspection Drone featuring an 8MP NoIR Camera, Raspberry Pi 4 Processing, Pixhawk Waypoint Navigation, and Integrated Precision Sprayer for Ganoderma Treatment.',
                'image' => 'drone-shop.jpg', // pastikan file ini ada di public/images/
                'body' => '<p>GANODETECT AG-450S adalah drone inspeksi agriteknologi yang dirancang untuk mendeteksi dan menanggulangi Ganoderma pada perkebunan kelapa sawit.</p>',
                // spesifikasi lengkap yang kamu minta
                'brand' => 'Ganodetect',
                'model_name' => 'AG-450S (Agriculture Sprayer)',
                'special_feature' => 'Autonomous Ganoderma Detection, 8MP NoIR Multispectral Camera, Onboard AI Processing (Raspberry Pi 4), Autonomous Waypoint Navigation (Pixhawk), Integrated 12V Precision Sprayer, Brushless Motors, 433MHz Long-Range Telemetry',
                'age_range' => 'Professional, Research, Enterprise',
                'color' => 'White',
                'photo_resolution' => '8MP (3264 x 2464)',
                'capture' => 'Still Images for Analysis',
                'connectivity' => 'Wi-Fi (Data Sync), 433MHz Telemetry (MAVLink)',
                'included_components' => '1x Ganodetect AG-450S Drone (Assembled), 1x Pixhawk 2.4.8 FC, 1x Raspberry Pi 4 (4GB), 1x 8MP NoIR Camera, 1x GPS Ublox M8N, 1x 4S 5200mAh LiPo Battery, 1x 12V Precision Sprayer System, 1x 433MHz Telemetry Kit (Air+Ground), 4x Spare Propellers (1045)',
                'skill_level' => 'Advanced, Professional, Developer',
                'item_weight' => '2.2 kg (4.85 lbs)',
                'price' => '4,000,000',
                'price_original' => '5,000,000',
                'images' => [
                    'drone-shop.jpg',
                    'placeholder-624x400.png',
                    'image2.jpg',
                    'image3.jpg',
                ],
            ],
            // jika mau tambah produk lain, tambahkan elemen array baru di sini
        ];
    }

    // index (tampilkan halaman products, opsional kirim daftar produk)
    public function index()
    {
        $products = $this->productList();
        return view('products.index', compact('products'));
    }

    // show => detail halaman produk berdasarkan slug
    public function show($slug)
    {
        $products = $this->productList();
        $product = collect($products)->firstWhere('slug', $slug);

        if (! $product) {
            // debug tip: uncomment dd() jika ingin melihat slug dan daftar slug
            // dd('slug not found', $slug, array_column($products, 'slug'));
            abort(404);
        }

        // normalisasi & fallback
        if (! isset($product['title']) && isset($product['name'])) {
            $product['title'] = $product['name'];
        }
        $product['title'] = $product['title'] ?? 'Product';
        $product['image'] = $product['image'] ?? 'product-drone.jpg';
        $product['excerpt'] = $product['excerpt'] ?? '';
        $product['body'] = $product['body'] ?? '';

        return view('products.show', compact('product'));
    }
}
