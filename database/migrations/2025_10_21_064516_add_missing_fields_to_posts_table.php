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
        Schema::table('posts', function (Blueprint $table) {
            // Property subtypes and additional details
            $table->string('property_subtype')->nullable()->after('property_type');
            $table->string('land_area')->nullable()->after('area');
            $table->string('floor_area')->nullable()->after('land_area');
            $table->string('num_floors')->nullable()->after('floor_area');
            $table->string('price_type')->nullable()->after('price'); // fixed, negotiable, call
            $table->json('features')->nullable(); // Store as JSON array
            
            // Contact details
            $table->string('contact_name')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('whatsapp_phone')->nullable();
            
            // File uploads
            $table->json('images')->nullable(); // Store image paths as JSON array
            $table->string('video_path')->nullable();
            
            // Commercial specific
            $table->string('commercial_type')->nullable();
            $table->string('floor_level')->nullable();
            
            // Land specific
            $table->string('land_unit')->nullable();
            
            // Rename existing columns to match our form
            $table->renameColumn('title', 'ad_title');
            $table->renameColumn('description', 'ad_description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn([
                'property_subtype',
                'land_area',
                'floor_area',
                'num_floors',
                'price_type',
                'features',
                'contact_name',
                'contact_email',
                'contact_phone',
                'whatsapp_phone',
                'images',
                'video_path',
                'commercial_type',
                'floor_level',
                'land_unit'
            ]);
            
            // Revert column names
            $table->renameColumn('ad_title', 'title');
            $table->renameColumn('ad_description', 'description');
        });
    }
};