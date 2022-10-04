<?php


        $responsee[] = array("latitude"=>-1.30225,"longitude"=>36.8060,"place"=>'Westslands');
 


   $jsonlocation=json_encode($responsee);    
     
                     
    ?>
 
 
                         
                         <!-- google map will be shown here -->
    <div id="gmap_canvas" style="height:500px;">Loading map...</div>
    <div id='map-label'>Map shows approximate location.</div>
                         
                         
                         </div>  
                        </div>
                                     
                               
         

             <!-- JavaScript to show google map -->
  <script type="text/javascript"
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBJvgyKaTnOdQOsIPN0JCDIJcbVXQfbqfk"></script>  
    <script type="text/javascript">
   
   
       <?php echo "var loc =". $jsonlocation." ; \n";   ?>
       
   
   
        function init_map() {
         
     
            var myOptions = {
                zoom: 10,
                center: new google.maps.LatLng(-1.23444,36.7456 ),
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            var map = new google.maps.Map(document.getElementById("gmap_canvas"), myOptions);
            var infowindow = new google.maps.InfoWindow();
           
            var marker, i;
           for(i=0;i<loc.length;i++){
           marker = new google.maps.Marker({
           
                position: new google.maps.LatLng(loc[i].latitude, loc[i].longitude),
                animation: google.maps.Animation.DROP,
                    map: map
            });
            google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent(loc[i].formatted_address);
         infowindow.open(map, marker);
        }
      })(marker, i));
    }
        }
       
       
     
        google.maps.event.addDomListener(window, 'load', init_map);
       
       
    </script>


   </section><!-- /.content -->