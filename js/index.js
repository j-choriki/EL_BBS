$('.btn_atsui').click(function(){
    let parentId = $(this).closest('.border').find('.flex').attr('id');
    $.ajax({
        url: '../ctl/async.php',
        type: 'POST',
        dataType: 'json',
        contentType: 'application/json', 
        data: JSON.stringify({'parentId': parentId})
    })
    .done(function(response) {
        console.log('通信成功:', response);
    })
    .fail(function(jqXHR, textStatus, errorThrown) {
        console.error('通信失敗:', textStatus, errorThrown);
        console.error('レスポンス:', jqXHR.responseText);
    })
    .always(function() {
        console.log('ajax終了');
    });
})