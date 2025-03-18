<?php

namespace App\Http\Controllers\Member\Ticketing;

use App\Http\Controllers\Controller;
use App\Models\CompanyParameter;
use App\Models\Ticketing;
use Illuminate\Http\Request;

class MemberTicketingController extends Controller
{
    public function index(Request $request)
{
    $userId = auth()->id();

    // Query awal untuk mendapatkan tiket berdasarkan user login
    $query = Ticketing::where('user_id', $userId)
        ->orderBy('created_at', 'desc'); // Urutkan berdasarkan waktu pembuatan terbaru

    // Filter berdasarkan status
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    // Ambil data dengan pagination
    $ticketing = $query->paginate(10);

    return view('member.ticketing.index', compact('ticketing'));
}


    public function create()
    {
        return view('member.ticketing.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'service_type' => 'required|string|max:255',
            'submission_description' => 'required|string',
            'supporting_documents.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10048', // Validasi untuk setiap file
            'other_service_type' => 'nullable|string|max:255|required_if:service_type,Lainnya',
        ]);

        // Upload dokumen pendukung (jika ada)
        if ($request->hasFile('supporting_documents')) {
            $filePaths = [];
            foreach ($request->file('supporting_documents') as $file) {
                $destinationPath = public_path('ticketing/member/document');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move($destinationPath, $fileName);
                $filePaths[] = 'ticketing/member/document/' . $fileName;
            }
            $validatedData['supporting_document'] = json_encode($filePaths); // Simpan path file dalam bentuk JSON
        }

        if ($request->service_type === 'Lainnya') {
            $validatedData['service_type'] = $request->other_service_type;
        }

        // Tambahkan user_id untuk memastikan tiket terkait dengan pengguna yang login
        $validatedData['user_id'] = auth()->id();
        $validatedData['status'] = 'Open'; // Set default status menjadi "Open"

        // Simpan tiket
        Ticketing::create($validatedData);

        return redirect()->route('member.ticketing.index')->with('success', 'Tiket berhasil dibuat.');
    }


    public function edit($id)
    {
        $ticket = Ticketing::findOrFail($id);

        // Pastikan hanya tiket dengan status "Open" yang bisa diedit
        if ($ticket->status !== 'Open') {
            return redirect()->route('member.ticketing.index')->with('error', 'Hanya tiket dengan status Open yang dapat diedit.');
        }

        return view('member.ticketing.edit', compact('ticket'));
    }

    public function update(Request $request, $id)
    {
        $ticket = Ticketing::findOrFail($id);

        // Pastikan hanya tiket dengan status "Open" yang bisa diedit
        if ($ticket->status !== 'Open') {
            return redirect()->route('member.ticketing.index')->with('error', 'Hanya tiket dengan status Open yang dapat diedit.');
        }

        $validatedData = $request->validate([
            'service_type' => 'required|string|max:255',
            'submission_description' => 'required|string',
            'supporting_document.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048', // Validasi array file
        ]);

        $existingDocuments = $ticket->supporting_document ? json_decode($ticket->supporting_document, true) : [];

        // Upload dokumen pendukung baru (jika ada)
        if ($request->hasFile('supporting_document')) {
            foreach ($request->file('supporting_document') as $file) {
                $destinationPath = public_path('ticketing/member/document');
                $fileName = time() . '_' . $file->getClientOriginalName();

                // Pindahkan file ke public_path
                $file->move($destinationPath, $fileName);

                // Tambahkan ke array dokumen yang ada
                $existingDocuments[] = 'ticketing/member/document/' . $fileName;
            }
        }

        // Simpan dokumen baru ke JSON
        $validatedData['supporting_document'] = json_encode($existingDocuments);

        // Perbarui tiket
        $ticket->update($validatedData);

        return redirect()->route('member.ticketing.index')->with('success', 'Tiket berhasil diperbarui.');
    }






    public function show($id)
    {
        // Temukan tiket berdasarkan ID
        $ticket = Ticketing::findOrFail($id);

        $umalo = CompanyParameter::first();
    
        // Pastikan tiket hanya dapat diakses oleh pemiliknya (opsional, untuk keamanan)
        if ($ticket->user_id !== auth()->id()) {
            return redirect()->route('member.ticketing.index')->with('error', 'Anda tidak memiliki akses ke tiket ini.');
        }
    
        // Set is_viewed_member menjadi true
        if (!$ticket->is_viewed_member) {
            $ticket->is_viewed_member = true;
            $ticket->save();
        }
    
        // Tampilkan halaman detail tiket
        return view('member.ticketing.show', compact('ticket','umalo'));
    }
    



    public function cancel($id)
    {
        $ticket = Ticketing::findOrFail($id);

        // Periksa apakah statusnya masih Open
        if ($ticket->status !== 'Open') {
            return redirect()->back()->with('error', 'Hanya tiket dengan status Open yang dapat dibatalkan.');
        }

        // Ubah status menjadi Batal
        $ticket->status = 'Batal';
        $ticket->is_viewed_admin = false;
        $ticket->save();

        return redirect()->route('member.ticketing.index')->with('success', 'Tiket berhasil dibatalkan.');
    }


    public function removeDocument(Request $request, $ticketId, $documentIndex)
    {
        $ticket = Ticketing::findOrFail($ticketId);
    
        // Pastikan hanya pengguna terkait yang dapat menghapus dokumen
        if ($ticket->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Anda tidak memiliki izin untuk menghapus dokumen ini.'], 403);
        }
    
        $documents = $ticket->supporting_document ? json_decode($ticket->supporting_document, true) : [];
    
        // Periksa apakah indeks dokumen valid
        if (isset($documents[$documentIndex])) {
            $documentPath = public_path($documents[$documentIndex]);
    
            // Hapus file dari storage jika ada
            if (file_exists($documentPath)) {
                unlink($documentPath);
            }
    
            // Hapus dokumen dari array
            unset($documents[$documentIndex]);
    
            // Perbarui database
            $ticket->supporting_document = json_encode(array_values($documents)); // Reset indeks array
            $ticket->save();
    
            return response()->json(['success' => true, 'message' => 'Dokumen berhasil dihapus.']);
        }
    
        return response()->json(['success' => false, 'message' => 'Dokumen tidak ditemukan.'], 404);
    }
    
    


    
    
}
