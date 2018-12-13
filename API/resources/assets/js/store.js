


$(document).on('click','.btn-edit-order',function () {
    var url = $(this).data("url");
    console.log(url);
    $("#ModalInfoOrder").remove();
    $.ajax({
        type: 'GET',
        url: url,
        success: function(res) {
            $('body').append(res);
            $("#ModalInfoOrder").modal();
        },
        error: function(a,b,c) {
            console.log(a,b,c)
        }
    })
});

$(document).on('click','.btn-delete-order',function () {
    var url = $(this).data("url");
    console.log(url);
    $("#ModalDeleteOrder").remove();
    $.ajax({
        type: 'GET',
        url: url,
        success: function(res) {
            $('body').append(res);
            $("#ModalDeleteOrder").modal();
        },
        error: function(a,b,c) {
            console.log(a,b,c)
        }
    })
});

$(document).on('click','.btn-info-order',function () {
    var url = $(this).data("url");
    console.log(url);
    $("#ModalInfoOrder").remove();
    $.ajax({
        type: 'GET',
        url: url,
        success: function(res) {
            $('body').append(res);
            $("#ModalInfoOrder").modal();
        },
        error: function(a,b,c) {
            console.log(a,b,c)
        }
    })
});