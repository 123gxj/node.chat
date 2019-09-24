//全选/取消全选
$("#allcheckbox").click(function() {
    $(".item").attr("checked", this.checked);
});

//全选删除
$("#allDelBtn").click(function() {
    var items = $(".item").filter(function() {
        return this.checked;
    })

    var ids = ""
    $(items).each(function(index) {
       ids = ids + this.value + ","
    })
    
    ids = ids.substr(0, ids.length - 1);

    location=location.pathname + "?id=" + ids;
})

//还原
$("#allResetBtn").click(function() {
    var items = $(".item").filter(function() {
        return this.checked;
    })

    var ids = ""
    $(items).each(function(index) {
       ids = ids + this.value + ","
    })
    
    ids = ids.substr(0, ids.length - 1);

    location=location.pathname + "?id=" + ids + "&action=reset";
})

//点击图片放大 image-con
$(".book_thumb").click(function(e) {
    var imageCon = document.querySelector(".image-con");
    var bgElement = document.querySelector(".image-con-bg");

    if(!bgElement) {
        bgElement = document.createElement("div");
        $("body").append(bgElement);
        $(bgElement).addClass("image-con-bg");
    }

    if(!imageCon) {
        imageCon = document.createElement("div");
        
        //追加元素和类
        $("body").append(imageCon);
        $(imageCon).addClass("image-con");
        $(imageCon).append($(this).clone(true).removeClass("book_thumb").addClass("scale-image"));
        
        $(bgElement).css("display", "block");

        //阻止冒泡
        e.stopPropagation();
    }


})

$(document).click(function(e) {
    if($(".scale-image")[0] && $(".scale-image")[0] != e.target ) {
        $("body")[0].removeChild($(".image-con")[0]);
        $(".image-con-bg").css("display", "none");
    }
})