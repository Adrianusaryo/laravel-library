<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class Leaderboard extends Controller
{
    public function showLeaderboardDewasa()
    {
        $users = User::role('member')
            ->withCount('peminjaman')
            ->orderByDesc('poin')
            ->get();

        foreach ($users as $index => $user) {
            $user->rank = $index + 1;

            if ($index === 0) $user->badge = 'Gold';
            elseif ($index === 1) $user->badge = 'Silver';
            elseif ($index === 2) $user->badge = 'Bronze';
            else $user->badge = null;
        }

        return response(['data' => $users, 'status' => '200', 'message' => 'Leaderboard User Berhasil Ditampilkan']);
    }
}
