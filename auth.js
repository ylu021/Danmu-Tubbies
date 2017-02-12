function onSignIn(googleUser) {
  // Useful data for your client-side scripts:
  var profile = googleUser.getBasicProfile();
  console.log("ID: " + profile.getId()); // Don't send this directly to your server!
  console.log('Full Name: ' + profile.getName());
  console.log('Given Name: ' + profile.getGivenName());
  console.log('Family Name: ' + profile.getFamilyName());
  console.log("Image URL: " + profile.getImageUrl());
  console.log("Email: " + profile.getEmail());
  email = document.getElementById('email')
  email.innerHTML = profile.getEmail()
  // The ID token you need to pass to your backend:
  var id_token = googleUser.getAuthResponse().id_token;
  console.log("ID Token: " + id_token);
  loadAPIClientInterfaces();
};
// /**
//  * This Google APIs JS client automatically invokes this callback function after loading.
//  */
// googleApiClientReady = function() {
//   gapi.auth.init(function() {
//     window.setTimeout(checkAuth, 1);
//   });
// }
//
// /**
//  * This function attempts the immediate OAuth 2.0 client flow as soon as the
//  * page loads. If the currently logged-in Google Account has previously
//  * authorized the client specified as the OAUTH2_CLIENT_ID, then the
//  * authorization succeeds with no user intervention. Otherwise, it fails and
//  * the user interface that prompts for authorization needs to display.
//  */
// function checkAuth() {
//   gapi.auth.authorize({
//     key: 'YOUR_API_KEY',
//     client_id: '1061679501444-mhapvggl4osvb5bm6q3lf2856hi5q6b7.apps.googleusercontent.com',
//     scope: ['https://www.googleapis.com/auth/youtube.force-ssl',
//             'https://www.googleapis.com/auth/youtubepartner'
//           ],
//     immediate: true
//   }, handleAuthResult);
// }
//
// /**
//  * This function handles the result of a gapi.auth.authorize() call.
//  * @param {Object} authResult The result object returned by the gapi.auth.authorize() call.
//  */
// function handleAuthResult(authResult) {
//   if (authResult && !authResult.error) {
//     // Authorization was successful. Hide authorization prompts and show
//     // content that should be visible after authorization succeeds.
//     $('.pre-auth').hide();
//     $('.post-auth').show();
//     loadAPIClientInterfaces();
//   } else {
//     // Make the #login-link clickable. Attempt a non-immediate OAuth 2.0
//     // client flow. The current function is called when that flow completes.
//     $('#auth-button').click(function() {
//       gapi.auth.authorize({
//         client_id: '1061679501444-mhapvggl4osvb5bm6q3lf2856hi5q6b7.apps.googleusercontent.com',
//         scope: ['https://www.googleapis.com/auth/youtube.force-ssl',
//                 'https://www.googleapis.com/auth/youtubepartner'
//         ],
//         immediate: false
//         }, handleAuthResult);
//     });
//   }
// }

/**
 * This function loads the client interface for the API specified in the
 * config data. For more information, see:
 * https://developers.google.com/api-client-library/javascript/reference/referencedocs
 */
function loadAPIClientInterfaces() {
  var apiKey = "AIzaSyCNiO6-GtSC_fqHvfGc2MA_UMTwXOLAn34"
  gapi.client.setApiKey(apiKey)
  gapi.client.load('youtube', 'v3', function() {
    // Code to execute when API client interface is loaded. To test functions,
    // you could automatically call an API function after loading the interface.
    // Here, the makeApiCalls() function is being called. This function is
    // in the sample code if you select 'Show all snippets' for JavaScript.
    console.log('Youtube API loaded!')
    makeApiCalls();
  });
}
