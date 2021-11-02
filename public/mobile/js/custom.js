var host="https://vislog.com.ng/u-safe/public";
//var host="http://localhost/u-safe/public";


function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i < ca.length; i++) {
      var c = ca[i];
      while (c.charAt(0) == ' ') {
        c = c.substring(1);
      }
      if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
      }
    }
    return "";
}

/*page loader*/
var myVar;

function myFunction() {
    myVar = setTimeout(showPage, 300);
}

function showPage() {
    document.getElementById("loader").style.opacity = 0;
    document.getElementById("myDiv").style.opacity = 1;
}

function showLoading(){
    document.getElementById("loader").style.opacity = 1;
    document.getElementById("myDiv").style.opacity = 0.2;
}

var options = {
    enableHighAccuracy: true,
    timeout: 5000,
    maxAge: 0
};
  
function success(pos) {
    var crd = pos.coords;
    
    document.cookie = "lat="+crd.latitude;
    document.cookie = "lng="+crd.longitude;
    document.cookie = "accuracy="+crd.accuracy;

    console.warn('Your current position is:');
    console.warn(`Latitude : ${crd.latitude}`);
    console.warn(`Longitude: ${crd.longitude}`);
    console.warn(`More or less ${crd.accuracy} meters.`);
}
  
function error(err) {

    console.warn(`ERROR(${err.code}): ${err.message}`);
    document.cookie = "lat=0";
    document.cookie = "lng=0";
    document.cookie = "accuracy=100";
}

function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}

$(document).ready(function(e){

    navigator.geolocation.watchPosition(success,error,options);
    //getLocation();

    //$("#loader").hide();
    /**check for window refresh */
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
    
    /*check notification player id*/
    var player_id=getCookie('player_id');
    var user_id=getCookie('user');
    
    if(player_id!=null && user_id!=null){
        var url=host+'/api/update-notification-id/'+player_id+'/'+user_id;
        
        $.ajax({url: url, success: function(result){
            
            console.log(result);
            
        }});
    }

    /**check for user login state */
    var fileName = location.href.split("/").slice(-1);
    if(fileName!='login.html' && fileName!='forgot-password.html'){

        var user=getCookie('user');

        if(user!=""){

            var url=host+'/api/update-location/'+getCookie('user')+'/'+getCookie('lat')+'/'+getCookie('lng');
            $.ajax({url: url, success: function(result){
            
                console.log(result);
        
                if(result=='true'){
        
                    console.log('location updated');
        
                }
                
                
            }});

        }else{
            document.cookie = "user=; expires=Thu, 18 Dec 2018 12:00:00 UTC";
            document.location.href="login.html";
        }

    }
    /*get messages from server*/
    if(fileName=='messages.html'){
        
        showLoading();
        
        var user_id=getCookie('user');
        
        if(user_id!=""){
        
            var display='';
                

            var url=host+'/api/get-notifications/'+user_id;
            $.ajax({url: url, success: function(result){
                
                $(result).each(function(index,item){
                    
                    if(item.status==0){
                        display+="<div class='alert alert-primary'><b>"+item.message+"</b><hr/>"+item.created_at+"<hr/><a href='danger-message.html?id=safe' class='alert-link float-left'>I am safe</a> &nbsp;&nbsp;&nbsp; <a href='danger-message.html?id=safe' class='alert-link float-right'>I am In Danger</a></div>";
                    }else if(item.status==1){
                        display+="<div class='alert alert-success'><b>"+item.message+"</b><hr/>"+item.created_at+"</div>";
                    }else if(item.status==2){
                        display+="<div class='alert alert-danger'><b>"+item.message+"</b><hr/>"+item.created_at+"</div>";
                    }
                    
                    
                });
            
                $("#alert-messages").html(display);
                
                showPage();
                
                
            }});

        }
    }


    /* login process */
    
    $(".login-form").on('submit',function(e){
        e.preventDefault();
        
        var form=$(this);
        showLoading();
        
        var username=$('#username').val();
        var password=$('#password').val();
        
        if(username==''||password==''){
            $("#error-msg span.mdl-textfield__error").html("<b>Oops!</b> All input fields are required");
            $("#error-msg").addClass('is-invalid');
            showPage();
            exit();
        }
        
        var url=host+'/api/login';
        
        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(), // serializes the form's elements.
            success: function(data){
                //alert(data); // show response from the php script.

                console.log('user_id: '+data);
                
                if(data=='false'){
                    $("#error-msg span.mdl-textfield__error").html("<b>Oops!</b> Incorrect login credentials");
                    $("#error-msg").addClass('is-invalid');
                    showPage();
                    //swal('Error','Invalid Login Credentials','error');
                }else{

                    if(!isNaN(data)){
                        setCookie('user',data,365);
                        document.location.href="index.html";
                        showPage();
                    }else{
                        
                        $("#error-msg span.mdl-textfield__error").html("<b>Oops!</b> Incorrect login credentials");
                        $("#error-msg").addClass('is-invalid');
                        showPage();
                    }
                }
                
            }
        });
        
    });
    
    /* password reset form */
    
    $(".reset-form").on('submit',function(e){
        e.preventDefault();
        
        var form=$(this);
        showLoading();
        
        var url=host+'/api/reset-password';
        
        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(), // serializes the form's elements.
            success: function(data){
                //alert(data); // show response from the php script.

                console.log('response: '+data);
                showPage();
                
                if(data=='true'){
                    
                    swal({
                        title:'Success',
                        text: 'A new password has been sent to provided email address',
                        type: 'success'
                    }).then(function(){
                        window.location.href = 'login.html';
                    });
                    
                    
                    //swal('Error','Invalid Login Credentials','error');
                }else{
                    
                    $("#error-msg span.mdl-textfield__error").html("<b>Oops!</b> Account with email address does not exist");

                    $("#error-msg").addClass('is-invalid');
                }
                
            }
        });
    });

    /**incidence report */
    $("#report-form").on('submit',function(e){
        e.preventDefault();
        
        var form=$(this);
        showLoading();
        
        var url=host+'/api/report-incidence';
        console.log(url);
        
        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(), // serializes the form's elements.
            success: function(data){
                //alert(data); // show response from the php script.

                console.log('response: '+data);
                showPage();
                
                if(data=='true'){
                    
                    swal({
                        title:'Success',
                        text: 'Message Sent',
                        type: 'success'
                    }).then(function(){
                        window.location.href = 'index.html';
                    });
                    
                }else{
                    swal('Error','An Error Occurred. please try again','error');
                }
                
            }
        });
        
    });

    /**image upload with preview */
    $("#img1").on('change',function() {
        readURL(this);
    });
    $("#img2").on('change',function() {
        readURL2(this);
    });

    /* get user location information */
    
});
//custom control

