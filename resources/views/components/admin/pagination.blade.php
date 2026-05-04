@props(['paginator' => null])

<div {{ $attributes->class('mt-5') }}>
    @if ($paginator && method_exists($paginator, 'links'))
        {{ $paginator->withQueryString()->links() }}
    @else
        <div class="flex items-center gap-3">
            <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-bg-surface text-sm font-semibold text-content-main">1</span>
            <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-bg-surface text-sm font-semibold text-content-main">2</span>
        </div>
    @endif
</div>
