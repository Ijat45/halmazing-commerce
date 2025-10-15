@props(['icon', 'label', 'href' => '#', 'isToggle' => false, 'toggleName' => '', 'toggleChecked' => false])

<a @unless($isToggle) href="{{ $href }}" @endunless class="d-flex align-items-center justify-content-between p-3 list-group-item list-group-item-action border-0 px-4">
    <div class="d-flex align-items-center">
        {{-- Icon using Bootstrap Icons --}}
        <i class="me-3 bi bi-{{ $icon }} fs-5 text-dark-green"></i>
        <span class="text-dark-green">{{ $label }}</span>
    </div>
    @if ($isToggle)
        <div class="form-check form-switch">
            <input class="form-check-input btn-custom" type="checkbox" role="switch" id="{{ $toggleName }}" name="{{ $toggleName }}" @if($toggleChecked) checked @endif>
            <label class="form-check-label visually-hidden" for="{{ $toggleName }}">{{ $label }} toggle</label>
        </div>
    @else
        <i class="bi bi-chevron-right text-dark-green"></i> {{-- Right arrow icon --}}
    @endif
</a>