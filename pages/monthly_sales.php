<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-info">
            <h4 class="card-title">Monthly Sales</h4>
            <p class="card-category"> Generate monthly sales report</p>
          </div>
          <div class="card-body">
            <table style="width:100%;">
                <th style="width:20%;">
                  <label class="input-group-addon"><strong> Date: </strong></label>
                  <select class="form-control" style="height: 34px;" id='sales_year' required>
                    <?php
                      $year = date("Y") - 2;
                      for($i = 0; $i <= 4; $i++){ ?>
                      
                        <option value='<?php echo $year; ?>' <?php if($year == date("Y")){ echo 'selected'; }?>><?php echo $year; ?></option>;
                      
                      <?php
                      $year++; }
                      ?>
                  </select>
                </th> 
                <th style="width:50%;padding-top: 28px;">
                    <button class="btn btn-success" id="btn_generate_report" onclick="generate_sales()"><span class='material-icons'>refresh</span> Generate Report</button>
                    <button class="btn btn-default" type="button" onClick="printDiv('sales_report');"><span class="material-icons">local_printshop</span> Print Report</button>
                </th>
            </table>
            <div class="container-fluid" id="sales_report">
                <div align="center" style="font-weight:bold;margin-top:20px;">
                    <h3><?= getHotel($_SESSION['hotel_id']); ?></h3>
                </div>
                <div align="center" style="font-weight:bold; margin-bottom:30px;">
                    Monthly Sales Report<br>
                    <span id='report_desc'></span>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr style="background: #607D8B;color:#fff;">
                            <th style="padding: 5px;"></th>
                            <th style="padding: 5px;">MONTH</th>
                            <th style="padding: 5px;">SALES</th>
                        </tr>
                    </thead>
                    <tbody id="sales_report_data">
                    </tbody>
                </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- MODAL START -->
<!-- MODAL END -->
<script>
function generate_sales(){
	var sales_year = $("#sales_year").val();
	
	$("#btn_generate_report").prop('disabled', true);
	$("#btn_generate_report").html("<span class='icon-refresh'></span> Loading ...");
	
	if(sales_year == ""){
		alert("Please fill-out required fields.");
		$("#btn_generate_report").prop('disabled', false);
		$("#btn_generate_report").html("<span class='material-icons'>refresh</span> Generate Report");
	}else{
		$.ajax({
			type:"POST",
			url:"ajax/monthly_sales.php",
			data:{
				sales_year:sales_year
			},
			success:function(data){
				$("#sales_report_data").html(data);
				//alert(data);
				$("#report_desc").html("For the Year "+sales_year+" ");
				$("#btn_generate_report").prop('disabled', false);
				$("#btn_generate_report").html("<span class='material-icons'>refresh</span> Generate Report");
			}
		});
	}
}
function printDiv(sales_report){
	var printContents = document.getElementById(sales_report).innerHTML;
	var originalContents = document.body.innerHTML;
	document.body.innerHTML = printContents;
	window.print();
	document.body.innerHTML = originalContents;
}

$(document).ready(function (){
	generate_sales();
});
</script>