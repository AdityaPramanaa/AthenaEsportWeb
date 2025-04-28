@extends('layouts.app')

@section('title', $game->name . ' - UKM Athena E-Sport')

@section('content')
<div class="container py-5">
    <div class="row section-reveal">
        <div class="col-lg-8 mx-auto">
            <div class="cyber-card">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <h1 class="cyber-text" data-text="{{ strtoupper($game->name) }}">{{ strtoupper($game->name) }}</h1>
                    </div>
                    
                    <div class="game-image-container mb-4">
                        <img src="{{ asset($game->image) }}" alt="{{ $game->name }}" class="img-fluid rounded cyber-glitch-1">
                        <div class="cyber-frame"></div>
                    </div>

                    <div class="game-description mb-4">
                        <p class="cyber-text-content">{{ $game->description }}</p>
                    </div>

                    <div class="text-center">
                        <a href="{{ route('home') }}" class="cyber-button">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .game-image-container {
        position: relative;
        overflow: hidden;
        border-radius: 15px;
    }

    .cyber-frame {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        border: 2px solid var(--primary-color);
        border-radius: 15px;
        pointer-events: none;
        animation: frameGlow 2s infinite;
    }

    @keyframes frameGlow {
        0% { box-shadow: 0 0 5px var(--primary-color); }
        50% { box-shadow: 0 0 20px var(--primary-color); }
        100% { box-shadow: 0 0 5px var(--primary-color); }
    }

    .game-description {
        font-size: 1.1rem;
        line-height: 1.8;
    }
</style>
@endpush 