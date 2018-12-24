


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

$(document).on('blur','#addOrderForm',function () {
    var idServices = $(".service-types option:selected").val();
    var SenderAddress = $("#sender-address").val();
    var ReceiverAddress = $("#receiver-address").val();
    var OrderWeight= $("#order-weight").val();
    $.ajax({
        type: 'post',
        url: 'order/getPreMoney',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data : {
            idServices : idServices,
            SenderAddress : SenderAddress,
            ReceiverAddress : ReceiverAddress,
            OrderWeight : OrderWeight
        },
        success: function(res) {
            $('#order-money').val(res.preMoney);
            $('#order-delivery').val(res.timeDelivery);
        },
        error: function(a,b,c) {
            console.log(a,b,c)
        }
    })
});