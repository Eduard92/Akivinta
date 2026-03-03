document.addEventListener('DOMContentLoaded', function(){
  // Header scroll behavior (moved from partial)
  window.addEventListener('scroll', function() {
    const scrollTop = window.scrollY || document.documentElement.scrollTop;
    const darkElement = document.querySelector('.dark');
    if (!darkElement) return;
    if (scrollTop > 10) {
      darkElement.classList.add('scrolled');
    } else {
      darkElement.classList.remove('scrolled');
    }
  });
  // Initialize autocomplete if data is available on window
  try {
    if (window.ciudades && window.categorias) {
      var disponibilidad = ["Renta","Venta"];
      var ciudadInput = document.getElementById("autocomplete");
      var ciudadIdInput = document.getElementById("ciudad_id");
      var categoriaInput = document.getElementById("categoriaAutocomplete");
      var categoriaIdInput = document.getElementById("categoria_id");
      var disponibilidadInput = document.getElementById("disponibilidadAutocomplete");
      if (ciudadInput) {
        var ciudadAwesomplete = new Awesomplete(ciudadInput, {
          list: window.ciudades.map(c => c.label),
          minChars: 0,
          filter: Awesomplete.FILTER_CONTAINS,
          replace: function(text){ this.input.value = text; }
        });
      }
      if (categoriaInput) {
        var categoriaAwesomplete = new Awesomplete(categoriaInput, {
          list: window.categorias.map(c => c.label),
          minChars: 0,
          filter: Awesomplete.FILTER_CONTAINS,
          replace: function(text){ this.input.value = text; }
        });
      }
      if (disponibilidadInput) {
        var disponibilidadAwesomplete = new Awesomplete(disponibilidadInput, { list: disponibilidad, minChars: 0, filter: Awesomplete.FILTER_CONTAINS });
      }
      if (categoriaInput) {
        categoriaInput.addEventListener("awesomplete-selectcomplete", function(evt) {
          var selected = window.categorias.find(c => c.label === (evt.text.value || evt.text));
          categoriaIdInput.value = selected ? selected.value : "";
          ciudadInput && ciudadInput.focus();
        });
        categoriaInput.addEventListener("input", function(){ categoriaIdInput.value = ""; });
      }
      if (ciudadInput) {
        ciudadInput.addEventListener("awesomplete-selectcomplete", function(evt) {
          var selected = window.ciudades.find(c => c.label === (evt.text.value || evt.text));
          ciudadIdInput.value = selected ? selected.value : "";
          disponibilidadInput && disponibilidadInput.focus();
        });
        ciudadInput.addEventListener("input", function(){ ciudadIdInput.value = ""; });
      }
      if (disponibilidadInput) {
        disponibilidadInput.addEventListener("awesomplete-selectcomplete", function(evt){ disponibilidadInput.blur(); });
      }
      function showFullListOnFocus(input, awesompleteInstance) {
        if (!input || !awesompleteInstance) return;
        input.addEventListener("focus", function(){ const currentValue = input.value; input.value = ""; awesompleteInstance.evaluate(); input.value = currentValue; });
      }
      try{ showFullListOnFocus(ciudadInput, ciudadAwesomplete); }catch(e){}
      try{ showFullListOnFocus(categoriaInput, categoriaAwesomplete); }catch(e){}
      try{ showFullListOnFocus(disponibilidadInput, disponibilidadAwesomplete); }catch(e){}
    }
  } catch(e) { console.warn('Autocomplete init error', e); }
});