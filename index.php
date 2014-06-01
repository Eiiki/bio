<!DOCTYPE html>
<html lang="is">
  <head>

    <link rel="shortcut icon" href="favicon.ico" /> 
    <title>Í bíó á Íslandi í dag</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" type="text/css" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/ui-lightness/jquery-ui.min.css" />    
    <link rel="stylesheet" type="text/css" href="style/index.css" media="screen" />
    <script src="https://code.jquery.com/jquery-2.1.0.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
    <script src="script/jquery.ui.touch-punch.min.js"></script>
    <script type="text/javascript" src="script/hidestuff.js"></script>

  </head>
  <body>
    
    <section id = "main">
      <div class="stika">
        <br>
        <span>Kvikmyndir sýndar á tímabilinu </span><span id="time" class="time"></span>
        <div id="slider-range" class="slider ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all" aria-disabled="false">
          <div class="ui-slider-range ui-widget-header ui-corner-all" style="left: 0%; width: 100%;"></div><a class="ui-slider-handle ui-state-default ui-corner-all" href="#" style="left: 0%;"></a><a class="ui-slider-handle ui-state-default ui-corner-all" href="#" style="left: 100%;"></a></div>
      </div>

        <?php

          include("getfiles.php"); // þetta include-ar allan getfiles.php fælinn, sem var áður hluti af þessum php kóða
          echo '<div class ="aligner">';
          echo '<ul>';

            echo '<label for="SambíóinÁlfabakka"><li class="biocheck">';
            echo '<input type="checkbox" id="SambíóinÁlfabakka">
                  <span></span>Sambíóin Álfabakka';
            echo '</li></label>';

             echo '<label for="Borgarbíó">';
            echo '<li class="biocheck">';
            echo '<span></span>Borgarbíó<input id="Borgarbíó" type="checkbox">';
             echo '</li>';
             echo '</label>';

            echo '<label for="Laugarásbíó"><li class="biocheck">';
            echo '<input id="Laugarásbíó" type="checkbox">
                  <span></span>Laugarásbíó';
             echo '</li></label>';

            echo '<label for="SambíóinKringlunni"><li class="biocheck">';
            echo '<input type="checkbox" id="SambíóinKringlunni">
                  <span></span>Sambíóin Kringlunni';
             echo '</li></label>';

            echo '<label for="SambíóinEgilshöll"><li class="biocheck">';
            echo '<input type="checkbox" id="SambíóinEgilshöll">
                  <span></span>Sambíóin Egilshöll';
            echo '</li></label>';

            echo '<label for="SambíóinAkureyri"><li class="biocheck">';
            echo '<input type="checkbox" id="SambíóinAkureyri">
                  <span></span>Sambíóin Akureyri';
             echo '</li></label>';

            echo '<label for="Háskólabíó"><li class="biocheck">';
            echo '<input id="Háskólabíó" type="checkbox">
                  <span></span>Háskólabíó';
             echo '</li></label>';

            echo '<label for="SambíóinKeflavík"><li class="biocheck">';
            echo '<input id="SambíóinKeflavík" type="checkbox">
                  <span></span>Sambíóin Keflavík';
             echo '</li></label>';

            echo '<label for="BíóParadís"><li class="biocheck">';
            echo '<input id="BíóParadís" type="checkbox">
                  <span></span>Bíó Paradís';
             echo '</li></label>';

            echo '<label for="Smárabíó"><li class="biocheck">';
            echo '<input id="Smárabíó" type="checkbox">
                  <span></span>Smárabíó';
             echo '</li></label>';

          echo '</ul>';
          echo '</div>';

 
          echo '<div class="aligner">';
          echo '<ul>';

          echo '<li class = "agefilt">';
          echo    '<input type="radio" name="age" id="Öllum" value="Öllum"/>
                  <label for="Öllum">Leyfð öllum</label>';
          echo '</li>';

          echo '<li class = "agefilt">';        
          echo    '<input type="radio" name="age" id="10ára" value="10ára"/>
                    <label for="10ára">10 ára og yngri</label>';
          echo '</li>';

          echo '<li class = "agefilt">';
          echo    '<input type="radio" name="age" id="12ára" value="12ára"/>
                  <label for="12ára">12 ára og yngri</label>'; 
          echo '</li>';

          echo '<li class = "agefilt">';
          echo    '<input type="radio" name="age" id="14ára" value="14ára"/>
                  <label for="14ára">14 ára og yngri</label>'; 
          echo '</li>';

          echo '<li class = "agefilt">';
          echo    '<input type="radio" name="age" id="16ára" value="16ára"/>
                    <label for="16ára">16 ára og yngri</label>'; 
          echo '</li>';

          echo '</ul>';
          echo '</div>';

          echo '<div class = "leit" data-role="fieldcontain">';
            echo '<input type="search" name="search" id="search-basic" placeholder="Leit að mynd" results=5/>';
          echo '</div>';

          /**************Förum nú í að vinna úr upplýsingunum sem við höfum safnað að okkur og birtum þær*********************/
          echo '<section id="movs">';
          echo '<div class="above"><div id="titill1" class="sort">IMDB<span class="einkunn"> einkunn</span></div><div id ="titill2" class="sort">Titill myndar</div><div id="titill3">Nánar</div></div>';
          for($i = 0; $i < sizeof($cinemajson);$i++)
          {
            echo '<div class="gaur">';
            echo '<div class="biomyndd">';
            $title = $cinemajson[$i] -> title;
            $url = $cinemajson[$i] -> image;
            for($x = strlen($url)-1; $x > 0; $x--)
            {
              if($url[$x]==='/')
                break;
            }
            $img = substr($url,$x+1,strlen($url)-1);
            $img = 'images/posters/'.$img;
            $img = '<div class="img"><a href="'.$img.'"><img style ="width:100%;" src="'.$img.'" alt="Mynd fyrir '.$title.'"></a></div>';
            $imdb = $cinemajson[$i] -> imdb;
            if($imdb === '')
              $imdb = '0.0/10 0 atkv.';

            for($x = 0; $x < strlen($imdb); $x++)
            {
              if($url[$x]==='/')
                break;
            }
            $imdb = substr($imdb,0, $x-2);
            $releasedate = $cinemajson[$i] -> released;
            $aldur = $cinemajson[$i] -> restricted;
            $agelmt = '';

            if($aldur ==="Öllum leyfð")
            { 
              $color = "#19BA19";
              $agelmt=substr($aldur,0,6); 
            }
            else if ($aldur ==="10 ára")
            {
             $color = "#FF6666"; $aldur = $aldur.''; 
             $age=substr($aldur,0,2);
              $lmt=substr($aldur,3,4);
              $agelmt=$age.$lmt;
           }
           else if ($aldur ==="12 ára")
            {
             $color = "#FF6666"; $aldur = $aldur.''; 
             $age=substr($aldur,0,2);
              $lmt=substr($aldur,3,4);
              $agelmt=$age.$lmt;
           }
           else if ($aldur ==="14 ára")
            {
             $color = "#FF6666"; $aldur = $aldur.''; 
             $age=substr($aldur,0,2);
              $lmt=substr($aldur,3,4);
              $agelmt=$age.$lmt;
           }
           else if ($aldur ==="16 ára")
            {
             $color = "#FF6666"; $aldur = $aldur.''; 
             $age=substr($aldur,0,2);
              $lmt=substr($aldur,3,4);
              $agelmt=$age.$lmt;
           }
           if(strlen($agelmt)<=0)
           { $agelmt = "Öllum"; $color = "#19BA19"; }

            echo '<div class = "imdb"><span class="text imdbrank">'.$imdb.'</span></div>';
            if($aldur)
            { echo '<div class = "title"><span class="text"><span class = "titler titlerank" data-id="'.strtolower($title).'">'.$title.'('.$releasedate.')</span> <span class="ager"> <span style="color:'.$color.';"><u class='.$agelmt.'>'.$aldur.'</u></span></span></span></div>'; }
            else
            {  echo '<div class = "title"><span class="text">'.$title.'('.$releasedate.') <span style="display:none;">- <span style="color:'.$color.';"><u class='.$agelmt.'>'.$aldur.'</u></span></span></span></div>'; }
            echo '<div class = "nanar">Sjá meira</div>';

            $showtimes = $cinemajson[$i] -> showtimes;
            $str='';
            for($j = 0; $j < sizeof($showtimes);$j++)
            {
              $str=$str.'<div class="syningar">';
              $tmp = $showtimes[$j] -> theater;
              
                $tmp2=str_replace(" ","",$tmp);
             

              $str = $str.'<p class='.$tmp2.'>'.$tmp.': ';
              $schedule = $showtimes[$j] -> schedule;
              for($k=0; $k<sizeof($schedule); $k++)
              {
                            $num = '';
                            for($x = 0; $x < strlen($schedule[$k]); $x++)
                            {
                              if($schedule[$k][$x]===':')
                                break;
                            }
                            $num = $num.''.substr($schedule[$k], 0, $x);
                            $num = $num.''.substr($schedule[$k], $x+1, $x+1);

                if($k+1 == sizeof($schedule))
                {
                  $str = $str.'<span class='.$num.'>'.$schedule[$k].'</span>';
                } else { $str = $str.'<span class='.$num.'>'.$schedule[$k].', </span>'; }
                
              }  
              $str = $str.'</p>';
              $str = $str.'</div>';       
            }
            
                               

            echo '</div>';
      
            echo '<div class="toggler">';
            echo $img; 
            echo '<div class="textt">'.$str.'</div>';
            echo '<div style="clear:both;"></div>';
            echo '</div>';

            echo '</div>';
          }
          echo '</section>';

          /*-----------------------------------------------------------------------------------------------------------------*/
        ?>
    </section>
    <script type="text/javascript" src="script/index.js"></script>
  </body>

</html>