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
    if (!Schema::hasTable('orders')) {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->decimal('total_price', 12, 2)->default(0);
            $table->string('status')->default('pending');
            $table->string('receiver_name', 100);
            $table->string('phone', 20);
            $table->string('address', 255);
            $table->timestamps();
        });
    }
}

public function down(): void
{
    // Không xóa dữ liệu hiện có.
}
};
