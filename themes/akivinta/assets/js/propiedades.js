function initSwiper() {
  if (typeof Swiper === 'undefined') {
    setTimeout(initSwiper, 100);
    return;
  }
  const swiper = new Swiper('.mySwiper', {
    slidesPerView: 3,
    spaceBetween: 30,
    loop: true,
    centeredSlides: true,
    autoplay: {
      delay: 3000,
      disableOnInteraction: false,
    },
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
    breakpoints: {
      0: { slidesPerView: 1 },
      768: { slidesPerView: 2 },
      1200: { slidesPerView: 3 }
    }
  });
}
function initLightbox() {
  if (typeof GLightbox === 'undefined') {
    setTimeout(initLightbox, 100);
    return;
  }
  const lightbox = GLightbox({
    selector: '.glightbox',
    loop: true
  });
}
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', function() {
    initSwiper();
    initLightbox();
  });
} else {
  initSwiper();
  initLightbox();
}
      function sendWhatsApp() {
        var name = document.getElementById("name").value.trim();
        var email = document.getElementById("email").value.trim();
        var phone = document.getElementById("phone").value.trim();
        var message = document.getElementById("message").value.trim();
        var whatsappNumber = "529995645944";
        var propertyURL = "https://akivinta.mx/property/{{property.slug}}";
        var fullMessage = `Hola, soy ${name}:
        ${propertyURL}
        Email: ${email}
        Teléfono: ${phone}
        Mensaje: ${message}`;
        var whatsappURL = `https://wa.me/${whatsappNumber}?text=${encodeURIComponent(fullMessage)}`;
        window.open(whatsappURL, '_blank');
    }