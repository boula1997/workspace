<style>
    .scroll-top {
        position: fixed !important;
        top: 50% !important;
        right: 2px !important;
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
        display: none; /* Hidden by default */
    }

    .scroll-top:hover {
        transform: translateY(-50%) scale(1.1);
    }

    .scroll-top img {
        width: 40px;
        height: 40px;
    }

    @media (max-width: 768px) {
        .scroll-top {
            display: none !important;
        }
    }
</style>

<a id="scrollTopBtn" class="scroll-top">
    <img src="https://cdn-icons-png.flaticon.com/512/892/892692.png" alt="Go to Top">
</a>

<script>
    const scrollBtn = document.getElementById('scrollTopBtn');

    // Show button only after scrolling down
    window.addEventListener('scroll', function () {
        if (window.scrollY > 200) {
            scrollBtn.style.display = 'flex';
        } else {
            scrollBtn.style.display = 'none';
        }
    });

    // Scroll to top on click
    scrollBtn.addEventListener('click', function (e) {
        e.preventDefault();
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
</script>
