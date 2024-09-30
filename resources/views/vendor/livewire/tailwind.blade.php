@php
if (! isset($scrollTo)) {
    $scrollTo = 'body';
}

$scrollIntoViewJsSnippet = ($scrollTo !== false)
    ? <<<JS
       (\$el.closest('{$scrollTo}') || document.querySelector('{$scrollTo}')).scrollIntoView({ behavior: 'smooth' })
    JS
    : '';
@endphp

<div class="w-full max-w-4xl mx-auto">
    @if ($paginator->hasPages())
        <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-between items-center my-8">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="relative inline-flex items-center px-6 py-3 text-sm font-medium text-gray-400 bg-gray-100 rounded-full transition duration-300 ease-in-out cursor-not-allowed dark:bg-gray-700 dark:text-gray-500">
                    {!! __('pagination.previous') !!}
                </span>
            @else
                @if(method_exists($paginator,'getCursorName'))
                    <button type="button" dusk="previousPage" wire:key="cursor-{{ $paginator->getCursorName() }}-{{ $paginator->previousCursor()->encode() }}" wire:click="setPage('{{$paginator->previousCursor()->encode()}}','{{ $paginator->getCursorName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" wire:loading.attr="disabled" class="relative inline-flex items-center px-6 py-3 text-sm font-medium text-white bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full transition duration-300 ease-in-out hover:from-blue-600 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                        {!! __('pagination.previous') !!}
                    </button>
                @else
                    <button type="button" wire:click="previousPage('{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" wire:loading.attr="disabled" dusk="previousPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}" class="relative inline-flex items-center px-6 py-3 text-sm font-medium text-white bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full transition duration-300 ease-in-out hover:from-blue-600 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                        {!! __('pagination.previous') !!}
                    </button>
                @endif
            @endif

            {{-- Page Information --}}
            <span class="relative z-0 inline-flex shadow-sm rounded-md">
                <span class="relative inline-flex items-center px-6 py-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-l-md leading-5 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600">
                    {{ $paginator->firstItem() ?? 0 }} - {{ $paginator->lastItem() ?? 0 }}
                </span>
                <span class="relative inline-flex items-center px-6 py-3 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-r-md leading-5 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600">
                    of {{ $paginator->total() }}
                </span>
            </span>

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                @if(method_exists($paginator,'getCursorName'))
                    <button type="button" dusk="nextPage" wire:key="cursor-{{ $paginator->getCursorName() }}-{{ $paginator->nextCursor()->encode() }}" wire:click="setPage('{{$paginator->nextCursor()->encode()}}','{{ $paginator->getCursorName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" wire:loading.attr="disabled" class="relative inline-flex items-center px-6 py-3 text-sm font-medium text-white bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full transition duration-300 ease-in-out hover:from-blue-600 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                        {!! __('pagination.next') !!}
                    </button>
                @else
                    <button type="button" wire:click="nextPage('{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" wire:loading.attr="disabled" dusk="nextPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}" class="relative inline-flex items-center px-6 py-3 text-sm font-medium text-white bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full transition duration-300 ease-in-out hover:from-blue-600 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                        {!! __('pagination.next') !!}
                    </button>
                @endif
            @else
                <span class="relative inline-flex items-center px-6 py-3 text-sm font-medium text-gray-400 bg-gray-100 rounded-full transition duration-300 ease-in-out cursor-not-allowed dark:bg-gray-700 dark:text-gray-500">
                    {!! __('pagination.next') !!}
                </span>
            @endif
        </nav>
    @endif
</div>
