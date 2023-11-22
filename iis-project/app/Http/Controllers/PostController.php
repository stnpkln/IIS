<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ThreadModel;
use App\Models\UserModel;
use App\Models\GroupMemberModel;
use App\Models\PostModel;
use App\Models\RatingModel;

class PostController extends Controller
{
    public function posts($threadId) {
        if (session('user') === null) {
            return redirect()->route('login');
        }
        $thread = ThreadModel::where('id', $threadId)->first();
        $userId = $this->getUserId(session('user'));
        if (!$this->isMember($thread->group_id, $userId)) {
            return redirect()->route('groups');
        }
        $canDelete = $this->isModerator($thread->group_id, $userId) || $thread->user_id === $userId;

        $posts = PostModel::where('thread_id', $threadId)
        ->select('posts.*', 'users.username')
        ->join('users', 'posts.user_id', '=', 'users.id')
        ->get();

        $posts = $this->markPostsAsRated($posts, $userId);

        return view('posts', ['thread' => $thread, 'canDelete' => $canDelete, 'posts' => $posts, 'userId' => $userId]);
    }

    private function isMember($groupId, $userId) {
        return GroupMemberModel::where('group_id', $groupId)->where('user_id', $userId)->first();
    }

    public function postCreate($threadId) {
        if (session('user') === null) {
            return redirect()->route('login');
        }
        $thread = ThreadModel::where('id', $threadId)->first();
        $userId = $this->getUserId(session('user'));
        if (!$this->isMember($thread->group_id, $userId)) {
            return redirect()->route('groups');
        }
        return view('post-create', ['thread' => $thread]);
    }

    public function postCreatePost(Request $request, $threadId) {
        $request->validate([
            'title' => 'required|max:50',
            'content' => 'required|max:500'
        ]);

        if (session('user') === null) {
            return redirect()->route('login');
        }
        $userId = $this->getUserId(session('user'));
        $thread = ThreadModel::where('id', $threadId)->first();
        if (!$this->isMember($thread->group_id, $userId)) {
            return redirect()->route('groups');
        }
        $post = new PostModel();
        $post->thread_id = $threadId;
        $post->user_id = $userId;
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->save();
        return redirect()->route('posts', ['id' => $threadId]);
    }

    public function postDelete(Request $request, $postId) {
        $post = PostModel::where('id', $postId)->first();
        $threadId = $post->thread_id;
        $thread = ThreadModel::where('id', $threadId)->first();
        $userId = $this->getUserId(session('user'));
        if (session('user') === null) {
            return redirect()->route('login');
        }
        if (!$this->isModerator($thread->group_id, $userId) && $post->user_id !== $userId) {
            return redirect()->route('groups');
        }
        $post->delete();
        return redirect()->route('posts', ['id' => $threadId]);
    }

    public function like(Request $request, $postId) {
        $post = PostModel::where('id', $postId)->first();
        $threadId = $post->thread_id;
        $thread = ThreadModel::where('id', $threadId)->first();
        if (session('user') === null) {
            return redirect()->route('login');
        }
        $userId = $this->getUserId(session('user'));
        if (!$this->isMember($thread->group_id, $userId)) {
            return redirect()->route('groups');
        }
        $rating = new RatingModel();
        $rating->user_id = $userId;
        $rating->post_id = $postId;
        $rating->rating_type = 'like';
        $rating->save();

        $post->rating = $post-> rating + 1;
        $post->save();

        return redirect()->route('posts', ['id' => $threadId]);
    }

    public function dislike(Request $request, $postId) {
        $post = PostModel::where('id', $postId)->first();
        $threadId = $post->thread_id;
        $thread = ThreadModel::where('id', $threadId)->first();
        if (session('user') === null) {
            return redirect()->route('login');
        }
        $userId = $this->getUserId(session('user'));
        if (!$this->isMember($thread->group_id, $userId)) {
            return redirect()->route('groups');
        }
        $rating = new RatingModel();
        $rating->user_id = $userId;
        $rating->post_id = $postId;
        $rating->rating_type = 'dislike';
        $rating->save();

        $post->rating = $post-> rating - 1;
        $post->save();

        return redirect()->route('posts', ['id' => $threadId]);
    }

    private function markPostsAsRated($posts, $userId) {
        foreach ($posts as $post) {
            $rating = RatingModel::where('user_id', $userId)->where('post_id', $post->id)->first();
            if ($rating) {
                $post->rating_type = $rating->rating_type;
            }
        }
        return $posts;
    }

    private function getUserId($userEmail) {
        return UserModel::where('email', $userEmail)->first()->id;
    }

    private function isModerator($groupId, $userId) {
        $role = GroupMemberModel::where('group_id', $groupId)->where('user_id', $userId)->first()->role;
        return ($role === 'moderator' || $role === 'owner');
    }
}
