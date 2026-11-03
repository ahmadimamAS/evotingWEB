@extends('siswa.layout')

@section('title', 'Dashboard Siswa - E-Voting OSIS')

@section('content')
<script>
    window.__PAGE_NAME__ = 'siswa-dashboard';
    window.__PAGE_PROPS__ = {!! json_encode([
        'sudahMemilih' => $sudahMemilih ?? false,
        'votingAktif' => $votingAktif ?? false,
        'siswa' => $siswa ?? null,
        'kandidatDipilih' => $kandidatDipilih ?? null,
        'routeVoting' => route('siswa.voting'),
    ]) !!};
</script>
@endsection

