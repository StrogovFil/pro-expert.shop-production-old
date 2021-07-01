$(document).ready(function(){
    $(document).on('click', '#paginationShowAll', function(){
        var targetContainer = $('.catalog-items'),
            fullContainer = $('.catalog-container-page'),
            url = $('#paginationShowAll').attr('data-url');

        if (url !== undefined) {
            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'html',
                success: function(data){
                    let elements = $(data).find('.catalog-items');
                    $('#pagination').remove();
                    targetContainer.remove();
                    fullContainer.append(elements);

                    $('html, body').animate({scrollTop: $('.js-temp-last-element-box').offset().top}, 300);
                }
            })
        }
    });
});