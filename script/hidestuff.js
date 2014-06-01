
      function hider()
      {
        $("div.textt").each(function()
        { 
              $(this).children(".syningar").each( function()
              {
                $(this).children("p").each(function()
                {
                  var numspans = $(this).children("span").length;
                  var hiddenspans = 0;
                  $(this).children("span").each(function()
                  {
                    if($(this).attr("class").indexOf("hide")>=0) { hiddenspans++; }
                  });
                  if((numspans-hiddenspans)==0) { $(this).addClass("hide"); }
                });

              });


              var isvisible = 1;
              $(this).children(".syningar").each(function()
              {
                if($(this).children("p").attr("class").indexOf("hide")>=0)
                {
                  isvisible*=1;
                }
                else { isvisible*=0; }
              });

              if(isvisible)
              {
                $(this).parent().parent().addClass("hide");
              }
              else
              {
                $(this).parent().parent().removeClass("hide");
              }              
        });
      }


      function ischeck()
      {
        var m = 0;
        $('.biocheck input[type=checkbox]').each(function () {
            this.checked ? m++ : m*=1;
        });
        //ef ekkert er checkað þá sýnum við allt (þá er m=0)
        if(m>0)
        {
          //Byrjum á að fela allar sýningar
          $("div.syningar").children("p").each(function()  
          {
            $(this).addClass("hide");
          });

          //Ef við einhvað hakað checkbox þá sýnum við samsvarandi kvikmyndahús
          $('.biocheck input[type=checkbox]').each(function()
          {
            var id_of_check = $(this).attr("id");
            if(this.checked)
            {
                $("div.syningar").children("p").each(function()  
                {
                  if($(this).attr("class").indexOf(id_of_check)>=0)
                  {
                      if($(this).attr("class").indexOf("hide")>=0) { $(this).removeClass("hide"); }  
                  }
                
                });
            }
          });
          
        }

        else
        {
          $("div.syningar").children("p").each(function()
          {
            $(this).removeClass("hide"); 
          });
          
        }
        
        hider();
      }
