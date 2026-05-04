@props(['headers' => []])

<div {{ $attributes->class('overflow-hidden rounded-3xl border border-border-soft bg-bg-base shadow-sm') }}>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-border-soft text-left text-sm">
            @if (count($headers))
                <thead class="bg-bg-surface text-xs font-semibold uppercase tracking-wide text-content-sub">
                    <tr>
                        @foreach ($headers as $header)
                            <th scope="col" class="whitespace-nowrap px-5 py-4">{{ $header }}</th>
                        @endforeach
                    </tr>
                </thead>
            @endif
            <tbody class="divide-y divide-border-soft bg-bg-base">
                {{ $slot }}
            </tbody>
        </table>
    </div>
</div>
