/**
 * Created by iven on 2017/3/27.
 */
var oNav = $('#LoutiNav');//导航壳
var aNav = oNav.find('li');//导航
var aDiv = $('#main .louceng');//楼层
var oTop = $('#goTop');
aNav.eq(0).addClass('active');
//回到顶部
$(window).scroll(function () {
    var winH = $(window).height();//可视窗口高度
    var iTop = $(window).scrollTop();//鼠标滚动的距离

    if (iTop >= 200) {
        oTop.fadeIn();
        //鼠标滑动式改变
        aDiv.each(function () {
            if (winH + iTop - $(this).offset().top > winH / 2) {
                aNav.removeClass('active');
                aNav.eq($(this).index()).addClass('active');
                if ($(this).index() == 0) {
                    aNav.eq(($(this).index()) + 1).addClass('active');
                }
            }
        })
    } else {
        oTop.fadeOut();
    }
})
//点击top回到顶部
oTop.click(function () {
    $('body,html').animate({"scrollTop": 0}, 500)
})
//点击回到当前楼层
aNav.click(function () {
    var i = $(this).index();
    var t = aDiv.eq($(this).index()).offset().top;
    $('body,html').animate({"scrollTop": t}, 500);
    $(this).addClass('active').siblings().removeClass('active');
});
//			轮播图
var box = $(".box");
var slider = $(".slider");
var ul = $(".slider ul");
var lis = $(".slider ul li");
var num = 0;
var num1 = 0;
for (var i = 0; i < lis.length - 1; i++) {
    $("<span></span>").appendTo($(".arror"));
}
var spans = $(".arror span");
$(".arror span").eq(0).addClass("active");
$(".arror span").each(function (i, e) {
    var index = $(this).index();
    $(this).on("click", function () {
        $(".slider ul").css({"left": index * -slider.width()}, 4000);
        $(this).addClass("active").siblings().removeClass("active");
        num = num1 = $(this).index();
    })
})
function auto() {
    num++;
    if (num > lis.length - 1) {
        $(".slider ul").css("left", 0);
        num = 1;
    }
    $(".slider ul").animate({"left": num * -slider.width()});
    num1++;
    if (num1 > spans.length - 1) {
        num1 = 0;
    }
    spans.eq(num1).addClass("active").siblings().removeClass("active");
}
var timer = setInterval(auto, 4000);