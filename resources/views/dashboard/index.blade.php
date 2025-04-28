@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row">
                        <!-- Upcoming Events -->
                        <div class="col-md-6 mb-4">
                            <h4>Event Mendatang</h4>
                            @if($upcomingEvents->count() > 0)
                                <div class="list-group">
                                    @foreach($upcomingEvents as $event)
                                        <a href="{{ route('events.show', $event->id) }}" class="list-group-item list-group-item-action">
                                            <h5 class="mb-1">{{ $event->title }}</h5>
                                            <small>
                                                {{ $event->start_date ? $event->start_date->format('d M Y') : '-' }}
                                            </small>
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <p>Tidak ada event mendatang</p>
                            @endif
                        </div>

                        <!-- My Events -->
                        <div class="col-md-6 mb-4">
                            <h4>Event Saya</h4>
                            @if($myEvents->count() > 0)
                                <div class="list-group">
                                    @foreach($myEvents as $event)
                                        <a href="{{ route('events.show', $event->id) }}" class="list-group-item list-group-item-action">
                                            <h5 class="mb-1">{{ $event->title }}</h5>
                                            <small>
                                                {{ $event->start_date ? $event->start_date->format('d M Y') : '-' }}
                                            </small>
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <p>Anda belum memiliki event</p>
                            @endif
                        </div>

                        <!-- My Certificates -->
                        <div class="col-md-6 mb-4">
                            <h4>Sertifikat Saya</h4>
                            @if($myCertificates->count() > 0)
                                <div class="list-group">
                                    @foreach($myCertificates as $certificate)
                                        <div class="list-group-item">
                                            <h5 class="mb-1">{{ $certificate->title }}</h5>
                                            <small>Diperoleh pada: {{ $certificate->created_at->format('d M Y') }}</small>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p>Anda belum memiliki sertifikat</p>
                            @endif
                        </div>

                        <!-- My Attendances -->
                        <div class="col-md-6 mb-4">
                            <h4>Kehadiran Saya</h4>
                            @if($myAttendances->count() > 0)
                                <div class="list-group">
                                    @foreach($myAttendances as $attendance)
                                        <div class="list-group-item">
                                            <h5 class="mb-1">{{ $attendance->event->title }}</h5>
                                            <small>Tanggal: {{ $attendance->created_at->format('d M Y') }}</small>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p>Anda belum memiliki riwayat kehadiran</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 