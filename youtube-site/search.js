function searchListByKeyword(part, maxResults, q, type) {
  var request = gapi.client.youtube.search.list(
      {maxResults: maxResults,
       part: part,
       q: q, //query searching for surfing
       type: type});
  executeRequest(request);//is this written?
}

//after API loaded this is necessary
function handleAPILoaded() {
  document.getElementById('search').disabled = false
  message = document.getElementById('message')
  videolist = searchListByKeyword('snippet', 10, 'surfing', 'video')
  if(videolist) {
    //there are videos

    if(videolist.items.length!=0){
      console.log('there are more videos')
      searchcontainer = document.getElementById('searchresult')
      searchcontainer.innerHTML = '<pre>'+JSON.stringify(videolist.items)+'</pre>'
    }else
      message.innerHTML = 'there are no results'
  }else {
    //there are no results
      message.innerHTML = 'there are no videos'
  }
}
