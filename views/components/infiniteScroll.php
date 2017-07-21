<style>
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
    height: 63px;
    padding: 5px;
    font-size: 20px;
    font-family: "Open Sans", sans-serif;
    font-style: italic;
    text-overflow: ellipsis;
    white-space: nowrap;
    overflow: hidden;
    transition: ease 1s all;
}
.infoSuppBot{
    opacity: 0;
    position: absolute;
    bottom: 0;
    left: 0;
    background: #000;
    width: 100%;
    color: #fff;
    height: 35px;
    padding: 5px;
    font-size: 20px;
    font-family: "Open Sans", sans-serif;
    font-style: italic;
    text-overflow: ellipsis;
    white-space: nowrap;
    overflow: hidden;
    transition: ease 1s all;
}
.infoSuppBot span{
    float: right;
}
.containerImg:nth-child(2) .infoSuppBot{
    bottom: 6px;
}
.containerImg:nth-child(3) .infoSuppBot{
    bottom: 12px;
}

</style>

<script>
/* TODO
    * Ratio images
    * Responsive
    * Insert CSS
    * Argument pour height et  margin
    * DÃ©terminer les x premiers patterns
    * Regler problÃ¨me de troue
    * Ajouter une gif de chargement
    * Limite pattern
*/


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
             1 : {"width":"33.33","number":"1"},
             2 : {"width":"33.33","number":"1"},
             3 : {"width":"33.33","number":"1"}
         }
     },
     3 : {
         "nbImg": "3",
         "pattern": {
             1 : {"width":"35", "number":"2"},
             2 : {"width":"65", "number":"1"}
         }

     },
     4 : {
         "nbImg": "4",
         "pattern": {
             1 : {"width":"55","number":"1"},
             2 : {"width":"15","number":"2"},
             3 : {"width":"30","number":"1"}
         }
     },
     5 : {
         "nbImg": "5",
         "pattern": {
             1 : {"width":"25", "number":"2"},
             2 : {"width":"45", "number":"1"},
             3 : {"width":"30", "number":"3"}
         }
     },
     6 : {
         "nbImg": "5",
         "pattern" : {
             1 : {"width":"25","number":"2"},
             2 : {"width":"45","number":"2"},
             3 : {"width":"30","number":"1"}
            }
     }
 }


function populatePattern(img){
    var rand = Math.floor((Math.random() * Object.keys(patterns).length + 1));
    if(rand != $('.rowImg:last').data('index')){
        $('#content').append('<div class="rowImg" data-index="'+rand+'" data-nbimg="'+patterns[rand].nbImg+'"></div>');
        $.each(patterns[rand].pattern,function(index,value){
            $('.rowImg:last').append('<div class="colImg" style="width: '+value.width+'%"></div>');
            if(img.length > 0){
                for(i = 0; i <= value.number; i++){
                    var data = img.shift();
                    $('.colImg:last').append('<div class="containerImg" style="height: '+100/value.number+'%"></div>');
                    if(data[0] != undefined) $('.containerImg:last').append('<img src="'+data[0]+'"/>');
                    if(data[2] != undefined) $('.containerImg:last').append('<div class="infoSupp">'+data[2]+'</div>');
                    if(data[1] != undefined) $('.containerImg:last').append('<a href="<?php echo isset($community) ? $community->getSlug() : ""; ?>'+data[1]+'"></a>');
                }
            }
        });
        if($('.rowImg:last img').length < $('.rowImg:last').data('nbimg')){
            $('.rowImg:last').remove();
        }
    } else {
        populatePattern();
    }
}

var img = [];

<?php foreach($pictures as $picture): ?>
    img.push(["/public/cdn/images/<?php echo $picture['url'] ?>", "/picture/<?php echo $picture['id'] ?>","<?php echo $picture['title'] ?>"]);
<?php endforeach; ?>

$(document).ready(function() {
    console.log("3"+img);
    populatePattern(img);
    populatePattern(img);
    // populatePattern();
    // populatePattern();
    // populatePattern();
});
//
// var processing, fullsize_url, id, title;
// $(document).scroll(function(e){
//
//        if (processing)
//            return false;
//
//        if ($(window).scrollTop() >= ($(document).height() - $(window).height())*0.85){
//             processing = true;
//             // $.ajax({
//             //     url: '/media/loadMore',
//             //     data: {index: $('.containerImg img').length + img.length},
//             //     type: 'POST',
//             //     success: function(datas){
//             //         $.each(datas,function(index,data){
//             //             fullsize_url = (data.fullsize_url != null ? data.fullsize_url : "");
//             //             type = (data.type == "0" ? 'video' : 'photo');
//             //             id = (data.id != null ? data.id : "");
//             //             username = (data.username != null ? data.username : "");
//             //             countryCode = (data.countryCode != null ? data.countryCode : "");
//             //             title = (data.title != null ? data.title : "");
//             //             hits = (data.hits != null ? data.hits : "");
//             //             avg_rating = (data.avg_rating != null ? data.avg_rating : "");
//             //             console.log(data);
//             //             img.push([fullsize_url,type+"/"+id,title,username,countryCode,hits,avg_rating]);
//             //         });
//             //         populatePattern();
//             //         processing = false;
//             //     }
//             // })
//        }
// });
</script>
<div id="content" class="massonry"></div>
