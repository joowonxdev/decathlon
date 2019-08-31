

var getData = function(url, callback){

    $.ajax({
        url:url,
        type:'GET',
    })
    .done(function(data){
        callback(data);

    });
}

var sports_cate = function (){
    getData('//joowonxdev.underkg.co.kr/decathlon/api/sports', sports_list);
}

var sports_list = function(data){
    console.log('sport list');
    if($(location).attr('href').match('store') == 'store'){
        console.log('store');
        $.each(data, function( index, value){
            if(index !== 'type') {
                $('ul.sport-list').append('<li id="sport-' + value.sport_id + '" class="list-group-item sport-' + value.sport_id + '">' +
                    '<a href="#" onclick="productList_load(' + value.sport_id + ')">' + value.sport_name + '</a></li>');
            }
        });
    }else if($(location).attr('href').match('activities') == 'activities'){
        console.log('activities');
        $.each(data, function( index, value){
            if(index !== 'type') {
                $('ul.sport-list').append('<li id="sport-' + value.sport_id + '" class="list-group-item sport-' + value.sport_id + '">' +
                    '<a href="#" onclick="actList_load(' + value.sport_id + ')">' + value.sport_name + '</a></li>');
            }
        });
    }
}


var productList_load = function (sport_id){
    console.log('productList_load');
    $('.product-info').addClass('d-none');
    $('ul.sport-list').children().each(function(){
        $(this).removeClass('active');
    });
    $('li.sport-'+sport_id).addClass('active');
    getData('//joowonxdev.underkg.co.kr/decathlon/api/stores/list/'+sport_id,product_list);
}
var productDetail_load = function (product_id){
    console.log('productDetail_load');
    $('.product-info').addClass('d-none');
    $('ul.product-list').children().each(function(){
        $(this).removeClass('active');
    });
    $('li.product-'+product_id).addClass('active');
    getData('//joowonxdev.underkg.co.kr/decathlon/api/stores/product/'+product_id,product_detail);
}
var actList_load = function (sport_id){
    console.log('actList_load');
    $('.class-info').addClass('d-none');
    $('ul.sport-list').children().each(function(){
        $(this).removeClass('active');
    });
    $('li.sport-'+sport_id).addClass('active');
    getData('//joowonxdev.underkg.co.kr/decathlon/api/activitie/list/'+sport_id,act_list);
}
var actDetail_load = function (activities_id){
    console.log('actDetail_load');
    $('.class-info').addClass('d-none');
    $('ul.class-list').children().each(function(){
        $(this).removeClass('active');
    });
    $('li.class-'+activities_id).addClass('active');
    getData('//joowonxdev.underkg.co.kr/decathlon/api/activitie/class/'+activities_id,act_detail);
}


var product_list = function (data){
    console.log('actDetail_load');
    $('ul.product-list').empty();
    $.each(data, function( index, value){
        if(index !== 'type'){
            if(value == 'empty'){
                $('ul.product-list').append('<li id="product-empty" class="list-group-item product-empty">NO DATA</a></li>');
            }else {
                $('ul.product-list').append('<li id="product-' + value.product_id + '" class="list-group-item product-' + value.product_id + '">' +
                    '<a href="#" onclick="productDetail_load(' + value.product_id + ')">' + value.product_name + '/' + value.product_price + '</a></li>');
            }
        }
    });
}

var product_detail = function (data) {
    console.log('product_detail');
    var product = data[0];
    $('.product-info').removeClass('d-none');
    $('.product-name').text(product['product_name']);
    $('.product-price').text(product['product_price']);
    $('.product-description').text(product['description']);
}



var act_list = function (data){
    console.log('act_list');
    $('ul.class-list').empty();
    $.each(data, function( index, value){
        if(index !== 'type'){
            if(value == 'empty'){
                $('ul.class-list').append('<li id="class-empty" class="list-group-item class-empty">NO DATA</a></li>');
            }else{
                $('ul.class-list').append('<li id="class-'+ value.activities_id +'" class="list-group-item class-'+ value.activities_id +'">' +
                    '<a href="#" onclick="actDetail_load('+value.activities_id+')">'+ value.class_name + '/' +  value.class_price +'</a></li>');
            }

        }
    });
}

var act_detail = function (data) {
    console.log('act_detail');
    var activitie = data[0];
    $('.class-info').removeClass('d-none');
    if(activitie['user_num']){
        $('.apply-class').addClass('d-none');
        $('.regist-class').removeClass('d-none');
    }else{
        $('.apply-class').on("click", function(){act_apply(activitie['activities_id'])});
        $('.apply-class').removeClass('d-none');
        $('.regist-class').addClass('d-none');
    }
    $('.class-name').text(activitie['class_name']);
    $('.class-price').text(activitie['class_price']);
    $('.class-description').text(activitie['description']);
}




var act_apply = function(activities_id){
    console.log('act_apply');
    var data = {'activities_id' : activities_id };
    postData('//joowonxdev.underkg.co.kr/decathlon/api/apply/',data,act_finish);

}

var act_finish = function(){
    console.log('act_finish');
    $('.apply-class').addClass('d-none');
    $('.regist-class').removeClass('d-none');

}

var postData = function(url,data, callback){

    $.ajax({
        url:url,
        type:'POST',
        dataType:'json',
        data:data,
        statusCode: {
            200:  function (response) {
                console.log('200');
                callback();
            },
            404: function (response) {
                console.log('404');
            }
        },

    });
}
