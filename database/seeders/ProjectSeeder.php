<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Project;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Project::create([
            'title' => 'Car Showroom Management System',
            'description' => 'Built a web-based application for remote car management. Implemented backend services using Java and MySQL. Optimized data handling using Collection Frameworks. Designed user-friendly UI for better customer experience. Version control via GitHub.',
            'link' => 'https://github.com/mkr001/car-showroom',
            'image' => '/images/car-showroom.jpg'
        ]);

        Project::create([
            'title' => 'Sign Language Recognition System',
            'description' => 'Real-time sign language detection using computer vision. Trained ML models to recognize hand gestures. Implemented using Python, OpenCV, and Machine Learning.',
            'link' => 'https://github.com/mkr001/sign-language',
            'image' => '/images/sign-language.jpg'
        ]);

        // Add more projects as needed
    }
}
