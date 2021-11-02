function readURL(input) {

  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {
      $('#preview1').attr('src', e.target.result);
    }

    reader.readAsDataURL(input.files[0]);
  }
}
function readURL2(input) {

  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {
      $('#preview2').attr('src', e.target.result);
    }

    reader.readAsDataURL(input.files[0]);
  }
}
function readURL3(input) {

  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {
      $('#preview3').attr('src', e.target.result);
    }

    reader.readAsDataURL(input.files[0]);
  }
}
function readURL4(input) {

  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {
      $('#preview4').attr('src', e.target.result);
    }

    reader.readAsDataURL(input.files[0]);
  }
}

$(document).ready(function(e){
    $("#file1").on('change',function() {
        readURL(this);
    });
    $("#file2").on('change',function() {
        readURL2(this);
    });
    $("#file3").on('change',function() {
        readURL3(this);
    });
    $("#file4").on('change',function() {
        readURL4(this);
    });
    
    
    $("form#response_form").submit(function(e){
        swal.showLoading();
    });
    
});