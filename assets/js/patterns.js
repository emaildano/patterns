(function($) {

  $(document).ready(function(){
    var speed = 350;
    var sectionHeights = [];
    var initDisplay = $('.patterns--active').attr('href');

    $(initDisplay).addClass('patterns--section-active');

    $('.patterns--nav-link').click(function(event){
      event.preventDefault();

      var $this = $(this);
      var target = $this.attr('href');

      // Change active nav item
      $('.patterns--nav-link').removeClass('patterns--active');
      $this.addClass('patterns--active');

      // Change visible section
      $('.patterns--type-section').removeClass('patterns--section-active');
      $(target).addClass('patterns--section-active').fadeIn(speed);
    });


    $('.patterns--js-code-toggle').click(function(event){
      event.preventDefault();

      var $this = $(this);
      var target = $this.attr('data-target');

      $(target).slideToggle(400);
    });

  });

})(jQuery);