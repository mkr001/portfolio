<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function index() {
    $projects = [
        ['title' => 'Project 1', 'description' => 'Description 1', 'link' => '#'],
        ['title' => 'Project 2', 'description' => 'Description 2', 'link' => '#'],
        // Add more projects here
    ];
    
    return view('portfolio.index', compact('projects'));
}

}
