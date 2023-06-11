$(function () {
  $('.search_conditions').click(function () {
    $('.search_conditions_inner').slideToggle();
    $('.arrow_inner').toggleClass('is_active');
  });

  $('.subject_edit_btn').click(function () {
    $('.subject_edit_inner').toggleClass('is_active');
    $('.subject_inner').slideToggle();
  });
});
