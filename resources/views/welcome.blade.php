@extends('layouts.app')

@section('title', 'Beranda - E-Voting OSIS')

@section('content')
<script>
    window.__PAGE_NAME__ = 'welcome';
    window.__PAGE_PROPS__ = {!! json_encode([
        'kandidats' => $kandidats ?? [],
        'votingAktif' => $votingAktif ?? null,
        'votingSelesai' => $votingSelesai ?? null,
        'stats' => [
            'totalSiswa' => \App\Models\Siswa::count(),
            'sudahMemilih' => \App\Models\Voting::distinct('siswa_id')->count('siswa_id'),
            'kandidat' => \App\Models\Kandidat::count(),
        ],
    ]) !!};
</script>

<script>
    window.__PAGE_NAME__ = 'welcome';
    window.__PAGE_PROPS__ = {!! json_encode([
        'kandidats' => $kandidats ?? [],
        'votingAktif' => $votingAktif ?? null,
        'votingSelesai' => $votingSelesai ?? null,
        'stats' => [
            'totalSiswa' => \App\Models\Siswa::count(),
            'sudahMemilih' => \App\Models\Voting::distinct('siswa_id')->count('siswa_id'),
            'kandidat' => \App\Models\Kandidat::count(),
        ],
    ]) !!};
</script>
@endsection

