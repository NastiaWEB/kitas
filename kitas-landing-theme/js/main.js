const filtersList = document.querySelector('.filters-list');

  filtersList.addEventListener('click', function(event) {
      const hasDropdown = event.target.closest('.category-list');

      if (hasDropdown) {
          const openDropdowns = document.querySelectorAll('.category-list.open');
          openDropdowns.forEach(function(dropdown) {
              if (hasDropdown !== dropdown) {
                  dropdown.classList.remove('open');
              }
          });
          hasDropdown.classList.toggle('open');

          console.log('window.innerWidth', window.innerWidth);
          if (window.innerWidth <= 835) {
              document.body.style.overflow="hidden";
          }
      }
  });



document.addEventListener('click', function(event) {
    if (!event.target.closest('.filters')) {
        const openDropdowns = document.querySelectorAll('.category-list.open');
        openDropdowns.forEach(function(dropdown) {
            dropdown.classList.remove('open');
        });
    }

    if (!event.target.closest('.sorts-list')) {
        const openDropdowns = document.querySelectorAll('.sort-more.open');
        openDropdowns.forEach(function(dropdown) {
            dropdown.classList.remove('open');
        });
    }

    if (!event.target.closest('.company-search')) {
        const openDropdowns = document.querySelectorAll('.dropbtn.open');
        openDropdowns.forEach(function(dropdown) {
            dropdown.classList.remove('open');
        });
    }

});

const filtersListClose = document.querySelectorAll('.close');

  filtersListClose.forEach(function(close) {
      close.addEventListener('click', function(event) {
              const openDropdowns = document.querySelectorAll('.category-list.open');
              openDropdowns.forEach(function(dropdown) {
                  dropdown.classList.remove('open');
              });

              if (window.innerWidth <= 835) {
                  document.body.style.overflow="auto";
              }
              event.stopPropagation();
      });
  });



// When the user clicks on <div>, open the popup
function myFunction() {
  var popup = document.getElementById("tableOfContent-popup");
  popup.classList.toggle("show");
  var arrow = document.querySelector(".table-of-content-arrow");
  arrow.classList.toggle("rotate");
}


//Sort by
const sortsList = document.querySelector('.sorts-list');

sortsList.addEventListener('click', function(event) {
    const hasDropdown = event.target.closest('.sort-more');

    if (hasDropdown) {
        const openDropdowns = document.querySelectorAll('.sort-more.open');
        openDropdowns.forEach(function(dropdown) {
            if (hasDropdown !== dropdown) {
                dropdown.classList.remove('open');
            }
        });
        hasDropdown.classList.toggle('open');

    }
});

jQuery(".filters-list li a").on("click", function(e){
    e.preventDefault();
});

//Location dropdowm accordion
const speed = 200;

$('.accordion dt').on('click', function(e) {
    if (!e.target.classList.contains('dropdown-caret')) {
        return;
    }

    e.preventDefault();
    e.stopPropagation();

    const that = $(this);

    if(that.parent().hasClass('collapsable')) {

        if( !that.hasClass('expanded') ){
            that.siblings('dt').removeClass('expanded').next('dd').slideUp(speed)
        }

        that.toggleClass('expanded').next('dd').slideToggle(speed)
    }

    ////////////////////////////////////////////////////////////////////////
    //for form
    ////////////////////////////////////////////////////////////////////////

})
