{{-- resources/views/partials/no-results.blade.php --}}

@php
    // Keyword is available only when a search was performed; otherwise fall back to the request
    $searchKeyword = $keyword ?? request('q'); 
@endphp

<div class="row">
    <div class="col-12 text-center my-5 py-5">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#757575" class="w-8 h-8 mx-auto mb-4" style="width: 40px; height: 40px;">
            <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636" />
        </svg>

        <h3 style="font-family: 'Oswald', sans-serif; font-weight: 700; color: #121212; text-transform: uppercase; margin-bottom: 8px;">
            No products found
        </h3>

        @if($searchKeyword)
            <p style="font-size: 1rem; color: #757575;">
                We couldn't find any products matching the keyword:
                <strong style="color: #dc3545;">"{{ $searchKeyword }}"</strong>
            </p>
        @else
            <p style="font-size: 1rem; color: #757575;">
                Please try different search terms or adjust filters.
            </p>
        @endif

        <a href="{{ route('products.index') }}" class="btn filter-btn mt-4" style="background: #121212; color: white; border-color: #121212;">
            View all products
        </a>
    </div>
</div>