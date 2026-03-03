/**
 * Properties page initialization
 */
document.addEventListener('DOMContentLoaded', function() {
  // Initialize Swiper carousel for properties
  try {
    if (document.querySelector('.mySwiper') && typeof Swiper !== 'undefined') {
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
  } catch(e) {
    console.warn('Swiper initialization failed:', e);
  }

  // Initialize GLightbox for galleries
  try {
    if (typeof GLightbox !== 'undefined') {
      const lightbox = GLightbox({
        selector: '.glightbox',
        loop: true
      });
    }
  } catch(e) {
    console.warn('GLightbox initialization failed:', e);
  }
});

/**
 * Send WhatsApp message with property details
 */
function sendWhatsApp() {
  try {
    var name = document.getElementById("name").value.trim();
    var email = document.getElementById("email").value.trim();
    var phone = document.getElementById("phone").value.trim();
    var message = document.getElementById("message").value.trim();

    var whatsappNumber = "529995645944";
    var propertyURL = window.location.href;

    var fullMessage = `Hola, soy ${name}:\n${propertyURL}\nEmail: ${email}\nTeléfono: ${phone}\nMensaje: ${message}`;
    var whatsappURL = `https://wa.me/${whatsappNumber}?text=${encodeURIComponent(fullMessage)}`;
    window.open(whatsappURL, '_blank');
  } catch(e) {
    console.error('WhatsApp send failed:', e);
    alert('Error al enviar mensaje. Por favor intente nuevamente.');
  }
}