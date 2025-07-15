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
        Schema::create('template_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_template_id')->constrained()->onDelete('cascade');
            $table->string('field_name'); // database field name
            $table->string('field_label'); // display label
            $table->string('field_type'); // text, number, date, select, etc.
            $table->string('data_type')->default('string'); // string, integer, decimal, date, boolean
            $table->json('field_options')->nullable(); // for select fields, validation rules, etc.
            $table->boolean('is_required')->default(false);
            $table->boolean('is_filterable')->default(true);
            $table->boolean('is_groupable')->default(true);
            $table->boolean('is_sortable')->default(true);
            $table->boolean('is_visible')->default(true);
            $table->integer('sort_order')->default(0);
            $table->string('format_rule')->nullable(); // formatting rules for display
            $table->timestamps();
            
            $table->index(['report_template_id', 'sort_order']);
            $table->index(['field_name', 'is_visible']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('template_fields');
    }
};
