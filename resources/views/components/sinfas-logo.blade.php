<svg class="{{ $class ?? '' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120" fill="none" role="img" aria-label="Logo SINFAS">
    <defs>
        <linearGradient id="sf-mark-{{ $variant ?? 'default' }}" x1="22" y1="29" x2="101" y2="94" gradientUnits="userSpaceOnUse">
            <stop stop-color="#8EE0C6"/>
            <stop offset=".48" stop-color="#79C9E2"/>
            <stop offset="1" stop-color="#A982D9"/>
        </linearGradient>
        <linearGradient id="sf-highlight-{{ $variant ?? 'default' }}" x1="28" y1="28" x2="97" y2="93" gradientUnits="userSpaceOnUse">
            <stop stop-color="#C2F2E2" stop-opacity=".72"/>
            <stop offset="1" stop-color="#D9C6FA" stop-opacity=".55"/>
        </linearGradient>
    </defs>
    <rect width="120" height="120" rx="24" fill="#192A4A"/>
    <path d="M67 28C60 20 47 18 38 23C27 29 25 42 33 50C39 57 52 61 64 67C78 74 84 84 78 95C70 110 48 112 34 102C29 98 26 94 24 89" stroke="url(#sf-mark-{{ $variant ?? 'default' }})" stroke-width="12" stroke-linecap="butt" stroke-linejoin="round"/>
    <path d="M78 26V76C78 94 68 105 52 110" stroke="url(#sf-mark-{{ $variant ?? 'default' }})" stroke-width="12" stroke-linecap="butt" stroke-linejoin="round"/>
    <path d="M78 27C88 27 98 28 106 23C103 34 96 39 83 39H78" stroke="url(#sf-mark-{{ $variant ?? 'default' }})" stroke-width="12" stroke-linecap="butt" stroke-linejoin="round"/>
    <path d="M78 56C87 56 95 57 102 52C99 63 92 68 81 68H78" stroke="url(#sf-mark-{{ $variant ?? 'default' }})" stroke-width="12" stroke-linecap="butt" stroke-linejoin="round"/>
    <path d="M31 91C39 101 52 105 64 101" stroke="url(#sf-highlight-{{ $variant ?? 'default' }})" stroke-width="2" stroke-linecap="round" opacity=".7"/>
</svg>
