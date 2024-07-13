$('.btn_atsui').click(function(){
    let parentId = $(this).closest('.border').find('.flex').attr('id');
    // 音声ファイルの再生
    var audio = new Audio('../mp3/atsumori.mp3');
    audio.play();

    $.ajax({
        url: '../ctl/async.php',
        type: 'POST',
        dataType: 'json',
        contentType: 'application/json', 
        data: JSON.stringify({'parentId': parentId})
    })
    .done(function(response) {
        console.log('通信成功:', response);
        let id = response.data['id'];
        let goodCount = response.data['good'];
        let elm = document.getElementById(id);
        
        // 親要素からgood_numクラスの要素を取得
        var goodNumSpan = elm.parentElement.querySelector('.good_num');
        if (goodNumSpan) {
            // good_numのテキストを取得
            goodNumSpan.textContent = '';
            goodNumSpan.textContent = goodCount;
        } else {
            console.log('good_num span not found');
        }
        
    })
    .fail(function(jqXHR, textStatus, errorThrown) {
        console.error('通信失敗:', textStatus, errorThrown);
        console.error('レスポンス:', jqXHR.responseText);
    })
    .always(function() {
        console.log('ajax終了');
    });
})  