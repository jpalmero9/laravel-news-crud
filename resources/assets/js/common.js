$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

jQuery(document).ready(function ($) {

    $('[data-toggle="tooltip"]').tooltip();

    $('#news-all__btn-next-ajax').PostPagination();

    $('#news-all .news-all-extend__item').PostBtnDelete();
    $('#news-all .news-all__item').PostBtnDelete({postShortItem:'.news-all__item'});

    $('#comment-add').formValidation()
        .on('init.field.fv', function(e, data) {

            var $parent = data.element.parents('.form-group'),
                $icon   = $parent.find('.form-control-feedback[data-fv-icon-for="' + data.field + '"]');

            $icon.on('click.clearing', function() {
                if ($icon.hasClass('icon-cancel')) {
                    data.fv.resetField(data.element);
                }
            });
        })
        .on('success.form.fv', function (e) {
            e.preventDefault();

            $.ajax({
                type: 'POST',
                url: $(e.target).attr('action'),
                dataType: 'json',
                data: $(e.target).serializeArray(),
                success: function (response, status) {

                    if (response.status == 'OK' && status=='success') {

                        if(!$('#comment-list').length){
                            var tplComentsWrap = _.template( $('#tplPostCommentsWrap').html() );
                            $('#article').parent().append(tplComentsWrap);
                        }

                        var $commentsList = $('#comment-list'),
                            tplComment = _.template( $('#tplPostCommentItem').html() );

                        $commentsList.prepend(tplComment(response.comment));

                        $('html,body').animate({scrollTop: $commentsList.offset().top});

                    }
                },
                complete: function () {
                    $(e.target).find('textarea').val('');
                    $(e.target).find('input').not(':hidden').val('');
                }
            });

    });

    $('#form-user-login,#form-user-register,#form-post-manage,#form-category-manage').formValidation();


    $('#form-post-manage-published').datetimepicker({
        locale:'ru',
        format: 'YYYY-MM-DD hh:mm:ss'
    });

    $('#categories-table').on('click', '.btn-category-delete', function (e) {
        var _btn = this;
        $.ajax({
            type: 'POST',
            url: $(e.delegateTarget).data('action-category-delete'),
            dataType: 'json',
            data: {id:parseInt( $(_btn).data('id'))},
            beforeSend: function () {
                $(_btn).button('loading');
            },
            success: function (response, status) {
                if (response.status == 'OK' && status=='success') {
                    $(_btn).closest('tr').slideUp(200, function (el) {
                        $(el).remove();
                    })
                }
            },
            complete: function () {
                $(_btn).button('reset');
            }
        });
    });

/*
    var $commentsLatest = $('#comment-list-latest');

    if($commentsLatest.length){
        $.ajax({
            type: 'POST',
            url: $commentsLatest.data('action-url-comments'),
            dataType: 'json',
            data: {limit:parseInt( $commentsLatest.data('limit'))},
            success: function (response, status) {
                var CommLen = response.results.length;

                if (response.status == 'OK' && status=='success' && CommLen) {
                    var tplCommentLatest = _.template( $('#tplCommentLatest').html() );
                    $commentsLatest.removeClass('comment-list_empty').empty();
                    for(var i = 0; i < CommLen; i++){

                        $commentsLatest.prepend(tplCommentLatest(response.results[i]));
                    }
                }
            }
        });
    }
*/

});

