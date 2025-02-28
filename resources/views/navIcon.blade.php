<style>
.whats {
    position: fixed;
    bottom: 20px;  /* Distance from bottom */
    right: 20px;   /* Distance from right */
    z-index: 200;
    display: inline-block;
    border: none !important;
    outline: none !important;
    background-color: #1cce3a;
    cursor: pointer;
    padding: 10px 12px;
    border-radius: 50%;
    transition: all 0.5s;
    box-shadow: 2px 2px 5px #b0afaf, -2px -2px 5px #b0afaf;
}

.whats:hover {
    box-shadow: 2px 2px 5px #7a7979, -2px -2px 5px #7a7979;
    transform: scale(1.1); /* Slight zoom effect on hover */
}

.whats img {
    width: 50px; /* Adjust image size */
    height: 50px;
}

  </style>
  
  <!-- Start button WhatsApp -->
  <a id="whats" class="whats" href="https://web.whatsapp.com/" target="_blank">
    <img src="https://cdn3.iconfinder.com/data/icons/social-media-logos-flat-colorful/2048/5302_-_Whatsapp-512.png" alt="WhatsApp">
</a>