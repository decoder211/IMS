<?php

// use Illuminate\Database\Migrations\Migration;
// use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Support\Facades\Schema;

// return new class extends Migration
// {
//     public function up()
//     {
//         Schema::create('orders', function (Blueprint $table) {
//             $table->id();
//             $table->string('order_number')->unique();
//             $table->foreignId('customer_id')->constrained()->onDelete('cascade');
//             $table->foreignId('product_id')->constrained()->onDelete('cascade');
//             $table->integer('quantity');
//             $table->decimal('unit_price', 10, 2);
//             $table->decimal('total_amount', 10, 2);
//             $table->enum('status', ['Pending', 'Delivered', 'Cancelled'])->default('Pending');
//             $table->date('order_date');
//             $table->timestamps();
//         });
//     }

//     public function down()
//     {
//         Schema::dropIfExists('orders');
//     }
// };




use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// FIX: This migration was entirely missing from the project.
// Order model, OrderController, and DashboardController all query the orders
// table — without this, the app crashes with "table orders does not exist"
// on any order-related page.

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('total_amount', 10, 2);
            // FIX: Added 'Cancelled' to enum — Order::boot has logic to restore
            // stock on cancellation, but the status could never actually be set
            // to 'Cancelled' without it being in the enum.
            $table->enum('status', ['Pending', 'Delivered', 'Cancelled'])->default('Pending');
            $table->date('order_date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
