
$(document).ready(function () {
  //CKEDITOR
  ClassicEditor
    .create(document.querySelector('#body'))
    .catch(error => {
      console.error(error);
    });


  $('#selectAllBoxes').click(function (event) {

    if (this.checked) {

      $('.checkBoxes').each(function () {

        this.checked = true;

      });

    } else {


      $('.checkBoxes').each(function () {

        this.checked = false;

      });


    }


  });

  var div_box = "<div id='load-screen'><div id='loading'></div></div>";
  $("body").prepend(div_box);
  $('#load-screen').delay(400).fadeOut(300, function () {
    $(this).remove();
  });




});


function loadUsersOnline() {
  $.get("functions.php?onlineusers=result", function (data) {
    $(".usersonline").text(data);
  });
}
setInterval(function () {
  loadUsersOnline();


}, 500);


