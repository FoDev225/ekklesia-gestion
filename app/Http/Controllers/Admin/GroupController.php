<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Believer;
use App\Models\Group;

use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\GroupMembersExport;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $groups = Group::withCount('believers')->latest()->paginate(10);
        $totalGroups = Group::count();
        $totalAssignments = \DB::table('believer_groups')->count();
        $topGroups = Group::withCount('believers')
            ->orderByDesc('believers_count')
            ->take(5)
            ->get();

        return view('admin.groups.index', compact(
            'groups', 
            'totalGroups', 
            'totalAssignments', 
            'topGroups'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.groups.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:groups,name',
            'type_gp' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        Group::create($request->only('name', 'type_gp', 'description'));

        return redirect()->route('admin.groups.index')->with('success', 'Groupe créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Group $group)
    {
        $query = $group->believers()->withPivot('role', 'joined_at');

        // FILTRE RECHERCHE
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('lastname', 'like', "%{$search}%")
                ->orWhere('firstname', 'like', "%{$search}%");
            });
        }

        // FILTRE SEXE
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        // FILTRE ROLE
        if ($request->filled('role')) {
            $query->wherePivot('role', $request->role);
        }

        $members = $query->orderBy('lastname')->orderBy('firstname')->paginate(10)->withQueryString();

        // Fidèles non encore affectés à ce groupe
        $availableBelievers = Believer::whereDoesntHave('groups', function ($q) use ($group) {
            $q->where('groups.id', $group->id);
        })
        ->orderBy('lastname')
        ->orderBy('firstname')
        ->get();

        // Liste des rôles existants dans ce groupe (pour le filtre)
        $roles = $group->believers()
            ->whereNotNull('believer_groups.role')
            ->distinct()
            ->pluck('believer_groups.role');

        return view('admin.groups.show', compact(
            'group',
            'availableBelievers',
            'members',
            'roles'
        ));
    }

    public function assignBeliever(Request $request, Group $group)
    {
        $request->validate([
            'believer_id' => 'required|exists:believers,id',
            'role' => 'nullable|string|max:100',
            'joined_at' => 'nullable|date',
        ]);

        $alreadyAssigned = $group->believers()->where('believer_id', $request->believer_id)->exists();

        if ($alreadyAssigned) {
            return back()->with('warning', 'Ce fidèle est déjà affecté à ce groupe.');
        }

        $group->believers()->attach($request->believer_id, [
            'role' => $request->role,
            'joined_at' => $request->joined_at,
        ]);

        return back()->with('success', 'Le fidèle a été affecté au groupe avec succès.');
    }

    public function removeBeliever(Group $group, Believer $believer)
    {
        $group->believers()->detach($believer->id);

        return back()->with('success', 'Le fidèle a été retiré du groupe avec succès.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Group $group)
    {
        return view('admin.groups.edit', compact('group'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Group $group)
     {
        $request->validate([
            'name' => 'required|string|max:255|unique:groups,name,' . $group->id,
            'type_gp' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $group->update($request->only('name', 'type_gp', 'description'));

        return redirect()->route('admin.groups.index')->with('success', 'Groupe mis à jour avec succès.');
    }

    public function exportMembersExcel(Request $request, Group $group)
    {
        return Excel::download(
            new GroupMembersExport($group, $request->only(['search', 'gender', 'role'])),
            'membres_groupe_' . \Str::slug($group->name) . '.xlsx'
        );
    }

    public function exportMembersPdf(Request $request, Group $group)
    {
        $query = $group->believers()->withPivot('role', 'joined_at');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('lastname', 'like', "%{$search}%")
                ->orWhere('firstname', 'like', "%{$search}%");
            });
        }

        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        if ($request->filled('role')) {
            $query->wherePivot('role', $request->role);
        }

        $members = $query->orderBy('lastname')->orderBy('firstname')->get();

        $pdf = Pdf::loadView('admin.groups.members_pdf', compact('group', 'members'))
            ->setPaper('A4', 'portrait');

        return $pdf->download('membres_groupe_' . \Str::slug($group->name) . '.pdf');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        $group->believers()->detach();
        $group->delete();

        return redirect()
            ->route('admin.groups.index')
            ->with('success', 'Le groupe a été supprimé avec succès.');
    }
}
