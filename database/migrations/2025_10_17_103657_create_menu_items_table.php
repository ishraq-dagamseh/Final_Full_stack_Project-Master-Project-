<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->foreignId('restaurant_id')->constrained()->onDelete('cascade'); // Foreign key to restaurants table
            $table->string('name'); // Name of the dish
            $table->text('description')->nullable(); // Description of the dish (optional)
            $table->decimal('price', 8, 2); // Price of the dish (e.g., 12.99)
            $table->timestamps(); // created_at and updated_at columns
        });
       
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};
