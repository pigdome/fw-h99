$("input[type=file].imageupload").change(function () {
    var fd = new FormData();
    var files = $('.imageupload')[0].files;

    if (files.length > 0) {
        fd.append('file', files[0]);
        $.ajax({
            url: '/upload.php',
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.error) {
                    alert(response.error);
                }
                else {
                    $("#evidence").val(response.url);
                }
            }
        });
    } else {
        alert("Please select a file.");
    }
});