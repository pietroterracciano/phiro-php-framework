jQuery(document).ready(function($) {
    $(document).find('.jq-tree').each(function() {
        $(this).find('.jq-branch-tree').each(function() {
            if( $(this).hasClass('jq-branch-tree--is-opened') ) {
                $(this).css('display', 'block');
                $(this).attr('data-isCollapsed', false);
            } else if( $(this).attr('data-isCollapsed') === undefined ) 
                $(this).attr('data-isCollapsed', true);
            else if ( !$(this).attr('data-isCollapsed').toBoolean() ) 
                $(this).css('display', 'block');
        })
        $(this).find('a').click(function() {
            var branch = $(this).next();
            if( branch.hasClass('jq-branch-tree') ) {
                var branchIsCollapsed = branch.attr('data-isCollapsed').toBoolean();
                if( branchIsCollapsed ) branch.stop().slideDown(300);
                else branch.stop().slideUp(300);
                branch.attr('data-isCollapsed', !branchIsCollapsed);
            }
        });
    });
})