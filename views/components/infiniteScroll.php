<style>
*{
    box-sizing: border-box;
}
img{
    vertical-align: middle;
}
img{
    border: 0;
}
:after, :before{
    box-sizing: border-box;
}
.rowImg{
    display: flex;
    width: 100%;
    height: 350px;
    overflow: hidden;
    margin: 6px 0;
}
.colImg {
    margin: 0 3px;
}
.colImg:nth-child(1){
    margin-left: 0;
}
.colImg:nth-last-child(1){
    margin-right: 0;
}
.containerImg{
  overflow: hidden;
  cursor: pointer;
  position: relative;
}
img{
  object-fit: cover;
  width: 100%;
  height: 100%;
  transition: ease 0.35s all;
}
.containerImg{
    margin: 6px 0;
}
.containerImg:nth-child(1){
    margin-top: 0;
}
.containerImg:nth-last-child(1){
    margin-bottom: 0;
}
.containerImg:hover img {
    transform: scale(1.1);
}
.containerImg:hover .infoSupp, .containerImg:hover .infoSuppBot {
    opacity: 0.6;
}
.containerImg a{
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}
.infoSupp{
    opacity: 0;
    position: absolute;
    top: 0;
    left: 0;
    background: #000;
    width: 100%;
    color: #fff;
    height: 30px;
    padding: 5px;
    font-size: 20px;
    font-family: "Open Sans", sans-serif;
    font-style: italic;
    text-overflow: ellipsis;
    white-space: nowrap;
    overflow: hidden;
    transition: ease 1s all;
}
.containerImg:nth-child(2) .infoSuppBot{
    bottom: 6px;
}
.containerImg:nth-child(3) .infoSuppBot{
    bottom: 12px;
}
</style>
<script>
patterns = {
    1 : {
        "nbImg": "2",
        "pattern": {
            1 : {"width":"50", "number":"1"},
            2 : {"width":"50", "number":"1"}
        }
    },
    2 : {
        "nbImg": "3",
        "pattern": {
            1 : {"width":"35", "number":"2"},
            2 : {"width":"65", "number":"1"}
        }

    },
    3 : {
        "nbImg": "3",
        "pattern": {
            1 : {"width":"65", "number":"1"},
            2 : {"width":"35", "number":"2"}
        }

    },
    <?php
       if(!GlobalController::isMobile()):
    ?>
    4 : {
        "nbImg": "3",
        "pattern": {
            1 : {"width":"33.33","number":"1"},
            2 : {"width":"33.33","number":"1"},
            3 : {"width":"33.33","number":"1"}
        }
    },
    5 : {
        "nbImg": "4",
        "pattern": {
            1 : {"width":"55","number":"1"},
            2 : {"width":"15","number":"2"},
            3 : {"width":"30","number":"1"}
        }
    },
    6 : {
        "nbImg": "5",
        "pattern": {
            1 : {"width":"25", "number":"2"},
            2 : {"width":"45", "number":"1"},
            3 : {"width":"30", "number":"3"}
        }
    },
    7 : {
        "nbImg": "5",
        "pattern" : {
            1 : {"width":"25","number":"2"},
            2 : {"width":"45","number":"2"},
            3 : {"width":"30","number":"1"}
           }
    },
    <?php endif; ?>
};

var content = [];
<?php foreach($pictures as $picture): ?>
    content.push(["/public/cdn/images/<?php echo $picture['url'] ?>", "<?php echo $_SESSION['community_slug'] ?>/picture/<?php echo $picture['id'] ?>","<?php echo $picture['title'] ?>"]);
<?php endforeach; ?>

function populatePattern(){
    var rand = Math.floor((Math.random() * Object.keys(patterns).length + 1));
    if(rand != $('#content .rowImg:last').data('index')){
        $('#content').append('<div class="rowImg" data-index="'+rand+'" data-nbimg="'+patterns[rand].nbImg+'"></div>');
        $.each(patterns[rand].pattern,function(index,value){
            $('#content .rowImg:last').append('<div class="colImg" style="width: '+value.width+'%"></div>');
            if(content.length > 0){
                for(i = 1; i <= value.number; i++){
                    var data = content.shift();
                    $('#content .colImg:last').append('<div class="containerImg" style="height: '+100/value.number+'%"></div>');
                    if(data[0] != undefined) $('#content .containerImg:last').append('<img src="'+data[0]+'"/>');
                    if(data[2] != undefined) $('#content .containerImg:last').append('<div class="infoSupp">'+data[2]+'</div>');
                    if(data[1] != undefined) $('#content .containerImg:last').append('<a href="'+data[1]+'"></a>');
                }
            }
        });
        if($('#content .rowImg:last img').length < $('#content .rowImg:last').data('nbimg')){
            $('#content .rowImg:last').remove();
        }
    } else {
        populatePattern();
    }
}

$(document).ready(function() {
    populatePattern();
    populatePattern();
    populatePattern();
});

var processing, fullsize_url, id, title, username, countryCode;

$(document).scroll(function(e){

       if (processing)
           return false;

       if ($(window).scrollTop() >= ($(document).height() - $(window).height())*0.85){
            processing = true;
            // $.ajax({
            //     url: '/<?php echo $_SESSION['community_slug'] ?>/media/loadMore',
            //     data: {index: $('#content .containerImg img').length + content.length, type: 'photos'},
            //     type: 'POST',
            //     success: function(datas){
            //         $.each(datas,function(index,data){
            //             url = (data.url != null ? data.url : "");
            //             id = (data.id != null ? data.id : "");
            //             title = (data.title != null ? data.title : "");
            //             content.push(["/public/cdn/images/"+url,"<?php echo $_SESSION['community_slug'] ?>/picture/"+id,title]);
            //         });
            //
            //         populatePattern();
            //         processing = false;
            //     }
            // })
            populatePattern();
            processing = false;

       }
});

</script>
<div id="content" class="massonry"></div>
