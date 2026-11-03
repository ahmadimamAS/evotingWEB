@extends('layouts.app')

@section('title', 'Kandidat - E-Voting OSIS')

@section('content')
<script>
    window.__PAGE_NAME__ = 'kandidat';
    window.__PAGE_PROPS__ = {!! json_encode([
        'kandidats' => $kandidats ?? [],
    ]) !!};
</script>
@endsection
