<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unit; 
use App\Models\User;
use App\Models\Role;
use App\Models\UnitUser; 
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CommunityUserController extends Controller
{
    use AuthorizesRequests;
    
    // Bagian List Divisions
    public function indexDivisions($name)
    {
        $unit = Unit::where('name', $name)
                    ->whereNull('parent_id')
                    ->firstOrFail();

        $divisions = $unit->children;

        if ($divisions->count() > 0) {
            return view('community_user.division', [
                'communityName' => $unit->name,
                'divisions' => $divisions
            ]);
        } else {
            return redirect()->route('member.list', $unit->name);
        }
    }

    // Bagian List Members
    public function indexMembers($name)
    {
        $unit = Unit::where('name', $name)->firstOrFail();

       $members = UnitUser::where('unit_id', $unit->id)
        ->join('roles', 'unit_user.role_id', '=', 'roles.id') // Join dengan tabel roles untuk akses nama jabatan
        ->select('unit_user.*') 
        ->with(['user', 'role'])
        ->orderByRaw("CASE 
            WHEN roles.name LIKE '%Ketua%' AND roles.name NOT LIKE '%Wakil%' THEN 1
            WHEN roles.name LIKE '%Wakil Ketua%' THEN 2
            WHEN roles.name LIKE '%Kepala Komunitas%' THEN 3
            WHEN roles.name LIKE '%Kepala Divisi%' THEN 4
            WHEN roles.name LIKE '%Sekretaris%' THEN 5
            WHEN roles.name LIKE '%Bendahara%' THEN 6
            WHEN roles.name LIKE '%Anggota%' THEN 7
            ELSE 6 
        END ASC")
        ->orderBy('unit_user.created_at', 'desc') // Urutan kedua berdasarkan waktu jika jabatan sama
        ->get();

        if ($unit->parent) {
            $backUrl = route('community.divisions', $unit->parent->name);
            $divisionName = $unit->parent->name;
        } else {
            $backUrl = route('dashboard');
            $divisionName = $unit->name;
        }

        return view('community_user.member', [
            'members' => $members,
            'name' => $unit->name,
            'divisionName' => $divisionName,
            'backUrl' => $backUrl,
            'currentUnitId' => $unit->id
        ]);
    }

    // Bagian Create Member
    public function create(Request $request)
    {
        $unitId = $request->query('unit_id');

        // 🔐 AUTHORIZATION (INI KUNCI)
        $this->authorize('create', [UnitUser::class, $unitId]);

        $users = User::all();
        $roles = Role::all();
        $communities = Unit::whereNull('parent_id')->with('children')->get();
        $divisions = Unit::whereNotNull('parent_id')->get();

        $selectedUnit = $unitId
            ? Unit::with('parent')->find($unitId)
            : null;

        return view(
            'community_user.create',
            compact('users', 'roles', 'communities', 'divisions', 'selectedUnit')
        );
    }

    // Bagian Store Member
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'unit_id' => 'required|exists:units,id',
            'role_id' => 'required|exists:roles,id',
        ]);

        $exists = UnitUser::where('user_id', $validated['user_id'])
                          ->where('unit_id', $validated['unit_id'])
                          ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Gagal! Mahasiswa sudah terdaftar di unit tersebut.');
        }

        UnitUser::create([
            'user_id' => $validated['user_id'],
            'unit_id' => $validated['unit_id'],
            'role_id' => $validated['role_id'],
        ]);

        $unit = Unit::findOrFail($validated['unit_id']);

        return redirect()->route('member.list', $unit->name)
                         ->with('success', 'Anggota berhasil ditambahkan!');
    }


    // Bagian Edit Member
    public function edit($id)
    {
        $member = UnitUser::findOrFail($id);

        // 🔐 AUTHORIZATION
        $this->authorize('update', $member);

        $users = User::all();
        $roles = Role::all();
        $communities = Unit::whereNull('parent_id')->with('children')->get();
        $divisions = Unit::whereNotNull('parent_id')->get();

        return view(
            'community_user.edit',
            compact('member', 'users', 'roles', 'communities', 'divisions')
        );
    }

    
    //Bagian Update Member
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'unit_id' => 'required|exists:units,id',
            'role_id' => 'required|exists:roles,id',
        ]);

        $member = UnitUser::findOrFail($id);
        $member->update([
            'unit_id' => $validated['unit_id'],
            'role_id' => $validated['role_id'],
        ]);

        $unit = Unit::findOrFail($validated['unit_id']);
        return redirect()->route('member.list', $unit->name)
                         ->with('success', 'Data anggota berhasil diperbarui!');
    }



    //Bagian Delete Member
    public function destroy($id)
    {
        $member = UnitUser::findOrFail($id);

        // 🔐 AUTHORIZATION
        $this->authorize('delete', $member);

        $unitName = $member->unit->name;

        $member->delete();

        return redirect()
            ->route('member.list', $unitName)
            ->with('success', 'Anggota berhasil dihapus.');
    }
    
}