function CenterControl(controlDiv, map) {

        // Set CSS for the control border.
        var controlUI = document.createElement('div');
        controlUI.style.backgroundColor = '#fff';
        controlUI.style.boxShadow = '0 2px 6px rgba(0,0,0,.3)';
        controlUI.style.cursor = 'pointer';
        controlUI.style.marginTop = '11px';
        controlUI.style.textAlign = 'center';
        controlUI.title = 'My location';
        controlDiv.appendChild(controlUI);

        // Set CSS for the control interior.
        var controlText = document.createElement('div');
        controlText.style.color = 'rgb(25,25,25)';
        controlText.style.fontFamily = 'Roboto,Arial,sans-serif';
        controlText.style.fontSize = '14pt';
        controlText.style.padding = '5px';
        controlText.innerHTML = '<i class="material-icons">gps_fixed</i>';
        controlUI.appendChild(controlText);

        map.controls[google.maps.ControlPosition.TOP_LEFT].push(controlUI);


        // Setup the click event listeners: simply set the map to Chicago.
        controlUI.addEventListener('click', function() {
          map.setCenter({lat: parseFloat(getCookie('lat')), lng: parseFloat(getCookie('lng'))});
        });

      }


// Initialize and add the map
function initMap(){
    
    var icon = {
        url: "marker2.gif", // url
        scaledSize: new google.maps.Size(50, 50), // scaled size
    };
    var icon2 = {
        url: "map-marker.png", // url
        scaledSize: new google.maps.Size(30, 30), // scaled size
    };
    
    //var pos={lat: 40.417181, lng: -3.700823};
    var pos={lat: parseFloat(getCookie('lat')), lng: parseFloat(getCookie('lng'))};
    
    map = new google.maps.Map(document.getElementById('map'), {
        center: pos,
        zoom: 12
    });
    
    marker = new google.maps.Marker({
        position: pos,
        map: map,
        icon: icon,
        optimized: false
    });
    
    // Create the DIV to hold the control and call the CenterControl()
    // constructor passing in this DIV.
    var centerControlDiv = document.createElement('div');
    var centerControl = new CenterControl(centerControlDiv, map);

    centerControlDiv.index = 1;
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(centerControlDiv);

    //marker.setAnimation(google.maps.Animation.BOUNCE);
    
    //get people near by

    $.ajax({
        type: "GET",
        url: host+'/api/people-near-by/'+getCookie('user'),
        success: function(data){
            //alert(data); // show response from the php script.

            console.log(data);

            // The location of Uluru
            var uluru = {lat: parseFloat(getCookie('lat')), lng: parseFloat(getCookie('lng'))};
            // The map, centered at Uluru
            var map = new google.maps.Map(
            document.getElementById('view2'), {
                zoom: 8, 
                center: uluru,
            });
            // The marker, positioned at Uluru

            var locations = JSON.parse(data);
            console.log(locations);

            var infowindow = new google.maps.InfoWindow();

            var marker, i;

            for (i = 0; i < locations.length; i++) {  
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                map: map,
                icon: icon2
            });

            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                infowindow.setContent(locations[i][0]);
                infowindow.open(map, marker);
                }
            })(marker, i));
            }

            marker = new google.maps.Marker({
                position: new google.maps.LatLng(parseFloat(getCookie('lat')), parseFloat(getCookie('lng'))),
                map: map,
                icon: icon,
                optimized: false
            });
            
            // Create the DIV to hold the control and call the CenterControl()
            // constructor passing in this DIV.
            var centerControlDiv = document.createElement('div');
            var centerControl = new CenterControl(centerControlDiv, map);

            centerControlDiv.index = 1;
            map.controls[google.maps.ControlPosition.TOP_LEFT].push(centerControlDiv);

            //marker.setAnimation(google.maps.Animation.BOUNCE);

            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                infowindow.setContent('Your Location');
                infowindow.open(map, marker);
                }
            })(marker, i));
            
        }
    });
}

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else { 
        console.log("Geolocation is not supported by this browser.");
    }
}

function showPosition(position) {
    document.cookie = "lat="+position.coords.latitude;
    document.cookie = "lng="+position.coords.longitude;
}

function readURL(input) {

  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {
      $('#preview1').attr('src', e.target.result);
    }

    reader.readAsDataURL(input.files[0]);
  }
}
function readURL2(input) {

  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {
      $('#preview2').attr('src', e.target.result);
    }

    reader.readAsDataURL(input.files[0]);
  }
}