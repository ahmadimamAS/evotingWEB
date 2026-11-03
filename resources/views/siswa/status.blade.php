@extends('siswa.layout')

@section('title', 'Status Pemilihan - E-Voting OSIS')

@section('content')
<script>
    window.__PAGE_NAME__ = 'siswa-status';
    window.__PAGE_PROPS__ = {!! json_encode([
        'sudahMemilih' => $sudahMemilih ?? false,
        'votingAktif' => $votingAktif ?? false,
        'siswa' => $siswa ?? null,
        'voting' => $voting ?? null,
        'routeDashboard' => route('siswa.dashboard'),
        'routeVoting' => route('siswa.voting'),
    ]) !!};
</script>
@endsection

