// @ts-nocheck

$("body").on("click", ".btn-simpan", function (event) {
    event.preventDefault();

    var form        = $('#form-body form'),
        url         = form.attr('action');

    form.find('.errorTxt1').remove();
    form.find('.input-field').removeClass('error');
    $('.error').removeClass('error');

    $.ajax({
        url: url,
        method: 'POST',
        data: new FormData(form[0]),
        contentType: false,
        processData: false,
        beforeSend: function(){
            Swal.showLoading();
        },
        success: function (response) {
            var status;
            if (response.failedJobs != 0) {
                status = "Failed";
            } else if (response.pendingJobs != 0) {
                status = "Pending";
            } else if (response.processedJobs != 0) {
                status = "Processing";
            } else {
                status = "Completed"
            }


                $("#datatable").append(`
                    <tr>
                        <td>`+formatDate(response.createdAt)+`</td>
                        <td>`+response.name+`</td>
                        <td><label id="`+ response.id+"-status"+`">`+status+`</label></td>
                        <td><label id="`+response.id+`"> 0 % </label></td>
                    <tr/>
                `)
                Swal.fire({
                    showConfirmButton: false,
                    timer: 1300,
                    icon: "success",
                    title: "Successfully",
                });
        },
        error: function (xhr) {
            swal.close();
            var res = xhr.responseJSON;
            if ($.isEmptyObject(res) == false) {
                $.each(res.errors, function (key, value) {
                        Swal.fire({
                            icon: "error",
                            title: "Input Error",
                            text: value,
                        });
                });
            }
        }
    });
});

function formatDate(dateTimestamp) {
    var date = new Date(dateTimestamp);

    var year = date.getUTCFullYear();
    var month = String(date.getUTCMonth() + 1).padStart(2, '0');
    var day = String(date.getUTCDate()).padStart(2, '0');
    var hours = String(date.getUTCHours()).padStart(2, '0');
    var minutes = String(date.getUTCMinutes()).padStart(2, '0');
    var seconds = String(date.getUTCSeconds()).padStart(2, '0');

    var formattedDateTime = year + "-" + month + "-" + day + " " + hours + ":" + minutes + ":" + seconds;
    return formattedDateTime
}
