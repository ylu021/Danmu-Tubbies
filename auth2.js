var GoogleAuth //the global var
var SCOPE = 'https://www.googleapis.com/auth/youtube.force-ssl https://www.googleapis.com/auth/youtubepartner https://www.googleapis.com/auth/youtube https://www.googleapis.com/auth/youtubepartner-channel-audit'
var KEY = "AIzaSyCNiO6-GtSC_fqHvfGc2MA_UMTwXOLAn34"
var CLIENT = "1061679501444-mhapvggl4osvb5bm6q3lf2856hi5q6b7.apps.googleusercontent.com"

function handleClientLoad() {
  console.log('i still got them ',KEY,CLIENT)
  //this is called directly after page loaded
  //set visibility of button
  // console.log('am i here')
  gapi.load('client:auth2', initClient)
}

function initClient() {
  var discoveryUrl = 'https://www.googleapis.com/discovery/v1/apis/youtube/v3/rest'
  //use for method calls
  //initiate an instance for auth
    gapi.client.init({
      apiKey: KEY,
      client_id: CLIENT,
      scope: SCOPE,
      discoveryDocs: [discoveryUrl]
    }).then(function() {
      //after instance created, save it to the global var
      GoogleAuth = gapi.auth2.getAuthInstance()
      console.log(GoogleAuth)
      // //listen for sign in state
      GoogleAuth.isSignedIn.listen(updateSigninStatus)

      // var user = GoogleAuth.currentUser.get()
      //maybe where I want to get the information
      setSigninStatus()

      //set visibility of button
      $('#grant-auth').click(function() {
        console.log('clicked')
        handleAuthClick()
      })
      $('#revoke-auth').click(function() {
        revokeAccess()
      })
    })


}

function handleAuthClick() {
  if(GoogleAuth.isSignedIn.get()){
    var googleUser = GoogleAuth.currentUser.get()

    GoogleAuth.signOut().then(()=>{
      console.log('you are out')
      window.location = "./"
    })
  }
  else
    GoogleAuth.signIn()
}

function revokeAccess() {
  GoogleAuth.disconnect()
}

function setSigninStatus(isSignedIn) {
  var googleUser = GoogleAuth.currentUser.get()
  console.log(googleUser)
  //second place to get information
  var isAuth = googleUser.hasGrantedScopes(SCOPE)
  if(isAuth) {
      $('.search').css('display', 'block')
      $('#grant-auth').html('Sign out') //change to sign out
      var apiKey = "AIzaSyCNiO6-GtSC_fqHvfGc2MA_UMTwXOLAn34"
      gapi.client.setApiKey(apiKey)
      gapi.client.load('youtube', 'v3', function() {
        // Code to execute when API client interface is loaded. To test functions,
        // you could automatically call an API function after loading the interface.
        // Here, the makeApiCalls() function is being called. This function is
        // in the sample code if you select 'Show all snippets' for JavaScript.
        console.log('Youtube API loaded!')
        onSignIn(googleUser)
        makeApiCalls()
      })
      // // alert(window.location.pathname)
      // if(window.location.pathname=="/landing.php"){
      //   window.location = '/'
      // }else{
      //   console.log('finally')
      // }

  }else {
      $('#grant-auth').html('Sign in') //change to sign out
      console.log(window.location.pathname)
      if(window.location.pathname!="/"){
        window.location = '/'
      }else{
        console.log('finally')
      }

  }
}

function onSignIn(googleUser) {
  // Useful data for your client-side scripts:
  var profile = googleUser.getBasicProfile();
  console.log("ID: " + profile.getId()); // Don't send this directly to your server!
  console.log('Full Name: ' + profile.getName());
  console.log('Given Name: ' + profile.getGivenName());
  console.log('Family Name: ' + profile.getFamilyName());
  console.log("Image URL: " + profile.getImageUrl());
  console.log("Email: " + profile.getEmail());

  // The ID token you need to pass to your backend:
  var id_token = googleUser.getAuthResponse().id_token;
  console.log("ID Token: " + id_token)
  var xhr = new XMLHttpRequest()
  xhr.open('POST', './signin.php')
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
  xhr.onload = function() {
    console.log('Signed in as: ' + this.responseText); //after the validation call
    if(this.responseText == 'invalid') {
      window.location = "./404.php"
    }else{
      email = document.getElementById('email')
      email.innerHTML = profile.getEmail()
      var xhr2 = new XMLHttpRequest()
      xhr2.open('POST', './formpost.php')
      xhr2.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
      xhr2.onload = function() {
        console.log('Confirmed: ' + this.responseText); //after the
        makeApiCalls()
      }
      xhr2.send('email='+profile.getEmail()+'&name='+profile.getName())
    }
  };
  xhr.send('client_id='+ CLIENT +'&idtoken='+id_token)
  // xhr.send('idtoken=' + id_token);
};

function updateSigninStatus(isSignedIn) {
  setSigninStatus()
}
