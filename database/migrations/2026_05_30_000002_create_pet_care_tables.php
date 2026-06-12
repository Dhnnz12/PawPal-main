<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('type'); // e.g., Dog, Cat, etc.
            $table->string('breed')->nullable();
            $table->integer('age'); // in years or months
            $table->decimal('weight', 5, 2)->nullable();
            $table->string('photo')->nullable();
            $table->text('health_notes')->nullable();
            $table->timestamps();
        });

        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('label'); // Home, Office, etc.
            $table->text('address_line');
            $table->string('city');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->boolean('is_primary')->default(false);
            $table->timestamps();
        });

        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('provider_id')->nullable()->references('id')->on('users')->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 12, 2);
            $table->integer('duration_minutes')->default(60);
            $table->string('provider_type')->nullable(); // groomer or veterinarian
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 12, 2);
            $table->integer('stock')->default(0);
            $table->string('image')->nullable();
            $table->timestamps();
        });

        Schema::create('provider_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('day_of_week'); // 0 = Sunday, 1 = Monday, etc.
            $table->time('start_time');
            $table->time('end_time');
            $table->boolean('is_available')->default(true);
            $table->timestamps();
        });

        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pet_owner_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('provider_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('pet_id')->constrained()->onDelete('cascade');
            $table->foreignId('service_id')->nullable()->constrained()->onDelete('set null');
            $table->date('booking_date');
            $table->time('start_time');
            $table->string('status')->default('pending'); // pending, confirmed, completed, cancelled
            $table->decimal('total_price', 12, 2);
            $table->foreignId('address_id')->nullable()->constrained()->onDelete('set null');
            $table->text('notes')->nullable();
            $table->text('completion_notes')->nullable(); // notes by groomer/vet upon completion
            $table->timestamps();
        });

        Schema::create('medical_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pet_id')->constrained()->onDelete('cascade');
            $table->foreignId('vet_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('booking_id')->nullable()->constrained()->onDelete('set null');
            $table->date('visit_date');
            $table->text('diagnosis');
            $table->text('treatment'); // tindakan
            $table->text('recommendation')->nullable(); // rekomendasi perawatan
            $table->text('notes')->nullable(); // catatan dari dokter
            $table->string('pdf_path')->nullable();
            $table->timestamps();
        });

        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('pet_owner_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('provider_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('rating'); // 1 to 5
            $table->text('comment')->nullable();
            $table->timestamps();
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pet_owner_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('status')->default('pending'); // pending, paid, shipped, completed, cancelled
            $table->decimal('total_amount', 12, 2);
            $table->text('shipping_address');
            $table->string('payment_proof')->nullable(); // proof of transfer
            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('quantity');
            $table->decimal('price', 12, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('medical_records');
        Schema::dropIfExists('bookings');
        Schema::dropIfExists('provider_schedules');
        Schema::dropIfExists('products');
        Schema::dropIfExists('services');
        Schema::dropIfExists('addresses');
        Schema::dropIfExists('pets');
    }
};
