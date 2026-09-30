<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Group;
use App\Models\GroupMember;

class AdminController extends Controller
{
    public function dashboard()
    {
        $groups = Group::with(['supervisor', 'members'])
            ->withCount('members')
            ->get();

        $teachers = User::where('role', 'teacher')->get();

        // Dashboard statistics
        $totalMembers = GroupMember::count();
        $totalTeachers = User::where('role', 'teacher')->count();
        $totalGroups = Group::count();
        $totalAdmins = User::where('role', 'admin')->count();

        return view('admin.dashboard', compact(
            'groups',
            'teachers',
            'totalMembers',
            'totalTeachers',
            'totalGroups',
            'totalAdmins'
        ));
    }

    public function editTeacher($id)
    {
        $teacher = User::where('role', 'teacher')->findOrFail($id);

        return view('admin.edit-teacher', compact('teacher'));
    }

    public function updateTeacher(Request $request, $id)
    {
        $teacher = User::where('role', 'teacher')->findOrFail($id);

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'email' => 'required|email|unique:users,email,' . $teacher->id,
            'phone' => 'required|string|max:20',
            'department' => 'required|string|max:255',
            'degree' => 'required|string|max:255',
            'batch' => 'required|integer',
            'session' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'teacher_id' => 'required|string|unique:users,teacher_id,' . $teacher->id,
        ]);

        $teacher->update($validated);

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Teacher information updated successfully.');
    }

    public function deleteTeacher($id)
    {
        $teacher = User::where('role', 'teacher')->findOrFail($id);

        $teacher->delete();

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Teacher deleted successfully.');
    }

    public function editGroup($id)
    {
        $group = Group::with('members')->findOrFail($id);

        $teachers = User::where('role', 'teacher')->get();

        return view('admin.edit-group', compact('group', 'teachers'));
    }

    public function updateGroup(Request $request, $id)
        {
            $group = Group::with('members')->findOrFail($id);

            $validated = $request->validate([
                'group_name' => 'required|string|max:255',
                'thesis_title' => 'required|string|max:255',
                'supervisor' => 'required|exists:users,id',

                'members' => 'required|array|min:1|max:5',

                'members.*.id' => 'nullable|integer',
                'members.*.name' => 'required|string|max:255',
                'members.*.student_id' => 'required|string|max:100',
                'members.*.batch' => 'required|integer',
                'members.*.session' => 'required|in:spring,summer,fall',
                'members.*.department' => 'required|string|max:255',
                'members.*.role' => 'required|in:leader,member',

                'removed_members' => 'nullable|array',
                'removed_members.*' => 'integer',
            ]);

            \DB::transaction(function () use ($group, $validated) {

                // Update group
                $group->update([
                    'group_name' => $validated['group_name'],
                    'thesis_title' => $validated['thesis_title'],
                    'supervisor_id' => $validated['supervisor'],
                ]);


                // Delete members that were removed
                if (!empty($validated['removed_members'])) {

                    $group->members()
                        ->whereIn('id', $validated['removed_members'])
                        ->delete();
                }


                // Update existing members / create new members
                foreach ($validated['members'] as $memberData) {

                    if (!empty($memberData['id'])) {

                        // EXISTING MEMBER
                        $member = $group->members()
                            ->where('id', $memberData['id'])
                            ->firstOrFail();

                        $member->update([
                            'name' => $memberData['name'],
                            'student_id' => $memberData['student_id'],
                            'batch' => $memberData['batch'],
                            'session' => $memberData['session'],
                            'department' => $memberData['department'],
                            'role' => $memberData['role'],
                        ]);

                    } else {

                        // NEW MEMBER
                        $group->members()->create([
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

            return redirect()
                ->route('admin.dashboard')
                ->with('success', 'Group updated successfully.');
        }

    public function deleteGroup($id)
    {
        $group = Group::findOrFail($id);

        $group->delete();

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Group deleted successfully.');
    }
}
