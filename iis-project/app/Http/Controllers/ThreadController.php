<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ThreadModel;
use App\Models\UserModel;
use App\Models\GroupMemberModel;

class ThreadController extends Controller
{
    public function threads($groupId) {
        $threads = ThreadModel::where('group_id', $groupId)->get();
        return view('threads', ['threads' => $threads, 'groupId' => $groupId]);
    }


    public function threadCreate($groupId) {
        return view('thread-create', ['groupId' => $groupId]);
    }

    public function threadCreatePost(Request $request, $groupId) {
        if (session('user') === null) {
            return redirect()->route('login');
        }
        if (!$this->isMember($groupId, session('user'))) {
            return redirect()->route('groups');
        }
        $request->validate([
            'topic' => 'required|max:255'
        ]);

        $userId = $this->getUserId(session('user'));
        if ($userId === null) {
            return redirect()->route('login');
        }

        $thread = new ThreadModel();
        $thread->user_id = $userId;
        $thread->group_id = $groupId;
        $thread->topic = $request->input('topic');
        $thread->save();

        return redirect()->route('posts', ['id' => $thread->id]);
    }

    public function delete(Request $request, $threadId) {
        if (session('user') === null) {
            return redirect()->route('login');
        }
        $userId = $this->getUserId(session('user'));
        $thread = ThreadModel::where('id', $threadId)->first();
        $groupId = $thread->group_id;
        if ($thread === null ||
            ($thread->user_id !== $userId &&
            !$this->isModerator($thread->group_id, $userId))) {
            return redirect()->route('groups');
        }
        $thread->delete();
        return redirect()->route('threads', ['groupId' => $groupId]);
    }

    private function isMember($groupId, $userEmail) {
        $userId = $this->getUserId($userEmail);
        if ($userId === null) {
            return false;
        }
        return GroupMemberModel::where('group_id', $groupId)->where('user_id', $userId)->first();
    }

    private function getUserId($userEmail) {
        return UserModel::where('email', $userEmail)->first()->id;
    }

    private function isModerator($groupId, $userId) {
        $role = GroupMemberModel::where('group_id', $groupId)->where('user_id', $userId)->first()->role;
        return ($role === 'moderator' || $role === 'owner');
    }
}
