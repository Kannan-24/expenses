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
        Schema::create('report_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('template_category_id')->nullable()->constrained()->onDelete('set null');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('report_type'); // transactions, budgets, tickets, custom
            $table->json('group_by_config')->nullable(); // Group by configuration
            $table->json('summary_by_config')->nullable(); // Summary by configuration  
            $table->json('filters_config')->nullable(); // Filters configuration
            $table->json('chart_config')->nullable(); // Chart and visualization settings
            $table->json('formatting_config')->nullable(); // Conditional formatting rules
            $table->boolean('is_public')->default(false); // Can be shared with other users
            $table->boolean('is_active')->default(true);
            $table->string('version', 10)->default('1.0');
            $table->integer('usage_count')->default(0);
            $table->timestamp('last_used_at')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'is_active']);
            $table->index(['template_category_id', 'is_active']);
            $table->index(['report_type', 'is_public']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_templates');
    }
};
