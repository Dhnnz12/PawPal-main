<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GeneratePlaceholderImages extends Command
{
    protected $signature = 'images:generate-placeholders';
    protected $description = 'Generate colored placeholder images for demo data';

    public function handle()
    {
        $this->info('Generating colorful placeholder images...');

        // Create directories
        $directories = [
            'public/storage/avatars',
            'public/storage/pets',
            'public/storage/products',
            'public/storage/certifications',
        ];

        foreach ($directories as $dir) {
            if (!File::exists($dir)) {
                File::makeDirectory($dir, 0755, true);
                $this->info("✅ Created directory: $dir");
            }
        }

        // Colorful placeholder definitions (color, emoji/text, name)
        $avatars = [
            'public/storage/avatars/owner-avatar.jpg' => ['#4CAF50', 'BS', 'Budi Santoso'],
            'public/storage/avatars/groomer-indra.jpg' => ['#FF9800', 'IG', 'Indra'],
            'public/storage/avatars/vet-sarah.jpg' => ['#2196F3', 'SW', 'Sarah'],
            'public/storage/avatars/petshop-lestari.jpg' => ['#E91E63', 'PL', 'Pet Shop'],
            'public/storage/avatars/vet-toni.jpg' => ['#9C27B0', 'TH', 'Toni'],
        ];

        $pets = [
            'public/storage/pets/luna-persia-cat.jpg' => ['#FFE082', '🐱', 'Luna Persia'],
            'public/storage/pets/rocky-golden-retriever.jpg' => ['#D4A574', '🐕', 'Rocky Golden'],
        ];

        $products = [
            'public/storage/products/royal-canin-cat-food-2kg.jpg' => ['#FFEB3B', '🥫', 'Royal Canin'],
            'public/storage/products/furrymagic-shampoo-250ml.jpg' => ['#81C784', '🧴', 'FurryMagic'],
            'public/storage/products/cozynest-cat-bed.jpg' => ['#E8C4D8', '🛏️', 'CozyNest'],
        ];

        $certs = [
            'public/storage/certifications/sertifikat-drh-sarah-wijaya.pdf' => ['#2196F3', '📜', 'Sertifikat Sarah'],
            'public/storage/certifications/sertifikat-drh-toni-hartono.pdf' => ['#9C27B0', '📜', 'Sertifikat Toni'],
        ];

        $allPlaceholders = array_merge($avatars, $pets, $products, $certs);

        foreach ($allPlaceholders as $filePath => [$color, $emoji, $name]) {
            try {
                // Determine size based on type
                $width = strpos($filePath, 'avatars') !== false ? 200 : 400;
                $height = strpos($filePath, 'certifications') !== false ? 600 : $width;
                
                // Create SVG and save with .svg extension
                $svgData = $this->createColoredSvg($color, $emoji, $name, $width, $height);
                
                // Save as SVG
                $svgPath = str_replace(['.pdf', '.jpg'], '.svg', $filePath);
                File::put($svgPath, $svgData);
                
                $this->info("✅ Created: " . basename($svgPath) . " | Color: $color");
            } catch (\Exception $e) {
                $this->warn("❌ Error creating " . basename($filePath) . ": " . $e->getMessage());
            }
        }

        $this->info('✅ All colorful placeholder images created successfully!');
        $this->info('💡 Tip: For production, convert SVG to JPG using ImageMagick or online service');
    }

    /**
     * Create a colored SVG placeholder (browser will render it fine)
     */
    private function createColoredSvg($hexColor, $emoji, $text, $width = 400, $height = 400)
    {
        // Determine text color based on background brightness
        $rgb = sscanf($hexColor, "#%02x%02x%02x");
        $brightness = ($rgb[0] * 299 + $rgb[1] * 587 + $rgb[2] * 114) / 1000;
        $textColor = $brightness > 150 ? '#333333' : '#ffffff';

        $fontSize = $width > 300 ? 80 : 40;
        $textY = ($height / 2) - 20;
        $emojiY = ($height / 2) - 80;
        $centerX = $width / 2;

        $svg = <<<'SVG'
<?xml version="1.0" encoding="UTF-8"?>
<svg width="{WIDTH}" height="{HEIGHT}" xmlns="http://www.w3.org/2000/svg">
    <defs>
        <style>
            .bg { fill: {COLOR}; }
            .text { font-family: Arial, sans-serif; fill: {TEXT_COLOR}; text-anchor: middle; }
            .emoji { font-size: {FONT_SIZE}px; }
            .label { font-size: 16px; }
        </style>
    </defs>
    
    <rect width="{WIDTH}" height="{HEIGHT}" class="bg"/>
    
    <text x="{CENTER_X}" y="{EMOJI_Y}" class="text emoji">
        {EMOJI}
    </text>
    
    <text x="{CENTER_X}" y="{TEXT_Y}" class="text label">
        {TEXT}
    </text>
</svg>
SVG;

        // Replace placeholders with actual values
        $svg = str_replace(
            ['{WIDTH}', '{HEIGHT}', '{COLOR}', '{TEXT_COLOR}', '{FONT_SIZE}', '{CENTER_X}', '{EMOJI_Y}', '{TEXT_Y}', '{EMOJI}', '{TEXT}'],
            [$width, $height, $hexColor, $textColor, $fontSize, $centerX, $emojiY, $textY, $emoji, $text],
            $svg
        );

        return $svg;
    }
}




