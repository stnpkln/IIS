<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserGroupModel;
use App\Models\GroupMemberModel;
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
            'name' => 'required',
            'description' => 'required',
            'visibility' => 'required'
        ]);

        $name = $request->input('name');
        $description = $request->input('description');
        $visibility = $request->input('visibility');
        
        $user = UserModel::where('email', session('user'))->first();
        if (!$user) {
            return redirect()->route('login'); // todo: error handling (vsude, protoze zatim je nulovy :))
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
        $group = UserGroupModel::select('description')->find($id);
        $members = \DB::table('group_members')
        ->select('group_members.user_id','group_members.role', 'group_members.group_id', 'users.username', 'users.id')
        ->join('users','users.id','=','group_members.user_id')
        ->where('group_members.group_id', $id)
        ->get();
        return view('group', ['group' => $group, 'members' => $members]);
    }
}
