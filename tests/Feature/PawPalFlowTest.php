<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use App\Models\Service;
use App\Models\Booking;
use App\Models\Pet;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PawPalFlowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Memasukkan dummy data ke database in-memory
        $this->seed(DatabaseSeeder::class);
    }

    public function test_pet_owner_can_add_pet()
    {
        $owner = User::where('role', 'pet_owner')->first();
        
        $response = $this->actingAs($owner)->post(route('pets.store'), [
            'name' => 'Simba',
            'type' => 'Cat',
            'breed' => 'Anggora',
            'age' => 1,
            'weight' => 3.5,
        ]);
        
        $response->assertRedirect(route('pets.index'));
        $this->assertDatabaseHas('pets', ['name' => 'Simba', 'user_id' => $owner->id]);
    }

    public function test_pet_owner_can_checkout_marketplace()
    {
        Storage::fake('public');
        $owner = User::where('role', 'pet_owner')->first();
        $product = Product::first();
        $initialStock = $product->stock;

        // Tambah produk ke keranjang
        $response = $this->actingAs($owner)->post(route('marketplace.cart.add', $product), [
            'quantity' => 2,
        ]);
        $response->assertSessionHas('cart');

        // Melakukan checkout
        $file = UploadedFile::fake()->image('bukti.jpg');
        $response = $this->actingAs($owner)->post(route('marketplace.checkout'), [
            'shipping_address' => 'Jl. Kebon Jeruk No 1',
            'payment_proof' => $file,
        ]);

        $response->assertRedirect(route('owner.dashboard'));
        
        // Memastikan order tersimpan di database
        $this->assertDatabaseHas('orders', [
            'pet_owner_id' => $owner->id,
            'status' => 'pending',
            'shipping_address' => 'Jl. Kebon Jeruk No 1',
        ]);

        // Memastikan stok produk berkurang
        $product->refresh();
        $this->assertEquals($initialStock - 2, $product->stock);
    }

    public function test_admin_does_not_see_review_button_but_owner_does()
    {
        $owner = User::where('role', 'pet_owner')->first();
        $admin = User::where('role', 'admin')->first();
        $pet = Pet::first();
        $service = Service::first();
        $provider = User::where('role', 'service_provider')->first();

        // Membuat booking yang sudah selesai
        $booking = Booking::create([
            'pet_owner_id' => $owner->id,
            'provider_id' => $provider->id,
            'pet_id' => $pet->id,
            'service_id' => $service->id,
            'booking_date' => now()->addDay()->format('Y-m-d'),
            'start_time' => '10:00',
            'status' => 'completed',
            'total_price' => $service->price,
        ]);

        // Tes: Pet Owner melihat tombol Review
        $response = $this->actingAs($owner)->get(route('bookings.show', $booking));
        $response->assertSee('Beri Rating');

        // Tes: Admin TIDAK melihat tombol Review
        $response = $this->actingAs($admin)->get(route('bookings.show', $booking));
        $response->assertDontSee('Beri Rating');
    }

    public function test_pet_owner_can_give_review()
    {
        $owner = User::where('role', 'pet_owner')->first();
        $pet = Pet::first();
        $service = Service::first();
        $provider = User::where('role', 'service_provider')->first();

        $booking = Booking::create([
            'pet_owner_id' => $owner->id,
            'provider_id' => $provider->id,
            'pet_id' => $pet->id,
            'service_id' => $service->id,
            'booking_date' => now()->addDay()->format('Y-m-d'),
            'start_time' => '10:00',
            'status' => 'completed',
            'total_price' => $service->price,
        ]);

        $response = $this->actingAs($owner)->post(route('reviews.store'), [
            'booking_id' => $booking->id,
            'rating' => 5,
            'comment' => 'Pelayanan sangat bagus!',
        ]);

        $response->assertRedirect();
        
        $this->assertDatabaseHas('reviews', [
            'booking_id' => $booking->id,
            'pet_owner_id' => $owner->id,
            'provider_id' => $provider->id,
            'rating' => 5,
        ]);
    }
}
