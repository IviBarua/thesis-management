<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupMember;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{

    public function create()
    {
        $teachers = User::where('role', 'teacher')->get();

        return view('group', compact('teachers'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'group_name' => 'required|string|max:255',
            'thesis_title' => 'required|string|max:255',
            'supervisor' => 'required|exists:users,id',

            'members' => 'required|array|min:1|max:5',
            'members.*.name' => 'required|string|max:255',
            'members.*.student_id' => 'required|string|max:100',
            'members.*.batch' => 'required|integer',
            'members.*.session' => 'required|in:spring,summer,fall',
            'members.*.department' => 'required|string|max:100',
            'members.*.role' => 'required|in:leader,member',
        ]);

        DB::transaction(function () use ($validated) {

            $group = Group::create([
                'group_name' => $validated['group_name'],
                'thesis_title' => $validated['thesis_title'],
                'supervisor_id' => auth()->id(),
            ]);

            foreach ($validated['members'] as $member) {

                GroupMember::create([
                    'group_id' => $group->id,
                    'name' => $member['name'],
                    'student_id' => $member['student_id'],
                    'batch' => $member['batch'],
                    'session' => $member['session'],
                    'department' => $member['department'],
                    'role' => $member['role'],
                ]);
            }
        });

        return redirect()
            ->route('dashboard')
            ->with('success', 'Group created successfully!');
    }

    public function edit(Group $group)
    {
        $group->load('members');

        $teachers = User::where('role', 'teacher')->get();

        return view('admin.edit-group', compact('group', 'teachers'));
    }


    public function update(Request $request, Group $group)
    {
        $validated = $request->validate([
            'group_name' => 'required|string|max:255',
            'thesis_title' => 'required|string|max:255',
            'supervisor' => 'required|exists:users,id',
            'members' => 'required|array|min:1|max:5',
            'members.*.name' => 'required|string|max:255',
            'members.*.student_id' => 'required|string|max:100',
            'members.*.batch' => 'required|integer',
            'members.*.session' => 'required|in:spring,summer,fall',
            'members.*.department' => 'required|string|max:100',
            'members.*.role' => 'required|in:leader,member',
        ]);


        DB::transaction(function () use ($validated, $request, $group) {

            $group->update([
                'group_name' => $validated['group_name'],
                'thesis_title' => $validated['thesis_title'],
                'supervisor_id' => $validated['supervisor'],
            ]);


            if ($request->has('removed_members')) {

                foreach ($request->removed_members as $memberId) {

                    GroupMember::where('id', $memberId)
                        ->where('group_id', $group->id)
                        ->delete();
                }
            }

            foreach ($validated['members'] as $memberKey => $memberData) {

                if (isset($memberData['id'])) {

                    $member = GroupMember::where('id', $memberData['id'])
                        ->where('group_id', $group->id)
                        ->first();

                    if ($member) {

                        $member->update([
                            'name' => $memberData['name'],
                            'student_id' => $memberData['student_id'],
                            'batch' => $memberData['batch'],
                            'session' => $memberData['session'],
                            'department' => $memberData['department'],
                            'role' => $memberData['role'],
                        ]);
                    }
                }

                else {

                    GroupMember::create([
                        'group_id' => $group->id,
                        'name' => $memberData['name'],
                        'student_id' => $memberData['student_id'],
                        'batch' => $memberData['batch'],
                        'session' => $memberData['session'],
                        'department' => $memberData['department'],
                        'role' => $memberData['role'],
                    ]);
                }
            }
        });

        if (auth()->user()->role === 'admin') {

            return redirect()
                ->route('admin.dashboard')
                ->with('success', 'Group updated successfully!');
        }

        return redirect()
            ->route('dashboard')
            ->with('success', 'Group updated successfully!');
    }
}