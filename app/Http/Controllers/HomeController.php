<?php
// ================================================
// FILE: app/Http/Controllers/HomeController.php
// FUNGSI: Menangani halaman utama website
// ================================================

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Menampilkan halaman beranda.
     *
     * Halaman ini menampilkan:
     * - Hero section (static)
     * - Kategori populer
     * - Produk unggulan (featured)
     * - Produk terbaru
     */
    public function index()
    {
        // ================================================
        // AMBIL DATA KATEGORI
        // - Hanya yang aktif
        // - Hitung jumlah produk di masing-masing kategori
        // ================================================
       $categories = Category::where('is_active', 1)
    ->whereHas('products', function ($query) {
        // Filter produk yang aktif dan stoknya ada
        $query->where('is_active', 1)
              ->where('stock', '>', 0);
    })
    ->withCount(['products as active_products_count' => function ($query) {
        // Ini untuk menampilkan jumlah angka produk di halaman
        $query->where('is_active', 1)
              ->where('stock', '>', 0);
    }])
    ->orderBy('name', 'asc')
    ->take(6)
    ->get();

        // ================================================
        // PRODUK UNGGULAN (FEATURED)
        // - Flag is_featured = true
        // - Aktif dan ada stok
        // ================================================
        $featuredProducts = Product::query()
            ->with(['category', 'primaryImage'])  // Eager load untuk performa
            ->active()                             // Scope: is_active = true
            ->inStock()                            // Scope: stock > 0
            ->featured()                           // Scope: is_featured = true
            ->latest()
            ->take(8)
            ->get();

        // ================================================
        // PRODUK TERBARU
        // - Urutkan dari yang paling baru
        // ================================================
        $latestProducts = Product::query()
            ->with(['category', 'primaryImage'])
            ->active()
            ->inStock()
            ->latest()         // Order by created_at DESC
            ->take(8)
            ->get();

        // ================================================
        // KIRIM DATA KE VIEW
        // compact() membuat array ['key' => $key]
        // ================================================
        return view('home', compact(
            'categories',
            'featuredProducts',
            'latestProducts'
        ));
    }
}