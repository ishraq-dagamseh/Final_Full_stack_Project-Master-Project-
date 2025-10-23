<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Add these only if they don’t exist yet
            if (!Schema::hasColumn('orders', 'user_id')) {
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
            }

            if (!Schema::hasColumn('orders', 'restaurant_id')) {
                $table->foreignId('restaurant_id')->constrained()->onDelete('cascade');
            }

            if (!Schema::hasColumn('orders', 'menu_item_id')) {
                $table->foreignId('menu_item_id')->constrained()->onDelete('cascade');
            }

            if (!Schema::hasColumn('orders', 'total_price')) {
                $table->decimal('total_price', 8, 2)->default(0);
            }

            if (!Schema::hasColumn('orders', 'status')) {
                $table->string('status')->default('pending');
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['user_id', 'restaurant_id', 'menu_item_id', 'total_price', 'status']);
        });
    }
};
