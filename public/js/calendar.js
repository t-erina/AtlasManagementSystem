//オープン
$(function () {
  $('.js_delete_date').on('click', function () {
    $('.modal').fadeIn(300);
  });
});

//クローズ
$(function () {
  $('.modal').on('click', function (e) {
    if (!$(e.target).closest('.modal__content').length) {
      $('.modal').fadeOut(300);
    } else {
      $('.js_modal_btn').on('click', function () {
        $('.modal').fadeOut(300);
      });
    }
  });
});
