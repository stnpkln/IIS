<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserGroupModel;
use App\Models\GroupMemberModel;
use App\Models\GroupJoinRequestModel;
use App\Models\GroupRoleRequestModel;
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
        $description = $request->input('description') ?? null;
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
        $group = UserGroupModel::select('description', 'visibility', 'id', 'name')->find($id);
        $members = \DB::table('group_members')
        ->select('group_members.user_id','group_members.role', 'group_members.group_id', 'users.username', 'users.id', 'users.email')
        ->join('users','users.id','=','group_members.user_id')
        ->where('group_members.group_id', $id)
        ->get();
        $joinRequestSent = false;
        $roleRequestSent = false;
        if (session('user') !== null) {
            $user = UserModel::where('email', session('user'))->first();

            $joinRequestSent = (bool)GroupJoinRequestModel::where('requester_id', $user->id)
            ->where('group_id', $id)
            ->first();

            $roleRequestSent = (bool)GroupRoleRequestModel::where('requester_id', $user->id)
            ->where('group_id', $id)
            ->first();
        }

        $userRole = $this->getUserRoleFromMembers($members);
        return view('group', [
            'group' => $group,
            'members' => $members,
            'isUserInGroup' => $this->isUserInGroup($members),
            'joinRequestSent' => $joinRequestSent,
            'roleRequestSent' => $roleRequestSent,
            'userRole' => $userRole
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

    private function getUserRoleFromMembers($members): string {
        $userEmail = session('user');
        $userMod = false;
        foreach ($members as $member) {
            if ($member->email === $userEmail) {
                return $member->role;
            }
        }
        return '';
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
        // todo predelat do kontroleru na thready
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

        $roleRequests = \DB::table('group_role_requests')
        ->select('group_role_requests.requester_id', 'group_role_requests.group_id', 'users.username', 'users.id', 'user_groups.name')
        ->join('user_groups', 'group_role_requests.group_id', '=', 'user_groups.id')
        ->join('users', 'group_role_requests.requester_id', '=', 'users.id')
        ->whereIn('group_role_requests.group_id', $groupsIModIds)
        ->get();

        return view('request-list', ['joinRequests' => $joinRequests, 'roleRequests' => $roleRequests]);
    }

    public function joinApprove(Request $request, $groupId, $userId) {
        if (session('user') === null) {
            return redirect()->route('login');
        }
        if ($this->getUserRoleInGroup($groupId, session('user')) !== 'owner') {
            return redirect()->route('groups');
        }
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

    public function joinDecline(Request $request, $groupId, $userId) {
        if (session('user') === null) {
            return redirect()->route('login');
        }
        if ($this->getUserRoleInGroup($groupId, session('user')) !== 'owner') {
            return redirect()->route('groups');
        }
        GroupJoinRequestModel::where('requester_id', $userId)
        ->where('group_id', $groupId)
        ->delete();

        return redirect()->back();
    }

    public function kick(Request $request, $groupId, $userId) { 
        if (!$this->canUserKick($groupId, $userId)) {
            return redirect()->back();
        }
        GroupMemberModel::where('user_id', $userId)
        ->where('group_id', $groupId)
        ->delete();
        return redirect()->back();
    }

    private function canUserKick($groupId, $userId) {
        $userEmail = session('user');
        if (!$userEmail) {
            return redirect()->route('login');
        }
        $user = UserModel::where('email', $userEmail)->first();
        $userRole = GroupMemberModel::where('user_id', $user->id)
        ->where('group_id', $groupId)
        ->first()->role;

        $userToKickRole = GroupMemberModel::where('user_id', $userId)
        ->where('group_id', $groupId)
        ->first()->role;
        if (($userRole === 'owner' && $userToKickRole !== 'owner')) {
            return true;
        }
        return false;
    }

    public function leave(Request $request, $groupId) {
        $userEmail = session('user');
        if (!$userEmail) {
            return redirect()->route('login');
        }
        $userId = UserModel::where('email', $userEmail)->first()->id;
        GroupMemberModel::where('user_id', $userId)
        ->where('group_id', $groupId)
        ->delete();
        return redirect()->back();
    }

    public function edit(Request $request, $id) {
        if (session('user') === null) {
            return redirect()->route('login');
        }
        if ($this->getUserRoleInGroup($id, session('user')) !== 'owner') {
            \Log::info('user is not owner, its: ' . $this->getUserRoleInGroup($id, session('user')));
            return redirect()->back();
        }
        $group = UserGroupModel::find($id);
        return view('group-edit', ['group' => $group]);
    }

    public function delete(Request $request, $id) {
        if (!session('user')) {
            return redirect()->route('login');
        }
        if ($this->getUserRoleInGroup($id, session('user')) !== 'owner') {
            return redirect()->route('groups');
        }
        $group = UserGroupModel::find($id)->delete();
        return redirect()->route('groups');
    }

    private function getUserRoleInGroup($groupId, $userEmail) {
        $userId = UserModel::where('email', session('user'))->first()->id;
        return GroupMemberModel::where('user_id', $userId)->where('group_id', $groupId)->first()->role;
    }

    public function editPost(Request $request, $id) {
        if (!session('user')) {
            return redirect()->route('login');
        }
        if ($this->getUserRoleInGroup($id, session('user')) !== 'owner') {
            return redirect()->route('groups');
        }
        $request->validate([
            'name' => 'required|max:50',
            'description' => 'nullable|max:500',
            'visibility' => 'required'
        ]);

        $name = $request->input('name');
        $description = $request->input('description');
        $visibility = $request->input('visibility');
        
        $group = UserGroupModel::find($id);
        $group->name = $name;
        $group->description = $description;
        $group->visibility = $visibility;
        $group->save();

        return redirect()->route('group', ['id' => $id]);
    }

    public function roleRequest(Request $request, $groupId) {
        if (session('user') === null) {
            return redirect()->route('login');
        }
        if ($this->getUserRoleInGroup($groupId, session('user')) !== 'regular') {
            \Log::info('user is not regular, its: ' . $this->getUserRoleInGroup($groupId, session('user')));
            return redirect()->route('groups');
        }
        $roleRequest = new GroupRoleRequestModel();
        $roleRequest->requester_id = UserModel::where('email', session('user'))->first()->id;
        $roleRequest->group_id = $groupId;
        $roleRequest->save();

        return redirect()->back()->with('success', 'žádost úspěšně odeslána');
    }

    public function roleApprove(Request $request, $groupId, $userId) {
        if (session('user') === null) {
            return redirect()->route('login');
        }
        if ($this->getUserRoleInGroup($groupId, session('user')) !== 'owner') {
            return redirect()->route('groups');
        }
        $groupMember = GroupMemberModel::where('user_id', $userId)
        ->where('group_id', $groupId)
        ->update(['role' => 'moderator']);

        GroupRoleRequestModel::where('requester_id', $userId)
        ->where('group_id', $groupId)
        ->delete();

        return redirect()->back();
    }

    public function roleDecline(Request $request, $groupId, $userId) {
        if (session('user') === null) {
            return redirect()->route('login');
        }
        if ($this->getUserRoleInGroup($groupId, session('user')) !== 'owner') {
            return redirect()->route('groups');
        }
        GroupRoleRequestModel::where('requester_id', $userId)
        ->where('group_id', $groupId)
        ->delete();

        return redirect()->back();
    }

    public function roleDerank(Request $request, $groupId, $userId) {
        if (session('user') === null) {
            return redirect()->route('login');
        }
        if ($this->getUserRoleInGroup($groupId, session('user')) !== 'owner') {
            return redirect()->route('groups');
        }
        $groupMember = GroupMemberModel::where('user_id', $userId)
        ->where('group_id', $groupId)
        ->update(['role' => 'regular']);

        return redirect()->back();
    }
}
