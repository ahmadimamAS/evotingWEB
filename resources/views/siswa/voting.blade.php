@extends('siswa.layout')

@section('title', 'Voting - E-Voting OSIS')

@section('content')
<script>
    window.__PAGE_NAME__ = 'siswa-voting';
    window.__PAGE_PROPS__ = {!! json_encode([
        'kandidats' => $kandidats ?? [],
        'routeDashboard' => route('siswa.dashboard'),
        'routeVotingStore' => route('siswa.voting.store'),
    ]) !!};
</script>
@endsection

