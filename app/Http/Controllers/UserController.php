<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Group;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return back()
                ->withErrors([
                    'email' => 'This email is not registered.',
                ])
                ->withInput($request->only('email'));
        }

        if (!Hash::check($credentials['password'], $user->password)) {
            return back()
                ->withErrors([
                    'password' => 'The password is incorrect.',
                ])
                ->withInput($request->only('email'));
        }

        Auth::login($user);

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                
                if (Auth::user()->role === 'admin') {
                    return redirect()->route('admin.dashboard');
                    }
                    
                return redirect()->route('dashboard');
                    
                }
    }




    public function showRegister()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'department' => 'required|string|max:255',
            'degree' => 'required|string|max:255',
            'batch' => 'required|integer',
            'session' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'teacher_id' => 'required|string|unique:users,teacher_id',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required|same:password',
        ]);

        // Every person registering through this form is a teacher
        $validated['role'] = 'teacher';

        $user = User::create($validated);

        return redirect()->route('login')
        ->with('success', 'Registration successful. Please login.');

    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }


    public function form()
    {
        return view('form');
    }

    public function teacherDashboard()
    {
        $groups = Group::with('members')
            ->withCount('members')
            ->where('supervisor_id', auth()->id())
            ->get();

        return view('teacher.dashboard', compact('groups'));
    }

    public function editGroup($id)
    {
        $group = Group::with('members')
            ->where('supervisor_id', auth()->id())
            ->findOrFail($id);

        $teachers = User::where('role', 'teacher')->get();

        return view('teacher.edit-group', compact('group', 'teachers'));
    }

    public function updateGroup(Request $request, $id)
    {
        $group = Group::with('members')
            ->where('supervisor_id', auth()->id())
            ->findOrFail($id);

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


        DB::transaction(function () use ($group, $validated) {

            $group->update([
                'group_name' => $validated['group_name'],
                'thesis_title' => $validated['thesis_title'],
                'supervisor_id' => $validated['supervisor'],
            ]);

            if (!empty($validated['removed_members'])) {

                $group->members()
                    ->whereIn('id', $validated['removed_members'])
                    ->delete();
            }

            foreach ($validated['members'] as $memberData) {

                if (isset($memberData['id'])) {

                    $member = $group->members()
                        ->where('id', $memberData['id'])
                        ->first();

                    if (!$member) {
                        continue;
                    }

                    $member->update([
                        'name' => $memberData['name'],
                        'student_id' => $memberData['student_id'],
                        'batch' => $memberData['batch'],
                        'session' => $memberData['session'],
                        'department' => $memberData['department'],
                        'role' => $memberData['role'],
                    ]);
                }

                else {

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
            ->route('dashboard')
            ->with('success', 'Group updated successfully.');
    }

    public function deleteGroup($id)
    {
        $group = Group::where('supervisor_id', auth()->id())
            ->findOrFail($id);
        $group->members()->delete();
        $group->delete();
        return redirect()
            ->route('dashboard')
            ->with( 'success', 'Group deleted successfully.');
    }
}
