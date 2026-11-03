@extends('layouts.app')

@section('title', 'Informasi Pemilihan - E-Voting OSIS')

@section('content')
<script>
    window.__PAGE_NAME__ = 'informasi';
    window.__PAGE_PROPS__ = {!! json_encode([
        'waktuMulai' => $waktuMulai,
        'waktuSelesai' => $waktuSelesai,
        'votingAktif' => $votingAktif,
    ]) !!};
</script>
@endsection
