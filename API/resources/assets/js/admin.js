



$(document).on('click','.btn-edit-order-admin',function () {
    var url = $(this).data("url");
    console.log(url);
    $("#ModalEditOrderAdmin").remove();
    $.ajax({
        type: 'GET',
        url: url,
        success: function(res) {
            $('body').append(res);
            $("#ModalEditOrderAdmin").modal();
        },
        error: function(a,b,c) {
            console.log(a,b,c)
        }
    })
});