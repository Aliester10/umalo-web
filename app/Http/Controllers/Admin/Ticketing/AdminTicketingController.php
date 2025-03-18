<?php

namespace App\Http\Controllers\Admin\Ticketing;

use App\Http\Controllers\Controller;
use App\Models\Ticketing;
use App\Models\TicketingRequestData;
use Illuminate\Http\Request;

class AdminTicketingController extends Controller
{
    public function index(Request $request)
    {
        // Mulai query dengan model Ticketing
        $query = Ticketing::query()->orderBy('created_at', 'desc'); // Urutkan berdasarkan waktu pembuatan terbaru
    
        // Filter berdasarkan status (jika ada parameter status di request)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
    
        // Tambahkan pagination
        $ticketing = $query->paginate(10);
    
        // Return view dengan data tiket
        return view('admin.ticketing.index', compact('ticketing'));
    }
    

    public function updateStatus(Request $request, $id)
    {
        $ticket = Ticketing::findOrFail($id);

        if ($ticket->status === 'Open' && $request->status === 'Progress') {
            $validatedData = $request->validate([
                'technician' => 'required|string',
            ]);
    
            $ticket->update([
                'status' => 'Progress',
                'is_viewed_member' => false,
                'is_viewed_admin' => true,
                'action_start_date' => now(),
                'technician' => $validatedData['technician'],
            ]);
    
            return redirect()->route('admin.ticketing.index')->with('success', 'Tiket berhasil diperbarui ke status Progress.');
        }
    

        if ($ticket->status === 'Progress' && $request->status === 'Close') {
            $validatedData = $request->validate([
                'action_description' => 'required|string',
                'action_document.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10048', // Validasi untuk setiap file
                'action_close_date' => now(),
            ]);
            

            // Upload dokumen tindakan (jika ada)
            if ($request->hasFile('action_document')) {
                $filePaths = [];
                foreach ($request->file('action_document') as $file) {
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $destinationPath = public_path('ticketing/admin/action_documents');
                    
                    // Pindahkan file ke public_path
                    $file->move($destinationPath, $fileName);
                    
                    // Simpan path ke dalam array
                    $filePaths[] = 'ticketing/admin/action_documents/' . $fileName;
                }
                $validatedData['action_document'] = json_encode($filePaths); // Simpan sebagai JSON
            }
            

            // Update status ke Close dan simpan deskripsi tindakan
            $ticket->update(array_merge($validatedData, [
                'status' => 'Close',
                'action_close_date' => now(),
                'is_viewed_member' => false,
            ]));

            return redirect()->route('admin.ticketing.index')->with('success', 'Tiket berhasil diperbarui ke status Close.');
        }

        return redirect()->route('admin.ticketing.index')->with('error', 'Aksi tidak valid untuk status tiket ini.');
    }

    public function markAsViewed($id)
    {
        $ticket = Ticketing::findOrFail($id);

        // Perbarui is_viewed_admin menjadi true
        $ticket->is_viewed_admin = true;
        $ticket->save();

        return response()->json([
            'success' => true,
            'message' => 'Tiket telah ditandai sebagai dilihat.'
        ]);
    }

    public function sendRequestData(Request $request, $id)
    {
        $ticket = Ticketing::findOrFail($id);

        // Periksa apakah jenis layanan adalah "Permintaan Data"
        if ($ticket->service_type !== 'Permintaan Data') {
            return redirect()->back()->with('error', 'Tiket ini bukan tipe Permintaan Data.');
        }

        // Validasi data input
        $validated = $request->validate([
            'document_name' => 'required|string|max:255',
            'document_path.*' => 'required|file|mimes:pdf,docx,xlsx|max:10240', // Maksimal 10 MB
            'action_description' => 'required|string',
            'action_document.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10048', // Validasi untuk setiap file
        ]);

        // Array untuk menyimpan path file
        $documentPaths = [];
        if ($request->hasFile('document_path')) {
            foreach ($request->file('document_path') as $file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $destinationPath = public_path('ticketing/member/reqdocument');
                $file->move($destinationPath, $fileName);
                $documentPaths[] = 'ticketing/member/reqdocument/' . $fileName; // Path relatif
            }
        }

        // Simpan dokumen tindakan tambahan (jika ada)
        $actionDocuments = [];
        if ($request->hasFile('action_document')) {
            foreach ($request->file('action_document') as $actionFile) {
                $actionFileName = time() . '_' . $actionFile->getClientOriginalName();
                $actionFile->move(public_path('ticketing/member/action_documents'), $actionFileName);
                $actionDocuments[] = 'ticketing/member/action_documents/' . $actionFileName;
            }
        }

        // Simpan data ke tabel TicketingRequestData untuk setiap dokumen
        foreach ($documentPaths as $path) {
            TicketingRequestData::create([
                'ticketing_id' => $ticket->id,
                'document_name' => $validated['document_name'], // Nama dokumen sama untuk setiap path
                'document_path' => $path, // Path relatif
                'is_viewed_member' => false,
            ]);
        }

        // Update status tiket menjadi 'Close' atau sesuai kebutuhan
        $ticket->update([
            'status' => 'Close',
            'action_description' => $validated['action_description'],
            'action_document' => !empty($actionDocuments) ? json_encode($actionDocuments) : null,
            'action_close_date' => now(),
            'is_viewed_member' => false,
        ]);

        return redirect()->back()->with('success', 'Data berhasil dikirim ke member.');
    }






}