<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

  <script>
      function validateYouTubeUrl()
{
    var p = document.getElementById('share');
    var url = $('#videolist_url').val();
        if (url != undefined || url != '') {
            var regExp = /^(?:https?:\/\/)?(?:m\.|www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;
            if(url.match(regExp)){
//console.log('true');

p.removeAttribute("hidden");
  //  document.getElementById('share').style.visibility = "visible";


return url.match(regExp)[1];
        
    }
    else{
        
   // console.log('false');
    p.setAttribute("hidden", true)
   
}
        }
};
  </script>
