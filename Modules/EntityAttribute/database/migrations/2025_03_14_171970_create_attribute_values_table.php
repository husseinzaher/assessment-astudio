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
        Schema::create('attribute_values', function (Blueprint $table) {
            $table->id();
            $table->morphs('attributable');
            $table->foreignIdFor(\Modules\EntityAttribute\Models\Attribute::class)->nullable()
                ->constrained()->cascadeOnDelete();
            $table->text('value');
            $table->timestamps();

            $table->unique(['attributable_id', 'attributable_type', 'attribute_id'], 'attributable_id_type_attribute_id_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attribute_values');
    }
};
