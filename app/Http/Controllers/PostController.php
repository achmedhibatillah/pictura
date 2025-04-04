<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Slide;
use App\Models\UserToPostLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    public function post_like(Request $request)
    {
        if ($request->like_req == 'like') {
            $likeData = [
                'relation_id' => LogicController::generateUniqueId('user_to_post_like', 'relation_id'),
                'user_id' => session('user')['user_id'],
                'post_id' => $request->post_id,
                'like_status' => 1,
            ];
            UserToPostLike::create($likeData);
        } else {
            UserToPostLike::where('post_id', $request->post_id)
                ->where('user_id', session('user')['user_id'])
                ->delete();
        }
    
        // Hitung total like terbaru
        $likesCount = UserToPostLike::where('post_id', $request->post_id)->count();
    
        // Return JSON agar bisa digunakan oleh AJAX
        return response()->json(['likes_count' => $likesCount]);
    }
    

    public function post_share(Request $request)
    {
        $postData = [
            'post_status' => 1,
            'created_at' => now(),
        ];

        Post::where('post_id', $request->post_id)->update($postData);
        return redirect()->to('usr/' . session('user')['user_username'])->with('success', 'New post successfully added.');
    }

    public function post_desc_edit(Request $request)
    {
    
        Post::where('post_id', $request->post_id)->update([
            'post_desc' => $request->post_desc,
        ]);
    
        return response()->json(['success' => true, 'message' => 'Post description updated']);
    }
    

    public function post_image_new(Request $request)
    {    
        if ($request->has('slide_image_cropped')) {
            $imageData = $request->input('slide_image_cropped');
    
            $imageData = str_replace('data:image/jpeg;base64,', '', $imageData);
            $imageData = str_replace('data:image/png;base64,', '', $imageData);
            $imageData = str_replace('data:image/jpg;base64,', '', $imageData);
    
            $image = base64_decode($imageData);
    
            $slide_image_filename = LogicController::generateUniqueId('slide', 'slide_image', 35) . '.jpg';
    
            $slide_image_path = 'assets/img/post/';
            $destinationPath = public_path($slide_image_path);
    
            file_put_contents($destinationPath . $slide_image_filename, $image);
    
            $lastSlideOrder = Slide::where('post_id', $request->post_id)->max('slide_order');
    
            $slideData = [
                'slide_id' => LogicController::generateUniqueId('slide', 'slide_id'),
                'slide_image' => $slide_image_path . $slide_image_filename,
                'slide_order' => $lastSlideOrder ? $lastSlideOrder + 1 : 1,
                'post_id' => $request->post_id,
            ];
    
            Slide::create($slideData);
    
            return redirect()->back();
        }
    
        return redirect()->back();
    }
    

    public function post_image_del(Request $request)
    {
        $slideData = Slide::where('slide_id', $request->slide_id)->first();
    
        if (!$slideData) {
            return redirect()->back()->with('error', 'Slide not found.');
        }
    
        $post_id = $slideData->post_id;
    
        File::delete($slideData->slide_image);
    
        $slideData->delete();
    
        $slides = Slide::where('post_id', $post_id)->orderBy('slide_order')->get();    
        foreach ($slides as $index => $slide) {
            $slide->update(['slide_order' => $index + 1]);
        }
    
        return redirect()->back()->with('success', 'Image deleted and order updated.');
    }
    
    public function post_image_up(Request $request)
    {
        $currentSlide = Slide::where('slide_id', $request->slide_id)->first();

        $minSlideOrder = Slide::where('post_id', $request->post_id)->min('slide_order');

        if ($currentSlide->slide_order <= $minSlideOrder) {
            return redirect()->back();
        }

        $previousSlide = Slide::where('post_id', $request->post_id)->where('slide_order', $currentSlide->slide_order - 1)->first();

        if ($previousSlide) {
            $currentSlideOrder = $currentSlide->slide_order;
            $previousSlideOrder = $previousSlide->slide_order;

            $currentSlide->update(['slide_order' => $previousSlideOrder]);
            $previousSlide->update(['slide_order' => $currentSlideOrder]);
        }

        return redirect()->back();
    }

    public function post_image_down(Request $request)
    {
        $currentSlide = Slide::where('slide_id', $request->slide_id)->first();
    
        $maxSlideOrder = Slide::where('post_id', $request->post_id)->max('slide_order');
    
        if ($currentSlide->slide_order >= $maxSlideOrder) {
            return redirect()->back();
        }
    
        $nextSlide = Slide::where('post_id', $request->post_id)->where('slide_order', $currentSlide->slide_order + 1)->first();
    
        if ($nextSlide) {
            $currentSlideOrder = $currentSlide->slide_order;
            $nextSlideOrder = $nextSlide->slide_order;
    
            $currentSlide->update(['slide_order' => $nextSlideOrder]);
            $nextSlide->update(['slide_order' => $currentSlideOrder]);
        }
    
        return redirect()->back();
    }    

}
