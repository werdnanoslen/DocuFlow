$(document).on('ready')
{
    var index = window.location.href.lastIndexOf("/") + 1;
    var page = window.location.href.slice(index, window.location.href.indexOf('.'));
    
    switch(page)
    {
        case 'flow':
            /*var percentMainVisible = $(window).height() / $('#main').height();
            var selectionHeight = percentMainVisible * $('#overview').height() - 20;
            $('#overview-selection').css('height', selectionHeight);

            $(document).on('scroll', function()
            {
                if ($(document).scrollTop() > $('#top').outerHeight())
                {
                    $('#main-left').css('position', 'fixed');
                    var top = $('#overview').height()
                        * (($(document).scrollTop() - $('#top').height())
                        / $('#main').height());
                    $('#overview-selection').css('top', top);
                }
                else
                {
                    $('#main-left').css('position', 'absolute');
                    $('#overview-selection').css('top', 0);
                }
            });*/
            break;

        case 'list':
            $('.doc-name').on('click', function()
            {
                $(this).next('.doc-details').slideToggle();
            });
            break;
    }
}

