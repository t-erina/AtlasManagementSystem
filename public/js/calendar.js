//オープン
$(function () {
  $('.js_delete_date').on('click', function (e) {
    //押されたボタンを取得
    var target = $(e.target);
    //値の取得
    var date = $(target).val();
    var time = $(target).data('time');
    var id = $(target).data('id');
    console.log()
    $('.modal_date').text(date);
    $('.modal_time').text(time);
    $('.delete_id').val(id);
    //オープン
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
