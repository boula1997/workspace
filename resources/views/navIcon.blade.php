<style>
    .whats {
        position: fixed;
        top: 50%;
        right: 2px;
        transform: translateY(-50%);
        z-index: 9999;
        width: 60px;
        height: 60px;
        background-color: unset;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 2px 2px 5px #b0afaf, -2px -2px 5px #b0afaf;
        cursor: pointer;
        transition: transform 0.3s ease-in-out;
    }

    .whats:hover {
        transform: translateY(-50%) scale(1.1);
    }

    .whats img {
        width: 40px;
        height: 40px;
    }

    /* Hide on screens smaller than 768px */
    @media (max-width: 768px) {
        .whats {
            display: none;
        }
    }
</style>

@php
    $whatsAppUrl = App::environment('local')
        ? 'http://localhost/workspace/public/en/'
        : 'https://yousab-tech.com/workspace/public/en/';
@endphp

<a id="whats" class="whats" href="{{ $whatsAppUrl }}" target="_blank" aria-label="WhatsApp">
    <img src="https://cdn3.iconfinder.com/data/icons/social-media-logos-flat-colorful/2048/5302_-_Whatsapp-512.png" alt="WhatsApp Icon">
</a>
