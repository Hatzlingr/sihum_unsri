@props(['status' => 'Pending'])

@php
    $normalized = strtolower((string) $status);
    $class = match (true) {
        str_contains($normalized, 'setuju') || str_contains($normalized, 'sudah') || str_contains($normalized, 'aktif') || str_contains($normalized, 'tersedia') || str_contains($normalized, 'kosong') => 'border-emerald-200 bg-emerald-50 text-emerald-700',
        str_contains($normalized, 'tolak') || str_contains($normalized, 'rusak') || str_contains($normalized, 'keluar') => 'border-red-200 bg-red-50 text-red-700',
        str_contains($normalized, 'belum') || str_contains($normalized, 'menunggu') || str_contains($normalized, 'pending') => 'border-amber-200 bg-amber-50 text-amber-700',
        str_contains($normalized, 'penuh') || str_contains($normalized, 'terisi') || str_contains($normalized, 'pindah') => 'border-slate-200 bg-slate-50 text-slate-700',
        str_contains($normalized, 'maintenance') || str_contains($normalized, 'perbaikan') => 'border-blue-200 bg-blue-50 text-blue-700',
        default => 'border-border-soft bg-bg-surface text-content-sub',
    };
@endphp

<span {{ $attributes->class("inline-flex items-center rounded-full border px-3 py-1 text-xs font-semibold {$class}") }}>
    {{ $status }}
</span>
