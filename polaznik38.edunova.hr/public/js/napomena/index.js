$('.prikaziporuku').click(function(){
    var id = $(this).attr('id').split('_')[1];
    $.ajax({
        url: "/napomena/poruka?id="+id,
        cache: false,
        dataType: "text",
        success: function(rezultat){
            $('#cijelaporuka').html(
            rezultat);
            $('#poruka').css('display', 'block');
        }
    });

    return false;
});