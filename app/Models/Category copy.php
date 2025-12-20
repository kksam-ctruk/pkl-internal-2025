<?php
// app/Models/Category.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    // $fillable: Menentukan kolom mana saja yang BOLEH diisi secara massal
    // (Mass Assignment). Ini fitur keamanan Laravel untuk mencegah
    // user jahat mengisi kolom sensitive.
    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'is_active',
    ];

    // $casts: Mengubah tipe data dari database ke tipe PHP native.
    // Database: TINYINT(1) (0 atau 1)
    // Laravel: boolean (false atau true)
    protected $casts = [
        'is_active' => 'boolean',
    ];
    
    // ==================== BOOT (MODEL EVENTS) ====================
    /**
     * Method boot() dipanggil saat model di-initialize.
     * Kita gunakan untuk auto-generate slug.
     */
    protected static function boot()
    {
        parent::boot();

        // Event: creating (Sebelum data disimpan ke DB)
        // Kita gunakan untuk auto-generate slug dari name.
        // Event "creating" dipanggil sebelum model disimpan (baru)
        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });

        // Event "updating" dipanggil sebelum model diupdate
        static::updating(function ($category) {
            // Jika nama berubah, update slug juga
            if ($category->isDirty('name')) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    // ==================== RELATIONSHIPS ====================

    /**
     * Relasi One-to-Many: Satu Kategori memiliki BANYAK Produk.
     *
     * - Parameter 1: Model tujuan (Product::class)
     * - Parameter 2 (opsional): Foreign key di tabel products ('category_id')
     * - Parameter 3 (opsional): Local key di tabel categories ('id')
     */

    /**
     * Kategori memiliki banyak produk.
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Hanya produk aktif dan tersedia.
     */
    /**
     * Relasi dengan filter tambahan.
     * Hanya mengambil produk yang aktif dan stok > 0.
     *
     * Contoh penggunaan:
     * $category->activeProducts; // Return Collection of Products
     */
    public function activeProducts()
    {
        return $this->hasMany(Product::class)
                    ->where('is_active', true)
                    ->where('stock', '>', 0);
    }

    // ==================== SCOPES ====================

    /**
     * Scope untuk filter kategori aktif.
     * Penggunaan: Category::active()->get()
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: Hanya kategori yang memiliki produk aktif di dalamnya.
     * Menggunakan whereHas() untuk mengecek relasi.
     */
    public function scopeWithProducts($query)
    {
        return $query->whereHas('products', function ($q) {
            $q->where('is_active', true); // Di dalam relasi products
        });
    }

    // ==================== ACCESSORS ====================

    /**
     * Accessor: Membuat "Virtual Attribute" baru.
     * Nama attribute di code: $category->image_url
     * (Konversi dari getImageUrlAttribute -> image_url)
    */
    /**
     * URL gambar kategori atau placeholder.
     */
    public function getImageUrlAttribute(): string
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return asset('images/category-placeholder.png');
    }


    /**
     * Accessor: Menghitung jumlah produk aktif.
     * $category->products_count
    */
    public function getProductCountAttribute(): int
    {
        // Tips: Untuk performa, sebaiknya gunakan withCount() di controller
        // daripada menghitung manual di sini jika datanya banyak.
        return $this->activeProducts()->count();
    }

}  