function get_result (){
    $('#search_result').html('');
    $.ajax({
        type: "POST",
        url: "/search/ajax_search.php",
        data: "q="+q,
        dataType: 'json',
        success: function(json){
            $('#search_result').html('');
            $(".search_input_close").click(function() {
                $('#search_result').html('');
            });
            $('#search_result').append('<ul class="live-search"></ul>');
            //добавляем каждый элемент массива json внутрь div-ника с class="live-search" (вёрстку можете использовать свою)
            $.each(json, function(index, element) {
                $('#search_result').find('.live-search').append('<li><a href="'+element.URL+'" class="live-search__item"><span class="live-search__item-inner"><span class="live-search__item-name"><span class="live-search__item-hl">'+element.TITLE+'</span></a></li>');
            });
        }
    });
}
var timer = 0;
var q = '';
$( document ).ready(function() {
    $('#q').keyup(function() {
        q = this.value;
        clearTimeout(timer);
        timer = setTimeout(get_result, 10);
    });
    $('#reset_live_search').click(function() {
        $('#search_result').html('');
    });
});
