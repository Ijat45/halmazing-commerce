@php
    $currentUrl = url()->full();
    $previousUrl = url()->previous();
    $fallbackUrl = route('pages.home.index');

    if ($previousUrl) {
        $previousUrl = urldecode($previousUrl);

        $previousUrl = preg_replace('/\/index(\b|$)/i', '', $previousUrl);

        $appUrlHost = parse_url(config('app.url'), PHP_URL_HOST);
        $previousHost = parse_url($previousUrl, PHP_URL_HOST);

        if ($previousHost && $previousHost !== $appUrlHost) {
            $previousUrl = $fallbackUrl;
        }
    }

    $backUrl = $previousUrl && $previousUrl !== $currentUrl ? $previousUrl : $fallbackUrl;
@endphp

<a href="{{ $backUrl }}" id="smartBackButton" class="btn btn-light rounded-circle shadow-sm" title="Go Back">
    <i class="fa-solid fa-arrow-left"></i>
</a>

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const backButton = document.getElementById("smartBackButton");
            const currentUrl = window.location.href;
            const backUrl = "{{ $backUrl }}";
            const sessionKey = "visitedPages";
            const visited = JSON.parse(sessionStorage.getItem(sessionKey) || "[]");

            if (!visited.includes(currentUrl)) {
                visited.push(currentUrl);
                sessionStorage.setItem(sessionKey, JSON.stringify(visited));
            }

            backButton.addEventListener("click", (e) => {
                e.preventDefault();

                let backCount = parseInt(sessionStorage.getItem("backCount") || "0");
                sessionStorage.setItem("backCount", ++backCount);

                if (backCount <= 2 && window.history.length > 1) {
                    window.history.back();
                } else {
                    sessionStorage.removeItem("backCount");
                    sessionStorage.removeItem(sessionKey);
                    window.location.href = backUrl;
                }
            });
        });
    </script>
@endpush
