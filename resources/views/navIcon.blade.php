@if (auth()->user() && boula())
<style>
    .whats {
        position: fixed !important;
        top: 50% !important;
        left: 20px !important;
        transform: translateY(-50%);
        z-index: 9999 !important;
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
            display: none !important;
        }
    }
</style>

@if (App::environment('local'))
    <a id="whats" class="whats" href="https://yousab-tech.com/workspace/public/en/">
        <img src="https://cdn3.iconfinder.com/data/icons/social-media-logos-flat-colorful/2048/5302_-_Whatsapp-512.png"
            alt="WhatsApp">
    </a>
@else
    <a id="whats" class="whats" href="http://localhost/workspace/public/en/">
        <img src="https://cdn3.iconfinder.com/data/icons/social-media-logos-flat-colorful/2048/5302_-_Whatsapp-512.png"
            alt="WhatsApp">
    </a>
@endif
@endif
