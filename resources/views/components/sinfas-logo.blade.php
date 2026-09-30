<img
    class="{{ $class ?? '' }}"
    @if(!empty($style)) style="{{ $style }}" @endif
    src="data:image/svg+xml;base64,{{ base64_encode(file_get_contents(public_path('images/sinfas-logo.svg'))) }}"
    alt="Logo SINFAS"
>
