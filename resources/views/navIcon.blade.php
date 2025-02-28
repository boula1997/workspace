<style>
    .whats {
        position: fixed !important;
        /* Ensures it stays fixed */
        bottom: 20px !important;
        /* Distance from bottom */
        right: 20px !important;
        /* Distance from right */
        z-index: 9999 !important;
        /* Keeps it above other elements */
        width: 60px;
        height: 60px;
        background-color: #1cce3a;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 2px 2px 5px #b0afaf, -2px -2px 5px #b0afaf;
        cursor: pointer;
        transition: transform 0.3s ease-in-out;
    }

    .whats:hover {
        transform: scale(1.1);
        /* Zoom effect on hover */
    }

    .whats img {
        width: 40px;
        height: 40px;
    }
</style>


@if (App::environment('local'))
    <!-- Start button WhatsApp -->
    <a id="whats" class="whats" href="https://yousab-tech.com/workspace/public/en/">
        <img src="https://cdn3.iconfinder.com/data/icons/social-media-logos-flat-colorful/2048/5302_-_Whatsapp-512.png"
            alt="WhatsApp">
    </a>
@else
    <!-- Start button WhatsApp -->
    <a id="whats" class="whats" href="http://localhost/workspace/public/en/">
        <img src="https://cdn3.iconfinder.com/data/icons/social-media-logos-flat-colorful/2048/5302_-_Whatsapp-512.png"
            alt="WhatsApp">
    </a>
@endif
