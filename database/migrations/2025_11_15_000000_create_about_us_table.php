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
        Schema::create('about_us', function (Blueprint $table) {
            $table->id();
            // القسم الرئيسي
            $table->string('main_title')->nullable();
            $table->text('main_description')->nullable();

            // الرسالة
            $table->string('mission_title')->nullable();
            $table->text('mission_description')->nullable();

            // الرؤية
            $table->string('vision_title')->nullable();
            $table->text('vision_description')->nullable();

            // الإحصائيات (أرقام سريعة عن الموقع/الشركة)
            $table->string('stat_1_label')->nullable();
            $table->string('stat_1_value')->nullable();
            $table->string('stat_2_label')->nullable();
            $table->string('stat_2_value')->nullable();
            $table->string('stat_3_label')->nullable();
            $table->string('stat_3_value')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_us');
    }
};
