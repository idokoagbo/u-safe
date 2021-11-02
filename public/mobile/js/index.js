/*
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 */
var app = {
    // Application Constructor
    initialize: function() {
        this.bindEvents();
    },
    // Bind Event Listeners
    //
    // Bind any events that are required on startup. Common events are:
    // 'load', 'deviceready', 'offline', and 'online'.
    bindEvents: function() {
        document.addEventListener('deviceready', this.onDeviceReady, false);
    },
    // deviceready Event Handler
    //
    // The scope of 'this' is the event. In order to call the 'receivedEvent'
    // function, we must explicitly call 'app.receivedEvent(...);'
    onDeviceReady: function() {
        app.receivedEvent('deviceready');
    },
    // Update DOM on a Received Event
    receivedEvent: function(id) {
        /*var parentElement = document.getElementById(id);
        var listeningElement = parentElement.querySelector('.listening');
        var receivedElement = parentElement.querySelector('.received');

        listeningElement.setAttribute('style', 'display:none;');
        receivedElement.setAttribute('style', 'display:block;');*/
        
        //alert('Received Event: ' + id);

        console.log('Received Event: ' + id);
        
        // Enable to debug issues.
      // window.plugins.OneSignal.setLogLevel({logLevel: 4, visualLevel: 4});
        
        
        
        function alertDismissed() {
            // do something
        }
        
        function onConfirm(buttonIndex) {
            
            if(buttonIndex==2){
                //safe
                
                document.location.href='danger-message.html?id=safe';
            }else if(buttonIndex==1){
                //danger
                
                document.location.href='danger-message.html?id=safe';
            }else{
                navigator.notification.alert('Unknown Selection', alertDismissed, 'Headcount', 'Dismiss');
            }
            
        }

      var notificationOpenedCallback = function(jsonData) {
          console.log('notificationOpenedCallback: ' + JSON.stringify(jsonData));
          
          //alert('notificationOpenedCallback: ' + JSON.stringify(jsonData));
          
          if(jsonData.action.type==0){
              navigator.notification.confirm(
                  jsonData.notification.payload.body,  // message
                  onConfirm,         // callback
                  'Incident Notification',            // title
                  ['I am in Danger','I am Safe']                  // buttonName
              );
          }else{
              
              if(jsonData.action.actionID=='safe-button'){
                  //safe
                  document.location.href='danger-message.html?id=safe';
              }else if(jsonData.action.actionID=='danger-button'){
                  //danger
                  document.location.href='danger-message.html?id=safe';
              }else{
                  alert('Unknown Selection '+JSON.stringify(jsonData.action.actionID));
              }
          }
          
      };
        

      window.plugins.OneSignal
        .startInit("405d4fc3-134c-4d95-9fa7-b1bf200dc625")
        .handleNotificationOpened(notificationOpenedCallback)
        .inFocusDisplaying(window.plugins.OneSignal.OSInFocusDisplayOption.Notification)
        .endInit();
        
        window.plugins.OneSignal.getPermissionSubscriptionState(function(status) {
            //idapp = status.subscriptionStatus.userId;
            document.cookie = "player_id="+status.subscriptionStatus.userId;
        });
    }
    
};
