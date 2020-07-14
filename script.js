Vue.config.devtools = true

var vm = new Vue({
  el:'#app',
  data:{
    apiResponse:[],
  },
  methods:{
    callApi: function(){
      var response =  fetch('http://localhost/uppsalastockholm/controller.php').then(
        function(response)
        {
          return response.json();
        }).then(
         function (data) {
          return data.RESPONSE.RESULT[0].TrainAnnouncement;
      }).catch(error => console.log(error));
      return response;
    },
    trimAnswer: function(apiResponse) {
      for (var i = 0; i < apiResponse.length; i++) {
        apiResponse[i].AdvertisedTimeAtLocation = apiResponse[i].AdvertisedTimeAtLocation.substring(11,19);
      }
    }
  },
  mounted: async function(){
    var response = await this.callApi();
    console.log(response);
    this.trimAnswer(response);
    this.apiResponse = response;
  }

})
