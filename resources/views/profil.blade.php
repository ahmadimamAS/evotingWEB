@extends('layouts.app')

@section('title', 'Profil OSIS - E-Voting OSIS')

@section('content')
    <script>
        window.__PAGE_NAME__ = 'profil';
        window.__PAGE_PROPS__ = {!! json_encode([
            // halaman profil belum memakai data dari backend (placeholder)
        ]) !!};
    </script>
@endsection

