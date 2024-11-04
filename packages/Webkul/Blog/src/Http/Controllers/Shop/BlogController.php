<?php

namespace Webkul\Blog\Http\Controllers\Shop;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

use Parsedown;
use Webbycrown\BlogBagisto\Models\Blog;
use Webbycrown\BlogBagisto\Models\Category;
use Webbycrown\BlogBagisto\Models\Comment;
use Webbycrown\BlogBagisto\Models\Tag;
use Webbycrown\BlogBagisto\Http\Controllers\Shop\BlogController as BaseBlogController;

class BlogController extends BaseBlogController
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

//    public function show($slug)
//    {
//        $blogPost = Blog::where('slug', $slug)->firstOrFail();
//        $parsedown = new Parsedown();
//
//        $blogPost->description = $parsedown->text($blogPost->description);
//
//        return view('blog::shop.show', compact('blogPost'));
//    }

    public function view($blog_slug, $slug)
    {
        $blog = Blog::where('slug', $slug)->firstOrFail();

//        $myDesc = $blog->description;
//
//        $parsedown = new Parsedown();
//
//        $parsedDesc = $parsedown->text($myDesc);
//
//        $blog->description = $parsedDesc;

        $blog_id = ( $blog && !empty($blog) && !is_null($blog) ) ? (int)$blog->id : 0;

        $blog_tags = Tag::whereIn('id', explode(',',$blog->tags))->get();

        $paginate = $this->getConfigByKey('blog_post_maximum_related');
        $paginate = ( isset($paginate) && !empty($paginate) && is_null($paginate) ) ? (int)$paginate : 4;

        $blog_category_ids = array_merge( explode(',', $blog->default_category), explode(',', $blog->categorys) );

        $related_blogs = Blog::orderBy('id', 'desc')->where('status', 1)->whereNotIn('id', [$blog_id]);
        if ( is_array($blog_category_ids) && !empty($blog_category_ids) && count($blog_category_ids) > 0 ) {
            $related_blogs = $related_blogs->whereIn('default_category', $blog_category_ids)->where(
                function ($query) use ($blog_category_ids) {
                    foreach ($blog_category_ids as $key => $blog_category_id) {
                        if ( $key == 0 ) {
                            $query->whereRaw('FIND_IN_SET(?, categorys)', [$blog_category_id]);
                        } else {
                            $query->orWhereRaw('FIND_IN_SET(?, categorys)', [$blog_category_id]);
                        }
                    }
                });
        }
        $related_blogs = $related_blogs->paginate($paginate);

        $categories = Category::where('status', 1)->get();

        $tags = $this->getTagsWithCount();

        $comments = $this->getCommentsRecursive($blog_id);

        $total_comments = Comment::where('post', $blog_id)->where('status', 2)->get();

        $total_comments_cnt = ( !empty( $total_comments ) && count( $total_comments ) > 0 ) ? $total_comments->count() : 0;

        $loggedIn_user_name = $loggedIn_user_email = null;
        $loggedIn_user = auth()->guard('customer')->user();
        if ( $loggedIn_user && isset($loggedIn_user) && !empty($loggedIn_user) && !is_null($loggedIn_user) ) {
            $loggedIn_user_email = ( isset($loggedIn_user->email) && !empty($loggedIn_user->email) && !is_null($loggedIn_user->email) ) ? $loggedIn_user->email : null;
            $loggedIn_user_first_name = ( isset($loggedIn_user->first_name) && !empty($loggedIn_user->first_name) && !is_null($loggedIn_user->first_name) ) ? $loggedIn_user->first_name : null;
            $loggedIn_user_last_name = ( isset($loggedIn_user->last_name) && !empty($loggedIn_user->last_name) && !is_null($loggedIn_user->last_name) ) ? $loggedIn_user->last_name : null;
            $loggedIn_user_name = $loggedIn_user_first_name;
            $loggedIn_user_name = ( isset($loggedIn_user_name) && !empty($loggedIn_user_name) && !is_null($loggedIn_user_name) ) ? ( $loggedIn_user_name . ' ' . $loggedIn_user_last_name ) : $loggedIn_user_last_name;
        }

        $show_categories_count = $this->getConfigByKey('blog_post_show_categories_with_count');
        $show_tags_count = $this->getConfigByKey('blog_post_show_tags_with_count');
        $show_author_page = $this->getConfigByKey('blog_post_show_author_page');
        $enable_comment = $this->getConfigByKey('blog_post_enable_comment');
        $allow_guest_comment = $this->getConfigByKey('blog_post_allow_guest_comment');
        $maximum_nested_comment = $this->getConfigByKey('blog_post_maximum_nested_comment');

        $blog_seo_meta_title = $this->getConfigByKey('blog_seo_meta_title');
        $blog_seo_meta_keywords = $this->getConfigByKey('blog_seo_meta_keywords');
        $blog_seo_meta_description = $this->getConfigByKey('blog_seo_meta_description');

        return view($this->_config['view'], compact('blog', 'categories', 'tags', 'comments', 'total_comments', 'total_comments_cnt', 'related_blogs', 'blog_tags', 'show_categories_count', 'show_tags_count', 'show_author_page', 'enable_comment', 'allow_guest_comment', 'maximum_nested_comment', 'loggedIn_user', 'loggedIn_user_name', 'loggedIn_user_email', 'blog_seo_meta_title', 'blog_seo_meta_keywords', 'blog_seo_meta_description'));
    }
}


