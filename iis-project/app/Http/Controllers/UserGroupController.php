<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserGroupModel;
use App\Models\GroupMemberModel;
use App\Models\GroupJoinRequestModel;
use App\Models\UserModel;

class UserGroupController extends Controller
{
    public function groups()
    {
        $groups = UserGroupModel::all();
        return view('groups', ['groups' => $groups]);
    }

    public function groupCreate()
    {
        return view('group-create');
    }

    public function groupCreatePost(Request $request)
    {
        $request->validate([
            'name' => 'required|max:50',
            'description' => 'nullable|max:500',
            'visibility' => 'required'
        ]);

        $name = $request->input('name');
        $description = $request->input('description');
        $visibility = $request->input('visibility');
        
        $user = UserModel::where('email', session('user'))->first();
        if (!$user) {
            return redirect()->route('login');
        }

        $group = new UserGroupModel();
        $group->name = $name;
        $group->description = $description;
        $group->visibility = $visibility;
        $group->save();

        $groupMember = new GroupMemberModel();
        $groupMember->user_id = $user->id;
        $groupMember->group_id = $group->id;
        $groupMember->role = 'owner';
        
        $groupMember->save();

        return redirect()->route('groups');
    }

    public function group($id)
    {
        $group = UserGroupModel::select('description', 'visibility', 'id')->find($id);
        $members = \DB::table('group_members')
        ->select('group_members.user_id','group_members.role', 'group_members.group_id', 'users.username', 'users.id', 'users.email')
        ->join('users','users.id','=','group_members.user_id')
        ->where('group_members.group_id', $id)
        ->get();
        $requestSent = false;
        if (session('user') !== null) {
            $user = UserModel::where('email', session('user'))->first();
            $requestSent = (bool)GroupJoinRequestModel::where('requester_id', $user->id)
            ->where('group_id', $id)
            ->first();
        }

        return view('group', [
            'group' => $group,
            'members' => $members,
            'isUserInGroup' => $this->isUserInGroup($members),
            'requestSent' => $requestSent,
            'isUserMod' => $this->isUserMod($members),
        ]);
    }

    private function isUserInGroup($members): bool {
        $userEmail = session('user');
        $userInGroup = false;
        foreach ($members as $member) {
            if ($member->email === $userEmail) {
                $userInGroup = true;
                break;
            }
        }
        return $userInGroup;
    }

    private function isUserMod($members): bool {
        $userEmail = session('user');
        $userMod = false;
        foreach ($members as $member) {
            if ($member->email === $userEmail && ($member->role === 'owner' || $member->role === 'admin')) {
                $userMod = true;
                break;
            }
        }
        return $userMod;
    }


    public function myGroups() {
        // todo v menu, podle toho jestli je uzivatel prihlasen
        $userEmail = session('user');
        if (!$userEmail) {
            return redirect()->route('groups');
        }
        $myGroups = \DB::table('users')
        ->select('user_groups.id', 'user_groups.description', 'user_groups.visibility', 'user_groups.name')
        ->join('group_members', 'users.id', '=', 'group_members.user_id')
        ->join('user_groups', 'group_members.group_id', '=', 'user_groups.id')
        ->where('users.email', $userEmail)
        ->get();

        return view('my-groups', ['groups' => $myGroups]);
    }

    public function threads($id) {
        // todo
        // groupId
        // zobrazi thready dane skupiny
    }

    public function joinRequest(Request $request, $id) {
        $userEmail = session('user');
        if (!$userEmail) {
            return redirect()->route('login');
        }
        $joinRequest = new GroupJoinRequestModel();
        $joinRequest->requester_id = UserModel::where('email', $userEmail)->first()->id;
        $joinRequest->group_id = $id;
        $joinRequest->save();
        return redirect()->back()->with('success', 'žádost úspěšně odeslána');
    }

    public function requestList() {
        // $joinRequests = \DB::table('group_join_requests')
        // ->select('group_join_requests.requester_id', 'group_join_requests.group_id', 'users.username', 'users.id', 'user_groups.name')
        // ->join('user_groups', 'group_join_requests.group_id', '=', 'user_groups.id')
        // ->join('users', 'group_join_requests.requester_id', '=', 'users.id')
        // ->join('group_members', 'group_join_requests.group_id', '=', 'group_members.group_id')
        // ->get();
        if (!session('user')) {
            return redirect()->route('login');
        }
        $groupsIMod = \DB::table('users')
        ->select('user_groups.id', 'user_groups.name')
        ->join('group_members', 'users.id', '=', 'group_members.user_id')
        ->join('user_groups', 'group_members.group_id', '=', 'user_groups.id')
        ->where('users.email', session('user'))
        ->where(function($query) {
            $query->where('group_members.role', 'owner')
            ->orWhere('group_members.role', 'admin');
        })->get();

        $groupsIModIds = $groupsIMod->toArray();
        $groupsIModIds = array_map(function($group) {
            return $group->id;
        }, $groupsIModIds);

        $joinRequests = \DB::table('group_join_requests')
        ->select('group_join_requests.requester_id', 'group_join_requests.group_id', 'users.username', 'users.id', 'user_groups.name')
        ->join('user_groups', 'group_join_requests.group_id', '=', 'user_groups.id')
        ->join('users', 'group_join_requests.requester_id', '=', 'users.id')
        ->whereIn('group_join_requests.group_id', $groupsIModIds)
        ->get();

        return view('request-list', ['joinRequests' => $joinRequests]);
    }

    public function joinApprove(Request $request, $groupId, $userId) {
        $groupMember = new GroupMemberModel();
        $groupMember->user_id = $userId;
        $groupMember->group_id = $groupId;
        $groupMember->role = 'regular';
        $groupMember->save();

        GroupJoinRequestModel::where('requester_id', $userId)
        ->where('group_id', $groupId)
        ->delete();

        return redirect()->back();
    }

    public function kick(Request $request, $groupId, $userId) {
        GroupMemberModel::where('user_id', $userId)
        ->where('group_id', $groupId)
        ->delete();
        return redirect()->back();
    }
}
