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
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null');
            $table->string('title'); // عنوان الإعلان
            $table->text('description')->nullable(); // وصف الإعلان
            $table->decimal('price', 10, 2)->nullable(); // السعر
            $table->string('type')->nullable(); // النوع
            $table->text('additional_info')->nullable(); // معلومات إضافية

            $table->json('images')->nullable(); // أكثر من صورة (هنخزنها في JSON)

            $table->string('seller_name'); // اسم البائع
            $table->string('seller_phone'); // رقم الهاتف

            $table->boolean('allow_mobile_messages')->default(true); // السماح بالرسائل عبر الجوال
            $table->boolean('allow_whatsapp_messages')->default(true); // السماح بالرسائل عبر الواتساب

            $table->boolean('fee_agree')->default(false); // موافقة على الرسوم
            $table->boolean('is_featured')->default(false); // إعلان مميز

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ads');
    }
};
