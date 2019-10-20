

$(document).ready(function()
{

    $(document).on('change','#facility_code',function(){

       
        var mfl = $(this).val();

   $.ajax({
         url: 'aggregations.php',
         type: 'post',
         data: {facility_mfl:mfl},
         dataType: 'json',
        success:function(response)
          {

      var len = response.length;

      $("#registered_count").empty();
      $("#residents_count").empty();
      $("#matched_count").empty();
      $("#matched_positive_count").empty();
      $("#carelink_count").empty();

      for( var i = 0; i<len; i++)
      
        {

          var registered = response[i]['registered'];
          var residents = response[i]['residents'];
          var matched = response[i]['matched'];
          var positive = response[i]['positive'];
          var with_ccc_no = response[i]['with_ccc_no'];
          
        // $('#registered_count').append(registered);
         //$("#residents_count").text(residents);

         $('#registered_count').text(Number(registered).toLocaleString('en'));
         $("#residents_count").text(Number(residents).toLocaleString('en'));
         $("#matched_count").text(Number(matched).toLocaleString('en'));
         $("#matched_positive_count").text(Number(positive).toLocaleString('en'));
         $("#carelink_count").text(Number(with_ccc_no).toLocaleString('en'));

          var percentage_residency=((residents/registered)*100).toFixed(1);
          var percentage_match=((matched/residents)*100).toFixed(1);
          var percentage_positive=((positive/matched)*100).toFixed(1);
          var percentage_carelink=((with_ccc_no/positive)*100).toFixed(1);

          $("#residency_percentage").text(percentage_residency);
          $("#match_percentage").text(percentage_match);
          $("#positive_percentage").text(percentage_positive);
          $("#carelink_percentage").text(percentage_carelink);



    }

  }
});


});



});
