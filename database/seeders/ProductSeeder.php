use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run()
    {
        Product::create([
            'title' => 'GANODETECT AG-450S',
            'slug' => 'ganodetect-ag-450s',
            'excerpt' => 'An Autonomous AI Inspection Drone featuring an 8MP NoIR Camera...',
            'description' => '<p>Deskripsi lengkap produk ...</p>',
            'image' => 'products/ag-450s.jpg',
            'published_at' => now(), // <-- penting
        ]);
    }
}
