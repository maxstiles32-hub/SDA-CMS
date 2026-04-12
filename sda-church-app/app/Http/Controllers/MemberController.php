<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Services\ExportService;

class MemberController extends Controller
{
    protected $exportService;

    public function __construct(ExportService $exportService)
    {
        $this->exportService = $exportService;
    }

    /**
     * Display a listing of the members.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $members = Member::when($search, function ($query, $search) {
                return $query->where('first_name', 'like', "%{$search}%")
                             ->orWhere('last_name', 'like', "%{$search}%")
                             ->orWhere('email', 'like', "%{$search}%")
                             ->orWhere('contact_number', 'like', "%{$search}%");
            })
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->paginate(15)
            ->withQueryString();

        return view('members.index', compact('members', 'search'));
    }

    /**
     * Show the form for creating a new member.
     */
    public function create()
    {
        $departments = \App\Models\Department::orderBy('name')->get();
        return view('members.create', compact('departments'));
    }

    /**
     * Store a newly created member in database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'nullable|date',
            'gender' => 'required|in:Male,Female',
            'email' => 'nullable|email|max:255|unique:members,email',
            'contact_number' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'baptism_date' => 'nullable|date',
            'status' => 'required|in:Active,Inactive,Transferred,Deceased',
            'departments' => 'nullable|array',
            'departments.*' => 'exists:departments,department_id',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = \Illuminate\Support\Arr::except($validated, ['departments', 'profile_picture']);
        
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('profile_pictures', $filename, 'public');
            $data['profile_picture'] = $path;
        }

        $member = Member::create($data);

        if (!empty($validated['departments'])) {
            $member->departments()->attach($validated['departments']);
        }

        return redirect()->route('members.index')->with('success', 'Member registered successfully.');
    }

    /**
     * Display the specified member.
     */
    public function show(Member $member)
    {
        // Load related data
        $member->load(['departments', 'tithes', 'donations', 'baptisms', 'transfers']);
        return view('members.show', compact('member'));
    }

    /**
     * Show the form for editing the specified member.
     */
    public function edit(Member $member)
    {
        $departments = \App\Models\Department::orderBy('name')->get();
        return view('members.edit', compact('member', 'departments'));
    }

    /**
     * Update the specified member in database.
     */
    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'nullable|date',
            'gender' => 'required|in:Male,Female',
            'email' => 'nullable|email|max:255|unique:members,email,' . $member->member_id . ',member_id',
            'contact_number' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'baptism_date' => 'nullable|date',
            'status' => 'required|in:Active,Inactive,Transferred,Deceased',
            'departments' => 'nullable|array',
            'departments.*' => 'exists:departments,department_id',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = \Illuminate\Support\Arr::except($validated, ['departments', 'profile_picture']);

        if ($request->hasFile('profile_picture')) {
            // Delete old picture if exists
            if ($member->profile_picture) {
                Storage::disk('public')->delete($member->profile_picture);
            }
            $file = $request->file('profile_picture');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('profile_pictures', $filename, 'public');
            $data['profile_picture'] = $path;
        }

        $member->update($data);

        if (isset($validated['departments'])) {
            $member->departments()->sync($validated['departments']);
        } else {
            $member->departments()->detach();
        }

        return redirect()->route('members.index')->with('success', 'Member updated successfully.');
    }

    /**
     * Remove the specified member from database.
     */
    public function destroy(Member $member)
    {
        $member->delete();

        return redirect()->route('members.index')->with('success', 'Member deleted successfully.');
    }

    /**
     * Export members to CSV.
     */
    public function export(Request $request)
    {
        $search = $request->input('search');

        $members = Member::when($search, function ($query, $search) {
                return $query->where('first_name', 'like', "%{$search}%")
                             ->orWhere('last_name', 'like', "%{$search}%")
                             ->orWhere('email', 'like', "%{$search}%")
                             ->orWhere('contact_number', 'like', "%{$search}%");
            })
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        $headers = ['Full Name', 'Gender', 'Phone', 'Email', 'Role', 'Status'];
        $data = [];

        foreach ($members as $member) {
            $data[] = [
                $member->first_name . ' ' . $member->last_name,
                $member->gender,
                $member->contact_number,
                $member->email,
                $member->role_in_church,
                $member->status
            ];
        }

        $filename = 'Members_Directory_' . date('Y-m-d') . '.csv';

        if ($request->query('format') === 'pdf') {
            return $this->exportService->exportPdf('members.pdf', compact('members'), 'Members_Directory_' . date('Y-m-d') . '.pdf');
        }

        return $this->exportService->exportCsv($filename, $headers, $data);
    }
}
