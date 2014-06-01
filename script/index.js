$(document).ready(function()
{

 $(".stika").click(function() {slideTime()});
 $("li").click(function() {hideage()});
 setInterval(function(){slideTime()},500);


    $("#slider-range").slider({
        range: true,
        min: 720, // minmaxtime()[0],
        max: 1425,// minmaxtime()[1],
        values: [720, 1425], // [minmaxtime()[0],minmaxtime()[1]],
        slide: slideTime
    });

//1. Þetta er slide toggler fyrir sjá meira divinn
//2. Leitarvélin til að finna titla á myndum
//3. Þetta breytir background á checkboxunum fyrir bíóhús þegar þú velur eitthvað bíóhús
//4. Þetta breytir background á radiobutton fyrir aldursfilter þegar þú velur aldur
//5. Loadar fallinu a í hidestuf.js skjalinu fyrir bíómyndaceckboxin 
//6. Raðar eftir titli myndar eða imdb einkunn

//1:
$("div.nanar").bind("click", function(event){
    event.preventDefault();
    $(this).parent().next('.toggler').slideToggle(250).css('display','block');
    $(this).html($(this).html() == "Sjá meira" ? "Sjá minna" : "Sjá meira");
});

//2:
$('input[name="search"]').keyup(function()
{
  $("div.gaur").each( function()
  {
      $(this).find(".titler").each( function()
      {
          var title = $(this).data("id");
          $(this).parents('div.gaur').attr("data-id",title);
      });  
  });
    var result = $('input[name="search"]').val().toLowerCase();

      $("div.gaur").each( function()
      {
        var data_id = $(this).data("id");
        if(data_id.indexOf(result) >= 0)
        {
          $(this).removeClass("hidesearch");
        }
        else $(this).addClass("hidesearch");

      });
});
//3:
$(".biocheck input[type='checkbox']").on('change', function() {
    $(this).closest('.biocheck').toggleClass('biouncheck', this.checked);
});
//4:
$("input[name='age']").change(function()
{
  $(this).closest('.agefilt').toggleClass('agefilt ageuncheck').siblings().removeClass('ageuncheck').addClass('agefilt');
});  

//5:
$(".biocheck").click(function(){
  ischeck();
});

//6: ----------------------------------------------------------------------------------------------
function sortAsc(parent, childSelector, keySelector) {
    var items = parent.children(childSelector).sort(function(a, b) {
        var vA = $(keySelector, a).text();
        var vB = $(keySelector, b).text();
        return (vA < vB) ? -1 : (vA > vB) ? 1 : 0;
    });
    parent.append(items);
}
function sortDesc(parent, childSelector, keySelector) {
    var items = parent.children(childSelector).sort(function(a, b) {
        var vA = $(keySelector, a).text();
        var vB = $(keySelector, b).text();
        return (vA < vB) ? 1 : (vA > vB) ? -1 : 0;
    });
    parent.append(items);
}


/* gefum viðeigandi sortKey attribute */
$('#titill1').data("sortKey", "span.imdbrank");
$('#titill2').data("sortKey", "span.titlerank");


/* röðum og bætum við eða fjarlægjum klasa þegar við smellum á viðeigandi titla */
$("div.sort").click(function() {
   var clss = $(this).attr("class");

   if(clss.indexOf("asc") >= 0)
   {
       $(this).removeClass("asc").addClass("desc");
   }
   else if(clss.indexOf("desc") >= 0)
   {
       $(this).removeClass("desc").addClass("asc");
   }
   else
   {
       $(this).addClass("desc");
   }
    
   if($(this).attr("class").indexOf("desc") >= 0)
   {
       sortDesc($('#movs'), ".gaur", $(this).data("sortKey"));
   }
   else
   {
       sortAsc($('#movs'), ".gaur", $(this).data("sortKey"));
   }
});
//6 endar --------------------------------------------------------------------------------------------


  function slideTime()
  {
      startTime = getTime(converter(0)[0],converter(0)[1]);
      endTime = getTime(converter(1)[0],converter(1)[1]);
      $("#time").text(startTime + ' - ' + endTime);

      hrsmin0 = syningartimar(converter(0)[0], converter(0)[1]);
      hrsmin1 = syningartimar(converter(1)[0], converter(1)[1]);

      var m = 0;
      var cnt = 0;
      $('.biocheck input[type=checkbox]').each(function () {
            cnt++;
            this.checked ? m++ : m*=1;
      });

      $("div.syningar").each( function()
      {
         $(this).children("p").each( function()
           {

           
              //Til að athuga hvort checkbox er checkað eða ekki
              var tmp = $(this).attr("class");
              tmp = tmp.replace("hide","");
              tmp = tmp.replace(" ","");
              var checkad = false;
              
              if(eval(tmp).checked == true) { checkad = true;  }
              //Til að athuga hvort checkbox er checkað eða ekki

            
            var all_hidden = 1;
            $(this).children("span").each( function()
            {
                var time = $(this).attr("class");
                if( (parseInt(time) >= parseInt(hrsmin0)) && (parseInt(time) <= parseInt(hrsmin1)) )                   
                {   
                  $(this).removeClass("hide");
                  all_hidden*=0;
                }
      
                else                   
                {
                 $(this).addClass("hide");
                }
              });
              if(all_hidden) { $(this).addClass("hide"); }
              else { if(checkad || (m==cnt) || (m==0)) { $(this).removeClass("hide"); } }
          }); 

      }); 
    hider();

  }

  function converter(type) 
    {
      var val = $("#slider-range").slider("values", type);
      minutes = parseInt(val % 60, 10);
      hours = parseInt(val / 60 % 24, 10);
      return [hours,minutes];
    }

    function getTime(hours, minutes) 
    {
        var time = null;
        minutes = minutes + "";
      
        if (minutes.length == 1)
        {
            minutes = "0" + minutes;
        }
            return "\n"+hours + ":" + minutes ;
    }


    function hideage() 
    {
       $("div.gaur").each( function()
      {
         $(this).find("u").each( function()
           {
                var age = $(this).attr("class");
                $(this).parents('div.gaur').addClass(age)
           });   
      
            var stika = $('input[name="age"]:checked').val();
        
             if(stika==="10ára")
            {
              $(".16ára.gaur").addClass("hideage");
              $(".14ára.gaur").addClass("hideage");
              $(".12ára.gaur").addClass("hideage");
              $(".10ára.gaur").removeClass("hideage");
              $(".Öllum.gaur").removeClass("hideage");
            }

             if(stika==="12ára")
            {
              $(".16ára.gaur").addClass("hideage");
              $(".14ára.gaur").addClass("hideage");
              $(".12ára.gaur").removeClass("hideage");
              $(".10ára.gaur").removeClass("hideage");
              $(".Öllum.gaur").removeClass("hideage");
            }

             if(stika==="14ára")
            {
              $(".16ára.gaur").addClass("hideage");
              $(".14ára.gaur").removeClass("hideage");
              $(".12ára.gaur").removeClass("hideage");
              $(".10ára.gaur").removeClass("hideage");
              $(".Öllum.gaur").removeClass("hideage");
            }

             if(stika==="16ára")
             { 
                $(".16ára.gaur").removeClass("hideage");
                $(".14ára.gaur").removeClass("hideage");
                $(".12ára.gaur").removeClass("hideage");
                $(".10ára.gaur").removeClass("hideage");
                $(".Öllum.gaur").removeClass("hideage");
             }
             if(stika==="Öllum")
             {
                $(".16ára.gaur").addClass("hideage");
                $(".14ára.gaur").addClass("hideage");
                $(".12ára.gaur").addClass("hideage");
                $(".10ára.gaur").addClass("hideage");
                $(".Öllum.gaur").removeClass("hideage");
             }
       });
    }


   function syningartimar(hours, minutes) 
   {
      hours=hours+'';
      minutes=minutes+'';
      hrsmin=hours+minutes;
      if (hrsmin.length<4)
       {
          var a=hrsmin.substr(0,2);
          var b=hrsmin.substr(2,1);
          hrsmin=a+'0'+b;
       } 
       return hrsmin ;
   }

function minmaxtime()
{
    var allTags = document.body.getElementsByTagName('*');
    var classNames = {};
    for (var tg = 0; tg< allTags.length; tg++)
     {
          var tag = allTags[tg];
          if (tag.className)
          {
                  var classes = tag.className.split(" ");
              for (var cn = 0; cn < classes.length; cn++)
              {
                  var cName = classes[cn];
                  if (! classNames[cName])
                   {
                    classNames[cName] = true;
                  }
               }
          }   
    }
    var classList = [];
    for (var name in classNames)
     if (!isNaN(name))
      classList.push(name);

    var mintime=classList[0]
    mintime= parseInt(mintime.substr(0,2))*60+parseInt(mintime.substr(2,2))
    var maxtime=classList[classList.length-1]
    maxtime= parseInt(maxtime.substr(0,2))*60+parseInt(maxtime.substr(2,2)) 
    return [mintime,maxtime]
}

});

 