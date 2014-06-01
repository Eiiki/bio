<?php
        
        //Þessi php-kóði sækir cinema og theaters json fælana af apis.is/cinema og apis.is/theaters, vistar þá á
        //heimasvæði þar sem að annað php skjal vinnur úr þeim
        $maxage = 600; //uppfærum json fælinn á $maxage sekúnda fresti
        $dir = 'jsons';
        if(!file_exists($dir))
        {
          mkdir($dir,0777);
        }
        function check_url($url) {

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, 1);
            curl_setopt($ch , CURLOPT_RETURNTRANSFER, 1);
            $data = curl_exec($ch);
            $headers = curl_getinfo($ch);
            curl_close($ch);

            return $headers['http_code'];
        }

        function save_json($file_to_save, $dl_url, $maxage)
        {
          
          if(check_url($dl_url)<400)
          {
            if (!file_exists($file_to_save) || ((file_exists($file_to_save) && filemtime($file_to_save) < (time() - $maxage))))
            {
                $ch = curl_init ($dl_url);
           
                curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
                $json = curl_exec ($ch);

                if(file_exists($file_to_save))
                {
                  unlink($file_to_save);
                }
                  
                file_put_contents($file_to_save, $json);
                
            }
          }
        
          $json = file_get_contents($file_to_save);
          $json = json_decode($json);
          $json = $json -> results;
          
          return $json;
        }

        function save_img($save_dir, $jsonfile, $maxage)
        {
          //Ef mynd er eldri en 2 klukkutímar þá eyði ég henni
          $imagePattern = "/\.(jpg|jpeg|png|gif|bmp|tiff)$/";
          $directory = $save_dir;
          if (($handle = opendir($directory)) != false) 
          {
            while (($file = readdir($handle)) != false) 
            {
              $filename = (string)$directory.''.$file;
              if (strtotime("-2 hours") <= filemtime($filename) && preg_match($imagePattern, $filename)) 
                { unlink($filename); }
            }
            closedir($handle);
          }
          //Ef mynd er eldri en 2 klukkutímar þá eyði ég henni
          $i = 0;
          while($i<sizeof($jsonfile))
          {
            $url = $jsonfile[$i] -> image;
            for($x = strlen($url)-1; $x > 0; $x--)
            {
              if($url[$x]==='/')
                break;
            }
            $myndin = substr($url,$x+1,strlen($url)-1);
            $postersimg = $save_dir.''.$myndin;

            if (!file_exists($postersimg) || (($postersimg) && filemtime($postersimg) < (time() - $maxage)))
            {
              $ch = curl_init ($url);
              curl_setopt($ch, CURLOPT_HEADER, 0);
              curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
              curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
              $raw=curl_exec($ch);
              curl_close ($ch);
              if(file_exists($postersimg)){
                  unlink($postersimg);
              }
              $fp = fopen($postersimg,'w+');
              fwrite($fp, $raw);
              fclose($fp);
            }

            $i++;
          }
        }
        

        /***************Vista cinema.json af  http://apis.is/cinema í jsons möppuna á heimasvæðið mitt *********************/
        //Hér sæki ég json skrána af apis.is ef og aðeins ef það er lengra en 10 mín síðan ég sótti hana síðast eða þá hún sé ekki til
        $file = "cinema.json";
        $json_file = $dir.'/'.$file;
        $dlurl = "http://apis.is/cinema";
        $cinemajson = save_json($json_file, $dlurl, $maxage);
        /*-----------------------------------------------------------------------------------------------------------------*/ 

        /***************Vista theaters.json af  http://apis.is/cinema/theaters í jsons möppuna á heimasvæðið mitt***********/ 
        //Hér sæki ég json skrána af apis.is ef og aðeins ef það er lengra en 10 mín síðan ég sótti hana síðast eða þá hún sé ekki til      
        $file = "theaters.json";
        $json_file = $dir.'/'.$file;
        $dlurl = "http://apis.is/cinema/theaters";
        $theaterjson = save_json($json_file, $dlurl, $maxage);
        /*-----------------------------------------------------------------------------------------------------------------*/ 

        /**************************Vista poster myndir í images/posters möppuna á mínu heimasvæði***************************/
        //Hér sæki ég myndir fyrir kvikmyndirnar af apis.is og vista í posters möppuna ef og aðeins ef það er lengra en 10 mín 
        //síðan eǵ sótti þær síðast    
        $savedir = 'images/posters/';
        save_img($savedir, $cinemajson, $maxage);
        /*-----------------------------------------------------------------------------------------------------------------*/

        /***********************Vista bíóhúsa-myndir í images/biohus möppuna á mínu heimasvæði******************************/
        //Hér sæki ég myndir fyrir kvikmyndahúsin af apis.is og vista í biohus möppuna ef og aðeins ef það er lengra en 10 mín 
        //síðan eǵ sótti þær síðast    
        $savedir = 'images/biohus/';
        save_img($savedir, $theaterjson, $maxage);
        /*-----------------------------------------------------------------------------------------------------------------*/
?>