<?php  echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">    
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><?php echo $heading_title; ?></h3>
      </div>
      <div class="panel-body">
        <div class="container">
    <div class="row">
      <div class="text">
      
    </div>
    <meta charset = "UTF-8" />
    <form id="form"  class="form-inline" method="POST">

      Merchant Ref No:    <input type="text" name="token"  placeholder="Merchant Ref No." required/>
      Date:    <input type="date" name="date" placeholder="dd-mm-YYYY" required/>  
      <input type="hidden" name="mrctCode" value="<?php echo $mrc_code;?>"/>          
      <input type="hidden" name="currency" value="<?php echo $currency;?>"/>          
         &nbsp; &nbsp; &nbsp;   <button id="btnSubmit" type="submit" class="btn btn-primary" name="submit" value="Submit" >Submit</button>
      </form>
      <br>
    <br>
      <p></p>
    </div>
    <br>
    <br>
      </div>
    </div>
  </div>
</div>
<script>
$(document).ready(function(){
  $("#btnSubmit").click(function(e){
    e.preventDefault();
    var str = $("#form").serializeArray();
 
    function formatDate (dateString) {
   var p = dateString.split(/\D/g);
  return [p[2],p[1],p[0] ].join("-");
  }
if(str[1].value !='' && str[0].value !='' && str[2].value !=''){
var dateformated = formatDate(str[1].value);

    var data = {
   "merchant": {
    "identifier": str[2].value
  },
  "transaction": {
    "deviceIdentifier": "S",
    "currency": str[3].value,
     "identifier": str[0].value,        
     "dateTime": dateformated,  
    "requestType": "O"
  }
};

var myJSON = JSON.stringify(data);
    
    $.ajax({
      type: 'POST',
      url: "https://www.paynimo.com/api/paynimoV2.req",
      data: myJSON,
      beforeSend: function() {
        $("p").html("");
        $("p").append('Loading......');
    },
      success: function(resultData) { 
        
        var response=JSON.stringify(resultData);
        $("p").html("");
         $("p").append('<div class="container"><div class="col-12 col-sm-6"><table class="table table-bordered"><tbody><tr><th>Status Code</th><th>'+resultData.paymentMethod.paymentTransaction.statusCode+'</th></tr><tr><th>Merchant Transaction Reference No</th><th>'+resultData.merchantTransactionIdentifier+'</th></tr><tr><th>TPSL Transaction ID</th><th>'+resultData.paymentMethod.paymentTransaction.identifier+'</th></tr><tr><th>Amount</th><th>'+resultData.paymentMethod.paymentTransaction.amount+'</th></tr><tr><th>Message</th><th>'+resultData.paymentMethod.paymentTransaction.errorMessage+'</th></tr><tr><th>Status Message</th><th>'+resultData.paymentMethod.paymentTransaction.statusMessage+'</th></tr><tr><th>Date Time</th><th>'+resultData.paymentMethod.paymentTransaction.dateTime+'</th></tr></tbody></table></div></div>');
        
      }
});
  }else{
    alert('Please Fill All Fields');
  }
  });
});
</script>
<?php echo $footer; ?>