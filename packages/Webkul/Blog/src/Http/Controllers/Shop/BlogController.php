<?php

namespace Webkul\Blog\Http\Controllers\Shop;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

use Parsedown;
use Webbycrown\BlogBagisto\Models\Blog;

class BlogController extends Controller
{
    use DispatchesJobs, ValidatesRequests;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('blog::shop.index');
    }

    public function show($slug)
{
        $blogPost = Blog::where('slug', $slug)->firstOrFail();
        $parsedown = new Parsedown();

        $blogPost->description = $parsedown->text($blogPost->description);

        return view('blog::shop.show', compact('blogPost'));
    }
}