(function ($) {


    /***
     * @param o
     * @returns {*}
     * @constructor
     */
    jQuery.fn.PostBtnDelete = function (o) {
        var _o = $.fn.extend({
            elWithActionUrl:'#news-all',
            btnDelete: '.post-btn-delete',
            urlPostDelete: 'url-post-delete'
        }, o);

        function init() {

            var $post = $(this);

            $post.on('click', _o.btnDelete, function () {

                var $btn = $(this);
                $.ajax({
                    type: 'POST',
                    url: $(_o.elWithActionUrl).data(_o.urlPostDelete),
                    dataType: 'json',
                    data: {id:parseInt( $post.data('id'))},
                    beforeSend: function () {
                        $btn.button('loading');
                    },
                    success: function (response, status) {
                        if (response.status == 'OK' && status=='success') {
                            $post.slideUp(200, function (el) {
                                $(el).remove();
                            })
                        }
                    },
                    complete: function () {
                        $btn.button('reset');
                    }
                });
            });

        }

        return this.each(init);
    };


    /**
     * Post ajax load page
     * @param o
     * @returns {*}
     * @constructor
     */
    jQuery.fn.PostPagination = function (o) {
        var _o = $.fn.extend({
            enableCriteria: ['category_id', 'limit', 'author_id', 'tag'],
            postNavigation: '#news-navigation',
            postList: '#news-all',
            postShortItem:'.news-all__item-m',
            postTplShortItem: '#tplPostShortItem',
            btnSimplePrevWrap:'.navigation-simple__item_prev',
            btnSimplePrevTplLink:'#tplNavigationSimplePrevLink',
            btnSimplePrevTplEmpty:'#tplNavigationSimplePrevBtn',
            btnSimpleNextWrap:'.navigation-simple__item_next',
            btnSimpleNextTplLink:'#tplNavigationSimpleNextLink',
            btnSimpleNextTplEmpty:'#tplNavigationSimpleNextBtn',
            navPagesEl: '.navigation-pages',
            navPagesTpl: '#tplNavigationPages',
            pageCurrent: '.navigation-pages__current',
            navSimple: '#navigation-simple'
        }, o);

        function pagination() {

            var $btn = $(this),
                $naviRoot = $(_o.postNavigation),
                locale = $('html').prop('lang'),
                $postList = $(_o.postList);

            $btn.on('click', function (e) {

                if (!$btn.is(':disabled')) {

                    var params = {locale: locale, page: $btn.data('page'), route: $postList.data('current')},
                        criteriaValue,
                        tag = $postList.data('tag'),
                        category_id = parseInt($btn.data('category-id'));

                    for(var i=0; i < _o.enableCriteria.length; i++){
                        criteriaValue = searchUriParam(_o.enableCriteria[i]);
                        if(criteriaValue!=null){
                            params[_o.enableCriteria[i]] = criteriaValue;
                        }
                    }

                    if(category_id){
                        params['category_id'] = category_id;
                    }

                    if(tag){
                        params['tag'] = $postList.data('tag');
                    }

                    $.ajax({
                        type: 'POST',
                        url: $btn.data('action-url'),
                        dataType: 'json',
                        data: params,
                        beforeSend: function () {
                            $btn.button('loading');
                        },
                        success: function (response, status) {
                            if (response.status == 'OK' && status=='success') {

                                if(response.results.per_page){

                                    var tplPost = _.template( $(_o.postTplShortItem).html() ),
                                        tplNavPages = _.template( $(_o.navPagesTpl).html() ),
                                        tplPagesData,
                                        uriPage = getUriWithNewParam(),
                                        tplBtnPrevEmpty,
                                        tplBtnPrevLink,
                                        tplBtnNextEmpty,
                                        tplBtnNextLink;

                                    for(var i=0; i < response.results.data.length; i++){
                                        $postList.append(tplPost(response.results.data[i]));

                                        $postList.find(_o.postShortItem).filter(':last').PostBtnDelete().find('[data-toggle="tooltip"]').tooltip();
                                    }

                                    if(response.results.prev_page_url!==null){
                                        tplBtnPrevLink = _.template( $(_o.btnSimplePrevTplLink).html() );
                                        $naviRoot.find(_o.btnSimplePrevWrap).empty().prepend(tplBtnPrevLink({prev_page_url: response.results.prev_page_url}))
                                    } else {
                                        tplBtnPrevEmpty = _.template( $(_o.btnSimplePrevTplEmpty).html() );
                                        $naviRoot.find(_o.btnSimplePrevWrap).empty().prepend(tplBtnPrevEmpty);
                                    }

                                    if(response.results.next_page_url!==null){
                                        $btn.data('page', response.results.current_page + 1);
                                        tplBtnNextLink = _.template( $(_o.btnSimpleNextTplLink).html() );
                                        $naviRoot.find(_o.btnSimpleNextWrap).empty().prepend(tplBtnNextLink({next_page_url: response.results.next_page_url}))
                                    } else {
                                        tplBtnNextEmpty = _.template( $(_o.btnSimpleNextTplEmpty).html() );
                                        $naviRoot.find(_o.btnSimpleNextWrap).empty().prepend(tplBtnNextEmpty);
                                        $btn.remove();
                                    }

                                    tplPagesData = {
                                        "url": uriPage,
                                        "total": response.results.total,
                                        "per_page": response.results.per_page,
                                        "current_page": response.results.current_page,
                                        "last_page": response.results.last_page,
                                        "next_page_url": response.results.next_page_url,
                                        "prev_page_url": response.results.prev_page_url,
                                        "from": response.results.from,
                                        "to": response.results.to
                                    };


                                    $naviRoot.find(_o.navPagesEl).empty().prepend(tplNavPages(tplPagesData));

                                    history.pushState('', '', uriPage + response.results.current_page);

                                }

                            }
                        },
                        complete: function () {
                            $btn.button('reset');
                        }
                    });

                }
            });



            function getUriWithNewParam(){

                var route_uri = window.location.href.split('?')[0],
                    data =[];

                if(location.search){

                    var pair=(location.search.substr(1)).split('&'),
                        param;

                    if(pair.length){

                        for(var i=0; i<pair.length; i++){
                            param=pair[i].split('=');
                            if(param[0]!=='page'){
                                data.push(param.join('='));
                            }
                        }

                        if(data.length){
                            route_uri += '?' + data.join('&') + '&page=';
                        } else {
                            route_uri += '?page=';
                        }

                    } else {
                        route_uri += '?page=';
                    }
                } else {
                    route_uri += '?page=';
                }

                return route_uri;
            }

           function searchUriParam(name){
                var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
                if (results==null){
                    return null;
                }
                else{
                    return results[1] || 0;
                }
            }
        }

        return this.each(pagination);
    };



})(jQuery);