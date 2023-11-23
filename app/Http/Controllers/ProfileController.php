<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Pages\ProfilePage;
use Illuminate\Http\Request;
use MoonShine\Pages\ViewPage;

class ProfileController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return ProfilePage::make();
    }
}
