<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Visitor;
use Illuminate\Support\Carbon;

class TrackVisitors
{
    public function handle($request, Closure $next)
    {
        $ipAddress = $request->ip();
        $browser = $request->header('User-Agent');
        $now = Carbon::now();  // Waktu saat ini

        // Cari kunjungan terakhir berdasarkan IP dan browser
        $lastVisit = Visitor::where('ip_address', $ipAddress)
                            ->where('browser', $browser)
                            ->orderBy('last_visited', 'desc')
                            ->first();

        if (!$lastVisit || $now->diffInMinutes($lastVisit->last_visited) >= 60) {
            // Jika belum ada kunjungan sebelumnya atau sudah lebih dari 60 menit, catat kunjungan baru
            Visitor::create([
                'ip_address' => $ipAddress,
                'browser' => $browser,
                'last_visited' => $now,  // Atur waktu kunjungan terakhir ke saat ini
            ]);
        }

        return $next($request);
    }
}
