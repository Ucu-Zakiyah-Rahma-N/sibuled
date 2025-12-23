<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\CeklisPerizinan;
use App\Models\ProjectCeklisExclude;
use App\Models\VerifikasiProject;
use App\Models\PO;
use App\Models\Quotation;
use Carbon\Carbon;
use App\Models\ProjectTahapan;
use App\Models\ProjectPerizinan;
use Dom\Attr;
use Illuminate\Support\Facades\Auth;

class VerifikasiController extends Controller
{
    //index ini untuk update kolom2 collect dokumen
public function index($projectId)
{
    $project = Project::with([
        'project_perizinan.perizinan',
        'project_tahapan.tahapan',
        'ceklisExclude' // pastikan relasi ada
    ])->findOrFail($projectId);

    $perizinanIds = $project->project_perizinan->pluck('perizinan_id')->toArray();

    // ambil yang di-exclude untuk project ini (ceklis_perizinan_id)
    $excludedIds = $project->ceklisExclude
                        ->where('is_active', 0)
                        ->pluck('ceklis_perizinan_id')
                        ->toArray();

    $results = [];
    foreach ($project->project_tahapan as $pt) {
        $target = $pt->persentase_target ?? 0;

        // total semua dokumen (mengabaikan excluded)
        $total = CeklisPerizinan::whereIn('perizinan_id', $perizinanIds)
            ->when(count($excludedIds), function($q) use ($excludedIds) {
                $q->whereNotIn('id', $excludedIds);
            })
            ->count();

        // dokumen yang sudah diverifikasi di tabel verifikasi_project (juga mengabaikan excluded)
        $verified = VerifikasiProject::where('project_id', $project->id)
            ->where('tahapan_id', $pt->tahapan_id)
            ->where('verified', 1)
            ->when(count($excludedIds), function($q) use ($excludedIds) {
                $q->whereNotIn('ceklis_perizinan_id', $excludedIds);
            })
            ->count();

        $persentaseActual = $total > 0 ? ($verified / $total) * 100 : 0;
        $nilaiRealisasi = ($persentaseActual / 100) * $target;

        $results[] = [
            'nama_tahapan' => $pt->tahapan->nama_tahapan ?? '-',
            'target' => $target,
            'total' => $total,
            'verified' => $verified,
            'persentaseActual' => round($persentaseActual, 2),
            'nilaiRealisasi' => round($nilaiRealisasi, 2),
        ];
    }

    $totalProgress = collect($results)->sum('nilaiRealisasi');

    // $deadlineProject = $this->hitungDeadlineProject($project);

    return view('pages.projects.verifikasi', compact(
        'project',
        'results',
        'totalProgress'
        // 'deadlineProject'
    ));
}

public function verifikasiDokumen($projectPerizinanId, $ceklisId, Request $request)
{
    $user = Auth::user();

    try {
        $projectPerizinan = \App\Models\ProjectPerizinan::findOrFail($projectPerizinanId);
        $project = $projectPerizinan->project;
        $tahapanId = $request->input('tahapan_id');

        if (!$tahapanId) {
            return response()->json([
                'success' => false,
                'message' => 'Tahapan ID tidak ditemukan.'
            ], 400);
        }

        // CEK DUPLIKASI VERIFIKASI
        $sudahAda = VerifikasiProject::where('project_id', $project->id)
            // ->where('project_perizinan_id', $projectPerizinan->id) // ini rawan kesalahan
            ->where('ceklis_perizinan_id', $ceklisId)
            ->where('tahapan_id', $tahapanId)
            ->exists();

        if ($sudahAda) {
            return response()->json([
                'success' => false,
                'message' => 'Dokumen sudah diverifikasi sebelumnya.'
            ], 400);
        }

        // SIMPAN VERIFIKASI
        VerifikasiProject::create([
            'project_id'            => $project->id,
            'project_perizinan_id'  => $projectPerizinan->id,
            'ceklis_perizinan_id'   => $ceklisId,
            'tahapan_id'            => $tahapanId,
            'verified'              => 1,
            'verified_at'           => now(),
            'verified_by'           => $user->id,
        ]);

        // SET ACTUAL_START (jika verifikasi pertama untuk tahapan itu)
        $projectTahapan = \App\Models\ProjectTahapan::where('project_id', $project->id)
            ->where('tahapan_id', $tahapanId)
            ->first();

        if ($projectTahapan && is_null($projectTahapan->actual_start)) {
            $projectTahapan->actual_start = now();
            $projectTahapan->save();
        }


        // ==== HITUNG PROGRESS COLLECT DOKUMEN ====
        $excludedIds = \App\Models\ProjectCeklisExclude::where('project_id', $project->id)
            ->where('is_active', 0)
            ->pluck('ceklis_perizinan_id')
            ->toArray();

        // Total dokumen aktif untuk semua perizinan project (yang termasuk perizinan project)
        $perizinanIds = ProjectPerizinan::where('project_id', $project->id)
            ->pluck('perizinan_id');

        // Dokumen yang di-exclude di project ini

        // $totalDoc = \App\Models\CeklisPerizinan::where('perizinan_id', $projectPerizinan->perizinan_id)
        //     ->whereNotIn('id', $excludedIds)
        //     ->count();
        // $totalDoc = CeklisPerizinan::whereIn('perizinan_id', $perizinanIds)
        //     ->when(count($excludedIds), fn($q) => $q->whereNotIn('id', $excludedIds))
        //     ->count();

        $totalDoc = CeklisPerizinan::where('perizinan_id', $projectPerizinan->perizinan_id)
            ->when(count($excludedIds), fn($q) => $q->whereNotIn('id', $excludedIds))
            ->count();

        $verifiedDoc = VerifikasiProject::where('project_id', $project->id)
            ->where('project_perizinan_id', $projectPerizinan->id)// ini rawan kesalahan
            ->where('tahapan_id', $tahapanId)
            ->where('verified', 1)
            // ->whereNotIn('ceklis_perizinan_id', $excludedIds)
            ->when(count($excludedIds), fn($q) => $q->whereNotIn('ceklis_perizinan_id', $excludedIds))
            ->count();
        
        $target = $projectTahapan->persentase_target ?? 0;
        $persenActual = $totalDoc > 0 ? round(($verifiedDoc / $totalDoc) * 100, 2) : 0;
        $nilaiRealisasi = round(($persenActual * $target) / 100, 2);


        // SET ACTUAL_END (jika tahapan sudah mencapai target 100%)
        if ($totalDoc > 0 &&  $verifiedDoc >= $totalDoc && $projectTahapan && is_null($projectTahapan->actual_end)) {
            $projectTahapan->actual_end = now();
            $projectTahapan->save();
        }

        //hitung deadlin erealtime
        $po = $project->po;

        $quotation = Quotation::find($po->quotation_id);

        $lamaPekerjaan = (int) ($quotation->lama_pekerjaan ?? 0);

        // setelah update progress dan cek tahapan selesai
                // CASE 1 — COLLECT DOKUMEN ADA & SUDAH 100%
        $collectTahapan = ProjectTahapan::where('project_id', $project->id)
            ->whereHas('tahapan', fn($q) => $q->where('nama_tahapan', 'LIKE', '%Collect Dokumen%'))
            ->first();

            $deadlineProject = null;

            if ($collectTahapan && $collectTahapan->actual_end) {
            // Hanya hitung deadline jika actual_end ada
            $deadlineProject = Carbon::parse($collectTahapan->actual_end)->addDays($lamaPekerjaan);
        }

    $sisaHari = null;
    if ($deadlineProject) {
        $sisaHari = now()->diffInDays($deadlineProject, false);

            $sisaHari = round($sisaHari);

    }


        // // MULAI HITUNG DEADLINE PROJECT
        // $this->startProjectDeadline($project);

        return response()->json([
            'success' => true,
            'message' => 'Dokumen berhasil diverifikasi.',
            'verified_now' => $verifiedDoc,
            'total_doc' => $totalDoc,
            'persen_actual' => $persenActual,
            'nilai_realisasi' => $nilaiRealisasi,
            'tahapan_id' => $tahapanId,   // wajib
            'verified_at' => now()->toDateString(),
            'rencana_end' => $projectTahapan->rencana_end ? Carbon::parse($projectTahapan->rencana_end)->toDateString() : null,
            'deadline_project' => $deadlineProject ? $deadlineProject->toDateString() : null,
            'sisa_hari' => $sisaHari,


        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
        ], 500);
    }
}

public function exclude(Request $request)
{
    $status = ProjectCeklisExclude::updateOrCreate(
        [
            'project_id' => $request->project_id,
            'project_perizinan_id' => $request->project_perizinan_id,
            'ceklis_perizinan_id' => $request->ceklis_perizinan_id,
        ],
        [
            'is_active' => $request->is_active
        ]
    );

    // ==== Hitung kembali progress (project-wide per tahapan) =====
    $project = Project::find($request->project_id);
    $perizinanIds = $project->project_perizinan->pluck('perizinan_id')->toArray();

    $excludedIds = ProjectCeklisExclude::where('project_id', $request->project_id)
        ->where('is_active', 0)
        ->pluck('ceklis_perizinan_id')
        ->toArray();

    // Total dokumen aktif untuk seluruh perizinan project
    $totalDoc = CeklisPerizinan::whereIn('perizinan_id', $perizinanIds)
        ->when(count($excludedIds), fn($q) => $q->whereNotIn('id', $excludedIds))
        ->count();
    
    // Verified dokumen aktif untuk tahapan yang dikirim (project-wide)
    $tahapanId = $request->tahapan_id; // wajib dikirim dari JS
    // Verified dok yang masih aktif
    $verifiedDoc = VerifikasiProject::where('project_id', $request->project_id)
        ->where('tahapan_id', $tahapanId)
        ->where('verified', 1)
        ->when(count($excludedIds), fn($q) => $q->whereNotIn('ceklis_perizinan_id', $excludedIds))
        ->count();

        // ambil ProjectTahapan (buat target)
    $projectTahapan = ProjectTahapan::where('project_id', $request->project_id)
        ->where('tahapan_id', $tahapanId)
        ->first();

    $target = $projectTahapan->persentase_target ?? 0;

    $persenActual = $totalDoc > 0 ? round(($verifiedDoc / $totalDoc) * 100, 2) : 0;
    $nilaiRealisasi = round(($persenActual * $target) / 100, 2);
    
        // Jika tahapan selesai (verified >= total) set actual_end (opsional)
    if ($totalDoc > 0 && $verifiedDoc >= $totalDoc && $projectTahapan && is_null($projectTahapan->actual_end)) {
        $projectTahapan->actual_end = now();
        $projectTahapan->save();
    }

    
    return response()->json([
        'success' => true,
        'message' => 'Status updated successfully',
        'is_active' => $status->is_active,
        'verified_now' => $verifiedDoc,
        'total_doc' => $totalDoc,
        'persen_actual' => $persenActual,
        'nilai_realisasi' => $nilaiRealisasi,
        'tahapan_id' => $tahapanId   // harus ada

    ]);
}

public function verifikasiTahapan(Request $request, $tahapanId)
{
    $tahapan = \App\Models\ProjectTahapan::findOrFail($tahapanId);
    $project = $tahapan->project;

    // CEK PROGRESS (sub tahapan atau langsung)
    $subList = \App\Models\SubTahapan::where('tahapan_id', $tahapan->tahapan_id)->get();

    if ($subList->count() > 0) {
        // Ada sub-tahapan → semua harus 100%
        foreach ($subList as $sub) {
            $last = \App\Models\ProjectTahapanProgress::where('project_tahapan_id', $tahapan->id)
                        ->where('sub_tahapan_id', $sub->id)
                        ->latest('tanggal_update')
                        ->value('persentase_actual') ?? 0;

            if ($last < 100) {
                return response()->json([
                    'success' => false,
                    'message' => "Sub-tahapan '{$sub->nama_sub}' belum 100%.",
                ], 400);
            }
        }
    } else {
        // Tanpa sub → persentase_actual tahapan harus 100
        $last = \App\Models\ProjectTahapanProgress::where('project_tahapan_id', $tahapan->id)
                    ->latest('tanggal_update')
                    ->value('persentase_actual') ?? 0;

        if ($last < 100) {
            return response()->json([
                'success' => false,
                'message' => "Progress tahapan belum mencapai 100%.",
            ], 400);
        }
    }

    // CEK DUPLIKASI VERIFIKASI
    $sudahVerif = \App\Models\VerifikasiProject::where('project_id', $project->id)
                    ->where('tahapan_id', $tahapan->tahapan_id)
                    ->exists();

    if ($sudahVerif) {
        return response()->json([
            'success' => false,
            'message' => "Tahapan ini sudah diverifikasi sebelumnya.",
        ], 400);
    }

    // SIMPAN KE TABEL verifikasi_project
    $projectPerizinan = \App\Models\ProjectPerizinan::where('project_id', $project->id)->first();

    \App\Models\VerifikasiProject::create([
        'project_id'            => $project->id,
        'project_perizinan_id'  => $projectPerizinan->id,
        'ceklis_perizinan_id'   => null,
        'tahapan_id'            => $tahapan->tahapan_id,   
        'verified'              => 1,
        'verified_at'           => now(),
        'verified_by'           => Auth::id(),
    ]);

    return response()->json([
        'success' => true,
        'message' => "Tahapan berhasil diverifikasi!",
        'verified_at' => now()->toDateString(),
        'rencana_end' => $tahapan->rencana_end ? Carbon::parse($tahapan->rencana_end)->toDateString() : null,

    ]);
}

}