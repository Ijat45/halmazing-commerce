@props(['isFavorite' => false])

<button class="btn btn-light rounded-circle shadow-sm flex-shrink-0">
    @if ($isFavorite)
        <i class="fa-solid fa-heart text-danger fs-5"></i>
    @else
        <i class="fa-regular fa-heart text-danger fs-5"></i>
    @endif
</button>
