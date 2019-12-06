<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class GalleryController extends Controller
{
    /**
     * GalleryController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param int $page
     *
     * @return View
     */
    public function showGalleryList(int $page = 1): View
    {
        return view('media.gallery');
    }
}
