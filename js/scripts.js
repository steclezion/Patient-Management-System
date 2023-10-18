/*******************************************************************************
 * Simplified PHP Invoice System                                                *
 *                                                                              *
 * Version: 1.1.1	                                                               *
 * Author:  James Brandon                                    				   *
 *******************************************************************************/

$(document).ready(function () {

	// Invoice Type
	$('#invoice_type').change(function () {
		var invoiceType = $("#invoice_type option:selected").text();
		$(".invoice_type").text(invoiceType);
	});

	  //Initialize Select2 Elements
	  $('.select2').select2();

	  //Initialize Select2 Elements
	  $('.select2bs4').select2({
		theme: 'bootstrap4'
	  });

	  
	// Load dataTables
	$("#data-table").dataTable();


		// Load dataTables
		$("#data-tablee").dataTable();

	// add product
	$("#action_add_product").click(function (e) {
		e.preventDefault();
		actionAddProduct();
	});

	// password strength
	var options = {
		onLoad: function () {
			$('#messages').text('Start typing password');
		},
		onKeyUp: function (evt) {
			$(evt.target).pwstrength("outputErrorList");
		}
	};
	$('#password').pwstrength(options);

	// add user
	$("#action_add_user").click(function (e) {
		e.preventDefault();
		actionAddUser();
	});

	// update customer
	$(document).on('click', "#action_update_user", function (e) {
		e.preventDefault();
		updateUser();
	});

	// delete user
	$(document).on('click', ".delete-user", function (e) {
		e.preventDefault();

		var userId = 'action=delete_user&delete=' + $(this).attr('data-user-id'); //build a post data structure
		var user = $(this);

		$('#delete_user').modal({
			backdrop: 'static',
			keyboard: false
		}).one('click', '#delete', function () {
			deleteUser(userId);
			$(user).closest('tr').remove();
		});
	});

	// delete customer
	$(document).on('click', ".delete-customer", function (e) {
		e.preventDefault();

		var userId = 'action=delete_customer&delete=' + $(this).attr('data-customer-id'); //build a post data structure
		var user = $(this);

		$('#delete_customer').modal({
			backdrop: 'static',
			keyboard: false
		}).one('click', '#delete', function () {
			deleteCustomer(userId);
			$(user).closest('tr').remove();
		});
	});

	// Delete Doctor
	$(document).on('click', ".delete-doctor", function (e) {
		e.preventDefault();

		var userId = 'action=delete_doctor&delete=' + $(this).attr('data-doctor-id'); //build a post data structure
		var user = $(this);

		$('#delete_doctor').modal({
			backdrop: 'static',
			keyboard: false
		}).one('click', '#delete', function () {
			deleteCustomer(userId);
			$(user).closest('tr').remove();
		});
	});



	// update customer
	$(document).on('click', "#action_update_customer", function (e) {
		e.preventDefault();
		updateCustomer();
	});


	//Update Doctor
	$(document).on('click', "#action_update_doctor", function (e) {
		e.preventDefault();
		updateDoctor();
	});

	// update product
	$(document).on('click', "#action_update_product", function (e) {
		e.preventDefault();
		updateProduct();
	});

	// login form
	$(document).bind('keypress', function (e) {
		e.preventDefault;

		if (e.keyCode == 13) {
			$('#btn-login').trigger('click');
		}
	});

	$(document).on('click', '#btn-login', function (e) {
		e.preventDefault;
		actionLogin();
		//alert("sam how are you");

	});

	// download CSV
	$(document).on('click', ".download-csv", function (e) {
		e.preventDefault;

		var action = 'action=download_csv'; //build a post data structure
		downloadCSV(action);

	});

	// email invoice
	$(document).on('click', ".email-invoice", function (e) {
		e.preventDefault();

		var invoiceId = 'action=email_invoice&id=' + $(this).attr('data-invoice-id') + '&email=' + $(this).attr('data-email') + '&invoice_type=' + $(this).attr('data-invoice-type') + '&custom_email=' + $(this).attr('data-custom-email'); //build a post data structure
		emailInvoice(invoiceId);
	});

	// delete invoice
	$(document).on('click', ".delete-invoice", function (e) {
		e.preventDefault();

		var invoiceId = 'action=delete_invoice&delete=' + $(this).attr('data-invoice-id'); //build a post data structure
		var invoice = $(this);

		$('#delete_invoice').modal({
			backdrop: 'static',
			keyboard: false
		}).one('click', '#delete', function () {
			deleteInvoice(invoiceId);
			$(invoice).closest('tr').remove();
		});
	});



		// Lab Inquiries
		$(document).on('click', ".lab_inquiries", function (e) {
			e.preventDefault();
	
			var invoiceId = 'action=delete_invoice&delete=' + $(this).attr('data-invoice-id'); //build a post data structure
			var invoice = $(this);
			document.getElementById('invoice_id').innerHTML =  $(this).attr('data-invoice-id');


			$('#lab_inquiries').modal({
				backdrop: 'static',
				keyboard: false
			}).one('click', '#delete', function () {
				
				$(invoice).closest('tr').remove();
			});
		});


				// Submit To DR
				$(document).on('click', "#submit_lab_requeste_to_dr", function (e) {
					e.preventDefault();

					var hematology_status = document.getElementById('data-hematology_status').value ;
					var liver_status = document.getElementById('data-liver_status').value ;
					var renal_status = document.getElementById('data-renal_status').value ;
					var lipid_status = document.getElementById('data-lipid_status').value ;
					var sender_id = document.getElementById('data-sender_id').value ;
                    
					var count =0 ;
					if( hematology_status == 1) { count ++;}  if( liver_status == 1) { count ++;}  if( lipid_status== 1) { count ++;} if( renal_status == 1) { count ++;}
			
					if(count ==  0 ) {  alert ("No Test has been conducted: First Submit Test and Proceed with Submitting results to DR."); return false};

					if (confirm("Are sure you want to submit the above Test to Doctor")){ }else { return false; }


					var invoice = document.getElementById('invoice_di_hematology').value;

				//	alert(invoice);

 var action = "Submit_To_DR";

 function request_from_dr_for_lab()
 {
  window.location = "request_from_dr_for_lab.php";
}

					$.ajax({

						url: 'response.php',
						type: 'POST',
						data: {

							action : action,
							invoice : invoice,
							sender_id : sender_id,
						},
						dataType: 'json',
						success: function (data) {

							document.getElementById('submit_lab_requeste_to_dr').innerHTML = "Posting to Dr........";
							document.getElementById('submit_lab_requeste_to_dr').disabled = true;

							var priority = 'success';
							var title    = 'From Labarotry';
							var message  = data.message;
			
							setTimeout(function(){
								$.toaster({ priority : priority, title : title, message : message });
							
							}, 500);

							setInterval(request_from_dr_for_lab, 4000);
							
						               },
					
					});
				});


//hematology
$(document).on('click', "#hematology", function (e) {
	//e.preventDefault();
	


if(document.getElementById('hematology').checked == true)
{
	
	document.getElementById('hematology_test').style.display = "block";
	document.getElementById('list_hema').style.display = "block";
	$(".collapse").collapse('hide');
	//$("#colp").html('<i style="color:blue" class="glyphicon glyphicon-plus-sign"  id="collapse_one"> </i>');


}

if(document.getElementById('hematology').checked == false)
{

	document.getElementById('hematology_test').style.display = "none";
	document.getElementById('list_hema').style.display = "none";
	
	$(".collapse").collapse('hide');
	$("#colp").html('<i style="color:blue" class="glyphicon glyphicon-plus-sign"  id="collapse_one"> </i>');


	
}


});


$('#collapse_one').click(function() {

	$('.panel-title').find('i').toggleClass('glyphicon glyphicon-plus-sign glyphicon glyphicon-minus-sign')
	
});




//hematology
$(document).on('click', "#hematologyy", function (e) {
	//e.preventDefault();
	

	
if(document.getElementById('hematologyy').checked == true)
{
	
	//document.getElementById('hematology_test').style.display = "block";

	document.getElementById('list_hema').style.display = "block";
}

if(document.getElementById('hematologyy').checked == false)
{

	''
	document.getElementById('list_hema').style.display = "none";
	
}


});



//Lipid


$(document).on('click', "#lipid", function (e) {
	//e.preventDefault();

if(document.getElementById('lipid').checked == true)
{

	document.getElementById('lipid_test').style.display = "block";
}

if(document.getElementById('lipid').checked == false)
{

	document.getElementById('lipid_test').style.display = "none";
	
}


});




//Liver


$(document).on('click', "#liver", function (e) {
	//e.preventDefault();

if(document.getElementById('liver').checked == true)
{

	document.getElementById('liver_test').style.display = "block";
}

if(document.getElementById('liver').checked == false)
{

	document.getElementById('liver_test').style.display = "none";
	
}


});




//Renal


$(document).on('click', "#renal", function (e) {
	//e.preventDefault();

if(document.getElementById('renal').checked == true)
{

	document.getElementById('renal_test').style.display = "block";
}

if(document.getElementById('renal').checked == false)
{

	document.getElementById('renal_test').style.display = "none";
	
}


});



//lab_request_from_dr_done
$(document).on('click', ".lab_request_from_dr_done", function (e) {

 document.getElementById('submit_lab_requeste_to_dr').style.display = 'none';
 document.getElementById('submit_lab_requeste_to_test_renal').style.display = 'none';
 document.getElementById('submit_lab_requeste_to_test_liver').style.display = 'none';
 document.getElementById('submit_lab_requeste_to_test_hematology').style.display = 'none';
 document.getElementById('submit_lab_requeste_to_test_lipid').style.display = 'none';

 



	e.preventDefault();
	$('#commentForm')[0].reset();
	$(".required").parent().removeClass("has-error");
	$("#commentForm").find(':input:disabled').removeAttr('disabled');


	
 document.getElementById('hematology').checked = false;
 document.getElementById('lipid').checked = false;
 document.getElementById('liver').checked = false;
 document.getElementById('renal').checked = false;
	   

 document.getElementById('patient_name').innerHTML = $(this).attr('data-pname');
 document.getElementById('patient_age').innerHTML = $(this).attr('data-page');
 document.getElementById('patient_gender').innerHTML = $(this).attr('data-gender');
 document.getElementById('patient_test_date').innerHTML = $(this).attr('data-ptest_date');
 document.getElementById('referred_by').innerHTML = $(this).attr('data-prefred_by');



 document.getElementById('lipid_patient_name').innerHTML = $(this).attr('data-pname');
 document.getElementById('lipid_patient_age').innerHTML = $(this).attr('data-page');
 document.getElementById('lipid_patient_gender').innerHTML = $(this).attr('data-gender');
 document.getElementById('lipid_patient_test_date').innerHTML = $(this).attr('data-ptest_date');
 document.getElementById('lipid_referred_by').innerHTML = $(this).attr('data-prefred_by');   


 document.getElementById('liver_patient_name').innerHTML = $(this).attr('data-pname');
 document.getElementById('liver_patient_age').innerHTML = $(this).attr('data-page');
 document.getElementById('liver_patient_gender').innerHTML = $(this).attr('data-gender');
 document.getElementById('liver_patient_test_date').innerHTML = $(this).attr('data-ptest_date');
 document.getElementById('liver_referred_by').innerHTML = $(this).attr('data-prefred_by');



 
 document.getElementById('renal_patient_name').innerHTML = $(this).attr('data-pname');
 document.getElementById('renal_patient_age').innerHTML = $(this).attr('data-page');
 document.getElementById('renal_patient_gender').innerHTML = $(this).attr('data-gender');
 document.getElementById('renal_patient_test_date').innerHTML = $(this).attr('data-ptest_date');
 document.getElementById('renal_referred_by').innerHTML = $(this).attr('data-prefred_by');




  
 document.getElementById('hema_patient_name').innerHTML = $(this).attr('data-pname');
 document.getElementById('hema_patient_age').innerHTML = $(this).attr('data-page');
 document.getElementById('hema_patient_gender').innerHTML = $(this).attr('data-gender');
 document.getElementById('hema_patient_test_date').innerHTML = $(this).attr('data-ptest_date');
 document.getElementById('hema_referred_by').innerHTML = $(this).attr('data-prefred_by');




	var invoiceId = 'action=delete_invoice&delete=' + $(this).attr('data-invoice-id'); //build a post data structure

	var invoice_di = $(this).attr('data-invoice-di');
	
	document.getElementById('invoice_di').value = invoice_di  ;
	document.getElementById('invoice_di_liver').value = invoice_di  ;
	document.getElementById('invoice_di_renal').value = invoice_di  ;
	document.getElementById('invoice_di_hematology').value = invoice_di  ;


	document.getElementById('h_patient_name').value = $(this).attr('data-pname'); ;
	document.getElementById('h_patient_age').value = $(this).attr('data-page');
	document.getElementById('h_patient_gender').value = $(this).attr('data-gender');
	document.getElementById('h_ptest_date').value = $(this).attr('data-ptest_date');
	document.getElementById('h_ptest_prefred_by').value = $(this).attr('data-prefred_by');


	document.getElementById('data-hematology_status').value = $(this).attr('data-hematology_status');
	document.getElementById('data-liver_status').value = $(this).attr('data-liver_status'); 
	document.getElementById('data-renal_status').value = $(this).attr('data-renal_status');
	document.getElementById('data-lipid_status').value = $(this).attr('data-lipid_status');
	document.getElementById('data-sender_id').value = $(this).attr('data-Sender_id');


	var hematology =  $(this).attr('data-hematology');
	var lipid = $(this).attr('data-lipid');
	var renal = $(this).attr('data-renal');
	var liver =$(this).attr('data-liver');

	
	var hematology_status = $(this).attr('data-hematology_status');
	var hematology_generated_file_path =  $(this).attr('data-hematology_generated_file_path');

	var lipid_status = $(this).attr('data-lipid_status');
	var lipid_generated_file_path = $(this).attr('data-lipid_generated_file_path');


	var liver_status = $(this).attr('data-liver_status');
	var liver_generated_file  = $(this).attr('data-liver_generated_file');




	var renal_status = $(this).attr('data-renal_status');
	var renal_generated_file  = $(this).attr('data-renal_generated_file');

if( hematology_status   == 1) {

		document.getElementById('print_hematology').style.display= 'block';$('#print_hematology').attr("href", hematology_generated_file_path);
		document.getElementById('hgh').value =   $(this).attr('data-hgh');
		document.getElementById('bf_malaria').value =   $(this).attr('data-bf_malaria');
		document.getElementById('TWBC').value = $(this).attr('data-TWBC');
		document.getElementById('diff').value =  $(this).attr('data-diff');

		document.getElementById('vdrl').value =  $(this).attr('data-vdrl');
		document.getElementById('widal').value =  $(this).attr('data-widal');
		document.getElementById('others_hematology').value =  $(this).attr('data-others_hematology');
		document.getElementById('reaction_color').value =  $(this).attr('data-reaction_color');
		document.getElementById('Mucus').value =  $(this).attr('data-mucus');
		document.getElementById('urine_Albumin').value =  $(this).attr('data-urine_Albumin');
		document.getElementById('urine_sugar').value =  $(this).attr('data-urine_sugar');
		document.getElementById('urine_acetone').value =  $(this).attr('data-urine_acetone');
		document.getElementById('urine_bile_pigment').value =  $(this).attr('data-urine_bile_pigment');
		document.getElementById('pus_Cell_microsocopy').value =  $(this).attr('data-pus_Cell_microsocopy');

		document.getElementById('crystal').value =  $(this).attr('data-crystal');
		document.getElementById('RBC').value = $(this).attr('data-RBC');
		document.getElementById('EPC').value =  $(this).attr('data-EPC');
		document.getElementById('ova').value =  $(this).attr('data-ova');
		document.getElementById('others').value =  $(this).attr('data-others');
		document.getElementById('RBS').value =  $(this).attr('data-RBS');
		document.getElementById('ERS').value =  $(this).attr('data-ERS');
		document.getElementById('Morphology').value =  $(this).attr('data-Morphology');

		document.getElementById('HCG').value =  $(this).attr('data-HCG');
		document.getElementById('H_pylori').value =  $(this).attr('data-H_pylori');
		document.getElementById('Brucella_Test').value =  $(this).attr('data-Brucella_Test');
		document.getElementById('HGB').value =  $(this).attr('data-HGB');
		document.getElementById('color_stool').value =  $(this).attr('data-color_stool');
		document.getElementById('Consist').value =  $(this).attr('data-Consist');
		document.getElementById('Reaction').value =  $(this).attr('data-Reaction');
		document.getElementById('Blood').value =  $(this).attr('data-Blood');
		document.getElementById('Worms').value =  $(this).attr('data-worms');
		document.getElementById('Pus_Cells_direct_microscopy').value =  $(this).attr('data-Pus_Cells_direct_microscopy');
		document.getElementById('RBCS').value =  $(this).attr('data-RBCS');
		document.getElementById('o_p').value =  $(this).attr('data-o_p');

		document.getElementById('HIV').value =  $(this).attr('data-HIV');
		document.getElementById('HBV').value =  $(this).attr('data-HBV');
		document.getElementById('HCV').value =  $(this).attr('data-HCV');
		document.getElementById('FBS').value =  $(this).attr('data-FBS');



} else if (hematology_status  != 1) { document.getElementById('print_hematology').style.display= 'none';}



if( lipid_status  == 1) {
document.getElementById('print_lipid').style.display= 'block';$('#print_lipid').attr("href", lipid_generated_file_path);
document.getElementById('tchol').value =   $(this).attr('data-tchol');
document.getElementById('TG').value =   $(this).attr('data-tg');
document.getElementById('HDLC').value = $(this).attr('data-hdlc');
document.getElementById('LDLC').value =  $(this).attr('data-ldlc');
} else if (lipid_status  != 1) { document.getElementById('print_lipid').style.display= 'none';}




if( liver_status  == 1) {
document.getElementById('print_liver').style.display= 'block';
$('#print_liver').attr("href", liver_generated_file);

document.getElementById('total_protien').value = $(this).attr('data-total_protien');
document.getElementById('alb').value = $(this).attr('data-alb');
document.getElementById('ast').value = $(this).attr('data-ast');
document.getElementById('ggt').value = $(this).attr('data-ggt');
document.getElementById('tbil').value = $(this).attr('data-tbil');
document.getElementById('dbil').value = $(this).attr('data-dbil');
document.getElementById('alp').value = $(this).attr('data-alp');

} else if (liver_status !=  1) { document.getElementById('print_liver').style.display= 'none';}



if( renal_status  == 1) {
document.getElementById('print_renal').style.display= 'block';
$('#print_renal').attr("href", renal_generated_file);

document.getElementById('uric_acid').value = $(this).attr('data-uric_acid');
document.getElementById('creatinine').value = $(this).attr('data-creatinine');
document.getElementById('urea').value = $(this).attr('data-urea');


} 

else if (liver_status !=  1) { document.getElementById('print_renal').style.display= 'none';}




if(hematology == 1) { 
	
	$('#hematology_display').show();
	document.getElementById('hematology_test').style.display = "none"; 
	document.getElementById('lipid_test').style.display = "none"; 
	document.getElementById('liver_test').style.display = "none"; 
	document.getElementById('renal_test').style.display = "none"; 

}     
  else {   

	$('#hematology_display').hide();
	document.getElementById('hematology_test').style.display = "none"; 
	document.getElementById('lipid_test').style.display = "none"; 
	document.getElementById('liver_test').style.display = "none"; 
	document.getElementById('renal_test').style.display = "none"; 
}

 if(lipid == 1)      { 
	
	$('#lipid_display').show();
   document.getElementById('hematology_test').style.display = "none"; 
   document.getElementById('hematology_test').style.display = "none"; 
	document.getElementById('lipid_test').style.display = "none"; 
	document.getElementById('liver_test').style.display = "none"; 
	document.getElementById('renal_test').style.display = "none"; 
}     
   else {   
  
  $('#lipid_display').hide();
   document.getElementById('hematology_test').style.display = "none";
   document.getElementById('hematology_test').style.display = "none"; 
	document.getElementById('lipid_test').style.display = "none"; 
	document.getElementById('liver_test').style.display = "none"; 
	document.getElementById('renal_test').style.display = "none"; 
}

 if(renal == 1)      { 
$('#renal_display').show(); 
document.getElementById('hematology_test').style.display = "none";
 document.getElementById('lipid_test').style.display = "none"; 
 document.getElementById('liver_test').style.display = "none"; 
 document.getElementById('renal_test').style.display = "none";  }    
 else { 

 $('#renal_display').hide();
	document.getElementById('hematology_test').style.display = "none";
	document.getElementById('lipid_test').style.display = "none"; 
	document.getElementById('liver_test').style.display = "none"; 
	document.getElementById('renal_test').style.display = "none"; 
}
 if(liver== 1)      
  {
	 $('#liver_display').show(); 
	 document.getElementById('hematology_test').style.display = "none";
	
	document.getElementById('lipid_test').style.display = "none"; 
	document.getElementById('liver_test').style.display = "none"; 
	document.getElementById('renal_test').style.display = "none"; 
  }    
	else {  
		 $('#liver_display').hide();document.getElementById('hematology_test').style.display = "none";
		
	document.getElementById('lipid_test').style.display = "none"; 
	document.getElementById('liver_test').style.display = "none"; 
	document.getElementById('renal_test').style.display = "none"; 
		}


	var invoice = $(this);
	//document.getElementById('invoice_id').innerHTML =  $(this).attr('data-invoice-id');


	invoice_di = $(this).attr('data-invoice-di')
	document.getElementById('invoice_di_hematology').value =invoice_di;


	$('#lab_request_from_dr').modal({
		backdrop: 'static',
		keyboard: false
	}).one('click', '#delete', function () {
		
		$(invoice).closest('tr').remove();
	});





});





		// Lab Inquiries
		$(document).on('click', ".lab_request_from_dr", function (e) {
			e.preventDefault();
			$('#commentForm')[0].reset();
			$(".required").parent().removeClass("has-error");
			$("#commentForm").find(':input:disabled').removeAttr('disabled');


			document.getElementById('submit_lab_requeste_to_dr').style.display = 'block';
			document.getElementById('submit_lab_requeste_to_test_renal').style.display = 'block';
			document.getElementById('submit_lab_requeste_to_test_liver').style.display = 'block';
			document.getElementById('submit_lab_requeste_to_test_hematology').style.display = 'block';
			document.getElementById('submit_lab_requeste_to_test_lipid').style.display = 'block';
		   
		 document.getElementById('hematology').checked = false;
		 document.getElementById('lipid').checked = false;
	     document.getElementById('liver').checked = false;
		 document.getElementById('renal').checked = false;
		       

		 document.getElementById('patient_name').innerHTML = $(this).attr('data-pname');
		 document.getElementById('patient_age').innerHTML = $(this).attr('data-page');
		 document.getElementById('patient_gender').innerHTML = $(this).attr('data-gender');
		 document.getElementById('patient_test_date').innerHTML = $(this).attr('data-ptest_date');
		 document.getElementById('referred_by').innerHTML = $(this).attr('data-prefred_by');



		 document.getElementById('lipid_patient_name').innerHTML = $(this).attr('data-pname');
		 document.getElementById('lipid_patient_age').innerHTML = $(this).attr('data-page');
		 document.getElementById('lipid_patient_gender').innerHTML = $(this).attr('data-gender');
		 document.getElementById('lipid_patient_test_date').innerHTML = $(this).attr('data-ptest_date');
		 document.getElementById('lipid_referred_by').innerHTML = $(this).attr('data-prefred_by');
	
		 document.getElementById('General_test').innerHTML = $(this).attr('data-general_test');  
		


		 document.getElementById('liver_patient_name').innerHTML = $(this).attr('data-pname');
		 document.getElementById('liver_patient_age').innerHTML = $(this).attr('data-page');
		 document.getElementById('liver_patient_gender').innerHTML = $(this).attr('data-gender');
		 document.getElementById('liver_patient_test_date').innerHTML = $(this).attr('data-ptest_date');
		 document.getElementById('liver_referred_by').innerHTML = $(this).attr('data-prefred_by');



		 
		 document.getElementById('renal_patient_name').innerHTML = $(this).attr('data-pname');
		 document.getElementById('renal_patient_age').innerHTML = $(this).attr('data-page');
		 document.getElementById('renal_patient_gender').innerHTML = $(this).attr('data-gender');
		 document.getElementById('renal_patient_test_date').innerHTML = $(this).attr('data-ptest_date');
		 document.getElementById('renal_referred_by').innerHTML = $(this).attr('data-prefred_by');
	



		  
		 document.getElementById('hema_patient_name').innerHTML = $(this).attr('data-pname');
		 document.getElementById('hema_patient_age').innerHTML = $(this).attr('data-page');
		 document.getElementById('hema_patient_gender').innerHTML = $(this).attr('data-gender');
		 document.getElementById('hema_patient_test_date').innerHTML = $(this).attr('data-ptest_date');
		 document.getElementById('hema_referred_by').innerHTML = $(this).attr('data-prefred_by');
		 document.getElementById('data-sender_id').value = $(this).attr('data-Sender_id');

	



			var invoiceId = 'action=delete_invoice&delete=' + $(this).attr('data-invoice-id'); //build a post data structure

			var invoice_di = $(this).attr('data-invoice-di');
			
			document.getElementById('invoice_di').value = invoice_di  ;
            document.getElementById('invoice_di_liver').value = invoice_di  ;
			document.getElementById('invoice_di_renal').value = invoice_di  ;
			document.getElementById('invoice_di_hematology').value = invoice_di  ;


			document.getElementById('h_patient_name').value = $(this).attr('data-pname'); ;
			document.getElementById('h_patient_age').value = $(this).attr('data-page');
			document.getElementById('h_patient_gender').value = $(this).attr('data-gender');
			document.getElementById('h_ptest_date').value = $(this).attr('data-ptest_date');
			document.getElementById('h_ptest_prefred_by').value = $(this).attr('data-prefred_by');


			document.getElementById('data-hematology_status').value = $(this).attr('data-hematology_status');
			document.getElementById('data-liver_status').value = $(this).attr('data-liver_status'); 
			document.getElementById('data-renal_status').value = $(this).attr('data-renal_status');
			document.getElementById('data-lipid_status').value = $(this).attr('data-lipid_status');


			var hematology =  $(this).attr('data-hematology');
			var lipid = $(this).attr('data-lipid');
			var renal = $(this).attr('data-renal');
			var liver =$(this).attr('data-liver');

			
			var hematology_status = $(this).attr('data-hematology_status');
			var hematology_generated_file_path =  $(this).attr('data-hematology_generated_file_path');

			var lipid_status = $(this).attr('data-lipid_status');
			var lipid_generated_file_path = $(this).attr('data-lipid_generated_file_path');


			var liver_status = $(this).attr('data-liver_status');
			var liver_generated_file  = $(this).attr('data-liver_generated_file');


		

			var renal_status = $(this).attr('data-renal_status');
			var renal_generated_file  = $(this).attr('data-renal_generated_file');

if( hematology_status   == 1) {

				document.getElementById('print_hematology').style.display= 'block';$('#print_hematology').attr("href", hematology_generated_file_path);
				document.getElementById('hgh').value =   $(this).attr('data-hgh');
				document.getElementById('bf_malaria').value =   $(this).attr('data-bf_malaria');
				document.getElementById('TWBC').value = $(this).attr('data-TWBC');
				document.getElementById('diff').value =  $(this).attr('data-diff');

				document.getElementById('vdrl').value =  $(this).attr('data-vdrl');
				document.getElementById('widal').value =  $(this).attr('data-widal');
				document.getElementById('others_hematology').value =  $(this).attr('data-others_hematology');
				document.getElementById('reaction_color').value =  $(this).attr('data-reaction_color');
				document.getElementById('Mucus').value =  $(this).attr('data-mucus');
				document.getElementById('urine_Albumin').value =  $(this).attr('data-urine_Albumin');
				document.getElementById('urine_sugar').value =  $(this).attr('data-urine_sugar');
				document.getElementById('urine_acetone').value =  $(this).attr('data-urine_acetone');
				document.getElementById('urine_bile_pigment').value =  $(this).attr('data-urine_bile_pigment');
				document.getElementById('pus_Cell_microsocopy').value =  $(this).attr('data-pus_Cell_microsocopy');

				document.getElementById('crystal').value =  $(this).attr('data-crystal');
				document.getElementById('RBC').value = $(this).attr('data-RBC');
				document.getElementById('EPC').value =  $(this).attr('data-EPC');
				document.getElementById('ova').value =  $(this).attr('data-ova');
				document.getElementById('others').value =  $(this).attr('data-others');
				document.getElementById('RBS').value =  $(this).attr('data-RBS');
				document.getElementById('ERS').value =  $(this).attr('data-ERS');
				document.getElementById('Morphology').value =  $(this).attr('data-Morphology');

				document.getElementById('HCG').value =  $(this).attr('data-HCG');
				document.getElementById('H_pylori').value =  $(this).attr('data-H_pylori');
				document.getElementById('Brucella_Test').value =  $(this).attr('data-Brucella_Test');
				document.getElementById('HGB').value =  $(this).attr('data-HGB');
				document.getElementById('color_stool').value =  $(this).attr('data-color_stool');
				document.getElementById('Consist').value =  $(this).attr('data-Consist');
				document.getElementById('Reaction').value =  $(this).attr('data-Reaction');
				document.getElementById('Blood').value =  $(this).attr('data-Blood');
				document.getElementById('Worms').value =  $(this).attr('data-worms');
				document.getElementById('Pus_Cells_direct_microscopy').value =  $(this).attr('data-Pus_Cells_direct_microscopy');
				document.getElementById('RBCS').value =  $(this).attr('data-RBCS');
				document.getElementById('o_p').value =  $(this).attr('data-o_p');
				document.getElementById('HIV').value =  $(this).attr('data-HIV');
		        document.getElementById('HBV').value =  $(this).attr('data-HBV');
		        document.getElementById('HCV').value =  $(this).attr('data-HCV');
		        document.getElementById('FBS').value =  $(this).attr('data-FBS');

			



 } else if (hematology_status  != 1) { document.getElementById('print_hematology').style.display= 'none';}



if( lipid_status  == 1) {
     document.getElementById('print_lipid').style.display= 'block';$('#print_lipid').attr("href", lipid_generated_file_path);
     document.getElementById('tchol').value =   $(this).attr('data-tchol');
	 document.getElementById('TG').value =   $(this).attr('data-tg');
	 document.getElementById('HDLC').value = $(this).attr('data-hdlc');
	 document.getElementById('LDLC').value =  $(this).attr('data-ldlc');
} else if (lipid_status  != 1) { document.getElementById('print_lipid').style.display= 'none';}




if( liver_status  == 1) {
	document.getElementById('print_liver').style.display= 'block';
	$('#print_liver').attr("href", liver_generated_file);

    document.getElementById('total_protien').value = $(this).attr('data-total_protien');
    document.getElementById('alb').value = $(this).attr('data-alb');
	document.getElementById('ast').value = $(this).attr('data-ast');
	document.getElementById('ggt').value = $(this).attr('data-ggt');
	document.getElementById('tbil').value = $(this).attr('data-tbil');
	document.getElementById('dbil').value = $(this).attr('data-dbil');
	document.getElementById('alp').value = $(this).attr('data-alp');

} else if (liver_status !=  1) { document.getElementById('print_liver').style.display= 'none';}



if( renal_status  == 1) {
	document.getElementById('print_renal').style.display= 'block';
	$('#print_renal').attr("href", renal_generated_file);

    document.getElementById('uric_acid').value = $(this).attr('data-uric_acid');
    document.getElementById('creatinine').value = $(this).attr('data-creatinine');
	document.getElementById('urea').value = $(this).attr('data-urea');


} else if (liver_status !=  1) { document.getElementById('print_renal').style.display= 'none';}








 if(hematology == 1) { 
			
			$('#hematology_display').show();
			document.getElementById('hematology_test').style.display = "none"; 
			document.getElementById('lipid_test').style.display = "none"; 
			document.getElementById('liver_test').style.display = "none"; 
			document.getElementById('renal_test').style.display = "none"; 
		
		}     
		  else {   

			$('#hematology_display').hide();
			document.getElementById('hematology_test').style.display = "none"; 
			document.getElementById('lipid_test').style.display = "none"; 
			document.getElementById('liver_test').style.display = "none"; 
			document.getElementById('renal_test').style.display = "none"; 
		}

		 if(lipid == 1)      { 
			
			$('#lipid_display').show();
           document.getElementById('hematology_test').style.display = "none"; 
		   document.getElementById('hematology_test').style.display = "none"; 
			document.getElementById('lipid_test').style.display = "none"; 
			document.getElementById('liver_test').style.display = "none"; 
			document.getElementById('renal_test').style.display = "none"; 
		}     
		   else {   
		  
		  $('#lipid_display').hide();
		   document.getElementById('hematology_test').style.display = "none";
		   document.getElementById('hematology_test').style.display = "none"; 
			document.getElementById('lipid_test').style.display = "none"; 
			document.getElementById('liver_test').style.display = "none"; 
			document.getElementById('renal_test').style.display = "none"; 
		}

		 if(renal == 1)      { 
		$('#renal_display').show(); 
		document.getElementById('hematology_test').style.display = "none";
		 document.getElementById('lipid_test').style.display = "none"; 
		 document.getElementById('liver_test').style.display = "none"; 
		 document.getElementById('renal_test').style.display = "none";  }    
		 else { 

		 $('#renal_display').hide();
            document.getElementById('hematology_test').style.display = "none";
            document.getElementById('lipid_test').style.display = "none"; 
			document.getElementById('liver_test').style.display = "none"; 
			document.getElementById('renal_test').style.display = "none"; 
		}
		 if(liver== 1)      
		  {
			 $('#liver_display').show(); 
			 document.getElementById('hematology_test').style.display = "none";
			
			document.getElementById('lipid_test').style.display = "none"; 
			document.getElementById('liver_test').style.display = "none"; 
			document.getElementById('renal_test').style.display = "none"; 
		  }    
		    else {  
				 $('#liver_display').hide();document.getElementById('hematology_test').style.display = "none";
				
			document.getElementById('lipid_test').style.display = "none"; 
			document.getElementById('liver_test').style.display = "none"; 
			document.getElementById('renal_test').style.display = "none"; 
				}


			var invoice = $(this);
			//document.getElementById('invoice_id').innerHTML =  $(this).attr('data-invoice-id');

	
			invoice_di = $(this).attr('data-invoice-di')
			document.getElementById('invoice_di_hematology').value =invoice_di;


			$('#lab_request_from_dr').modal({
				backdrop: 'static',
				keyboard: false
			}).one('click', '#delete', function () {
				
				$(invoice).closest('tr').remove();
			});


       















		});


            //lab_inquiries_posted_list

		$(document).on('click', ".lab_inquiries_posted_list", function (e) {
			e.preventDefault();
	
			var invoiceId = 'action=delete_invoice&delete=' + $(this).attr('data-invoice-id'); //build a post data structure
			var invoice = $(this);
			var invoice_id = $(this).attr('data-invoice-id');
			var cashier_invocie_created = $(this).attr('data-invoice-id_lab');
			var action = 'table_request_form_lab';

			document.getElementById('invoice_id').innerHTML =  $(this).attr('data-invoice-id');


			$.ajax({
				data:{
					invoice_id :invoice_id ,
					cashier_invocie_created  : cashier_invocie_created ,
					action  : action,
				},
			
			type:'POST',
			dataType: 'json',
			url: "response.php",
			
			success: (data) => { 
				document.getElementById('table_Dr_request_lab').innerHTML = data.data_returned;
			},
			
			error: function(data){
			console.log(data);
			}
			
			});






			$('#lab_inquiries_posted_list').modal({
				backdrop: 'static',
				keyboard: false
			}).one('click', '#delete', function () {
				
				$(invoice).closest('tr').remove();
			});
		});




	// delete product
	$(document).on('click', ".delete-product", function (e) {
		e.preventDefault();

		var productId = 'action=delete_product&delete=' + $(this).attr('data-product-id'); //build a post data structure
		var product = $(this);

		$('#confirm').modal({
			backdrop: 'static',
			keyboard: false
		}).one('click', '#delete', function () {
			deleteProduct(productId);
			$(product).closest('tr').remove();
		});

		setTimeout($('#custom_message').modal('hide'), 30000);
		divs = $('#custom_message');

		setInterval(function () {
			divs.hide();
		}, 20000); // do this every 10 seconds    
	});



	//select_permission_all



	//create A doctor

	$("#select_permission_all").click(function (e) {
		e.preventDefault();
		

       document.getElementById('dashboard').checked = true; 
	   document.getElementById('create_invoice').checked = true; 
	   document.getElementById('delete_invoice').checked =true; 
	   document.getElementById('download_csv').checked = true; 
	   document.getElementById('manage_invoice').checked =true; 
	   document.getElementById('edit_procedure').checked =true; 
	   document.getElementById('delete_procedure').checked =true; 
	   document.getElementById('manage_procedure').checked =true; 
	   document.getElementById('Add_Procedure').checked = true; 
	   document.getElementById('Add_patient').checked = true; 
	   document.getElementById('manage_patient').checked = true; 
	   document.getElementById('edit_patient').checked = true; 
	   document.getElementById('delete_patient').checked = true; 
	   document.getElementById('Add_doctor').checked = true; 
	   document.getElementById('manage_doctor').checked =  true; 
	   document.getElementById('edit_doctor').checked = true; 
	   document.getElementById('delete_doctor').checked =  true; 
	   document.getElementById('manage_users').checked =  true; 
	   document.getElementById('Add_users').checked =  true; 
	   document.getElementById('edit_users').checked = true; 
	   document.getElementById('delete_users').checked = true; 
	 

	});


	$("#unselect_permission_all").click(function (e) {
		e.preventDefault();
		

		document.getElementById('dashboard').checked = false; 
		document.getElementById('create_invoice').checked = false; 
		document.getElementById('delete_invoice').checked =false; 
		document.getElementById('download_csv').checked = false; 
		document.getElementById('manage_invoice').checked =false; 
		document.getElementById('edit_procedure').checked =false; 
		document.getElementById('delete_procedure').checked =false; 
		document.getElementById('manage_procedure').checked =false; 
		document.getElementById('Add_Procedure').checked = false; 
		document.getElementById('Add_patient').checked = false; 
		document.getElementById('manage_patient').checked = false; 
		document.getElementById('edit_patient').checked = false; 
		document.getElementById('delete_patient').checked = false; 
		document.getElementById('Add_doctor').checked = false; 
		document.getElementById('manage_doctor').checked =  false; 
		document.getElementById('edit_doctor').checked = false; 
		document.getElementById('delete_doctor').checked =  false; 
		document.getElementById('manage_users').checked =  false; 
		document.getElementById('Add_users').checked =  false; 
		document.getElementById('edit_users').checked = false; 
		document.getElementById('delete_users').checked = false; 
	 

	});






	//create A doctor

	$("#action_create_doctor").click(function (e) {
		e.preventDefault();
		actionCreateDoctor();
	});

	
	//submit_lab_requeste_to_test_renal
	$("#submit_lab_requeste_to_test_renal").click(function (e) {


		//uric_acid creatinine  urea
 e.preventDefault();
 if (confirm("Are you sure all fields are filled")){ }else { return false; }
 if(document.getElementById('uric_acid').value == ''   || document.getElementById('creatinine').value == '' || document.getElementById('urea').value == ''   )
  {

   alert("It appears missing input attributes"); 
   
   if(document.getElementById('uric_acid').value == '' ) { document.getElementById('uric_acid').focus();return false; }
   if(document.getElementById('creatinine').value == '' ) {document.getElementById('creatinine').focus();return false;} 
   if(document.getElementById('urea').value == '' ) { 	document.getElementById('urea').focus(); return false;}
 }

 var  uric_acid  = document.getElementById('uric_acid').value;
 var creatinine = document.getElementById('creatinine').value;
 var urea = document.getElementById('urea').value;

 var invoice_di = document.getElementById('invoice_di_renal').value;
 var action = 'create_renal_test';




 var renal_patient_name = document.getElementById('renal_patient_name').innerHTML;
 var renal_patient_gender = document.getElementById('renal_patient_gender').innerHTML;
 var renal_patient_test_date  = document.getElementById('renal_patient_test_date').innerHTML;
 var renal_patient_sample_type  = document.getElementById('renal_patient_sample_type').innerHTML;
 var renal_referred_by= document.getElementById('renal_referred_by').innerHTML;
 var renal_patient_age = document.getElementById('renal_patient_age').innerHTML;


    document.getElementById('submit_lab_requeste_to_test_renal').disabled = true; 
	document.getElementById('print_renal').style.display= "none";

	


	$.ajax({

		url: 'response.php',
		type: 'POST',
		//data: $("#create_renal_test").serialize(),
		data:{
			uric_acid : uric_acid,
			creatinine : creatinine,  
			urea : urea,
			renal_referred_by : renal_referred_by,
			renal_patient_sample_type : renal_patient_sample_type,
			renal_patient_test_date : renal_patient_test_date,
			renal_patient_gender : renal_patient_gender,
			renal_patient_name : renal_patient_name,
			renal_patient_age : renal_patient_age,
			invoice_di : invoice_di,
			action : action,
			

			},
		dataType: 'json',
		success: function (data) {
			$("#response_renal").show();
			$("#response_renal .message").html("<strong>" + data.status + "</strong>: " + data.message);
			$("#response_lipid").removeClass("alert-warning").addClass("alert-success").fadeIn();

			 $("html, body").animate({
				scrollTop: $('#response_renal').offset().top
			 }, 1000);
	
			 document.getElementById('print_renal').style.display= "block";

			 document.getElementById('submit_lab_requeste_to_test_renal').disabled = false;
			 $('#print_renal').attr("href", data.Download);

					 var priority = 'success';
					var title    = 'Labaratorist '+ data.mode + " records";
					var message  = data.message;
	
					setTimeout(function(){
						$.toaster({ priority : priority, title : title, message : message });
					
					}, 500);
	
					$("#response_renal").delay(4000).fadeOut('slow')
					
					document.getElementById('data-renal_status').value  = data.renal_status;
				
					
					//setInterval(request_from_dr_for_lab, 5000);
				
		},
	
		error: function (data) {
			$("#response_renal .message").html("<strong>" + data.status + "</strong>: " + data.message);
			$("#response_renal").removeClass("alert-success").addClass("alert-warning").fadeIn();
			$("html, body").animate({
				scrollTop: $('#response_renal').offset().top
			}, 1000);
			
		}
	
	});


	});










	//submit_lab_requeste_to_test_lipid
$("#submit_lab_requeste_to_test_lipid").click(function (e) {

  e.preventDefault();
  if (confirm("Are you sure all fields are filled")){ }else { return false; }
  if(document.getElementById('TG').value == ''  ||  document.getElementById('LDLC').value == '' || document.getElementById('tchol').value == '' || document.getElementById('HDLC').value == ''   )
   {
	alert("It appears missing input attributes"); 
	
    if(document.getElementById('tchol').value == '' ) { document.getElementById('tchol').focus();return false; }
	if(document.getElementById('TG').value == '' ) {document.getElementById('TG').focus();return false;} 
	if(document.getElementById('HDLC').value == '' ) { 	document.getElementById('HDLC').focus(); return false;}
	if(document.getElementById('LDLC').value == '' ) { document.getElementById('LDLC').focus(); return false;}
    
   }  
    var  tchol = document.getElementById('tchol').value;
	 var TG = document.getElementById('tchol').value;
	 var HDLC= document.getElementById('HDLC').value;
	 var LDLC = document.getElementById('LDLC').value;
	 var invoice_di = document.getElementById('invoice_di').value;
	 var action = 'create_lipid_test';
	 var to_be_printed =  document.getElementById('this_to_be_print').innerHTML ; 


	 var lipid_patient_name = document.getElementById('lipid_patient_name').innerHTML;
	 var lipid_patient_gender = document.getElementById('lipid_patient_gender').innerHTML;
	 var lipid_patient_test_date  = document.getElementById('lipid_patient_test_date').innerHTML;
	 var lipid_patient_sample_type  = document.getElementById('lipid_patient_sample_type').innerHTML;
	 var lipid_referred_by= document.getElementById('lipid_referred_by').innerHTML;
	 var lipid_patient_age = document.getElementById('lipid_patient_age').innerHTML;


    document.getElementById('submit_lab_requeste_to_test_lipid').disabled = true; 
	document.getElementById('print_lipid').style.display= "none";

		$.ajax({

			url: 'response.php',
			type: 'POST',
			//data: $("#create_lipid_test").serialize(),
			data:{
                tchol : tchol,
				lipid_referred_by : lipid_referred_by,
				lipid_patient_sample_type : lipid_patient_sample_type,
				lipid_patient_test_date : lipid_patient_test_date,
				lipid_patient_gender : lipid_patient_gender,
				lipid_patient_name : lipid_patient_name,
				lipid_patient_age : lipid_patient_age,
				TG : TG,
				HDLC : HDLC,
				LDLC : LDLC,
				invoice_di : invoice_di,
				action : action,
				to_be_printed : to_be_printed,

				},
			dataType: 'json',
			success: function (data) {
				$("#response_lipid").show();
				$("#response_lipid .message").html("<strong>" + data.status + "</strong>: " + data.message);
				$("#response_lipid").removeClass("alert-warning").addClass("alert-success").fadeIn();

				 $("html, body").animate({
					scrollTop: $('#response_lipid').offset().top
				 }, 1000);
		
				 document.getElementById('print_lipid').style.display= "block";

				 document.getElementById('submit_lab_requeste_to_test_lipid').disabled = false;
				 $('#print_lipid').attr("href", data.Download);

						 var priority = 'success';
						var title    = 'Labaratorist '+ data.mode + " records";
						var message  = data.message;
		
						setTimeout(function(){
							$.toaster({ priority : priority, title : title, message : message });
						
						}, 500);
		
						$("#response_lipid").delay(2000).fadeOut('slow')
						
						
					document.getElementById('data-lipid_status').value = data.lipid_status;
					
						
						//setInterval(request_from_dr_for_lab, 5000);
					
			},
		
			error: function (data) {
				$("#response .message").html("<strong>" + data.status + "</strong>: " + data.message);
				$("#response").removeClass("alert-success").addClass("alert-warning").fadeIn();
				$("html, body").animate({
					scrollTop: $('#response').offset().top
				}, 1000);
				
			}
		
		});



	});


	//submit_requeste_to_test_liver

	$("#submit_lab_requeste_to_test_liver").click(function (e) {

		// e.preventDefault();

		// alp dbil tbil  ggt   ast alb  total_protien

		 if (confirm("Are you sure all fields are filled")){ }else { return false; }
		 if(document.getElementById('total_protien').value == ''  ||  document.getElementById('alb').value == '' || document.getElementById('ast').value == '' || document.getElementById('ggt').value == ''  || document.getElementById('tbil').value == ''  || document.getElementById('dbil').value == '' || document.getElementById('alp').value == ''    )
		  {
		   alert("It appears missing input attributes"); 
		   
		   if(document.getElementById('total_protien').value == '' ) { document.getElementById('total_protien').focus();return false; }
		   if(document.getElementById('alb').value == '' ) {document.getElementById('alb').focus();return false;} 
		   if(document.getElementById('ast').value == '' ) { 	document.getElementById('ast').focus(); return false;}
		   if(document.getElementById('ggt').value == '' ) { document.getElementById('ggt').focus(); return false;}
		   if(document.getElementById('tbil').value == '' ) { document.getElementById('tbil').focus(); return false;}
		   if(document.getElementById('dbil').value == '' ) { document.getElementById('dbil').focus(); return false;}
		   if(document.getElementById('alp').value == '' ) { document.getElementById('alp').focus(); return false;}
		   
		  }  
		   var  total_protien = document.getElementById('total_protien').value;
			var alb = document.getElementById('alb').value;
			var ast  = document.getElementById('ast').value;
			var ggt = document.getElementById('ggt').value;

			var tbil = document.getElementById('tbil').value;
			var dbil  = document.getElementById('dbil').value;
			var alp = document.getElementById('alp').value;




			var invoice_di_liver = document.getElementById('invoice_di_liver').value;
			var action = 'create_liver_test';

			var to_be_printed_liver =  document.getElementById('this_to_be_print_liver').innerHTML ; 
	   
			var liver_patient_name = document.getElementById('liver_patient_name').innerHTML;
			var liver_patient_gender = document.getElementById('liver_patient_gender').innerHTML;
			var liver_patient_test_date  = document.getElementById('liver_patient_test_date').innerHTML;
			var liver_patient_sample_type  = document.getElementById('liver_patient_sample_type').innerHTML;
			var liver_referred_by= document.getElementById('liver_referred_by').innerHTML;
			var liver_patient_age = document.getElementById('liver_patient_age').innerHTML;


		   document.getElementById('submit_lab_requeste_to_test_liver').disabled = true; 
		   document.getElementById('print_liver').style.display= "none";
	   

		     
			   $.ajax({
	   
				   url: 'response.php',
				   type: 'POST',
				   //data: $("#create_lipid_test").serialize(),
				   data:{
					   liver_referred_by : liver_referred_by,
                       liver_patient_sample_type : liver_patient_sample_type,
                       liver_patient_test_date : liver_patient_test_date,
                       liver_patient_gender : liver_patient_gender,
                       liver_patient_name : liver_patient_name,
                       liver_patient_age : liver_patient_age,
					   total_protien : total_protien,
					   alb  : alb,
					   ast  : ast,
					   ggt  : ggt,
					   tbil : tbil,
					   dbil : dbil,
                       alp  : alp,
					   invoice_di : invoice_di_liver,
					   action : action,
					   to_be_printed : to_be_printed_liver,
	   
					   },
				   dataType: 'json',
				   success: function (data) {
					$("#response_liver").show();
					   $("#response_liver .message").html("<strong>" + data.status + "</strong>: " + data.message);
					   $("#response_liver").removeClass("alert-warning").addClass("alert-success").fadeIn();
	   
						$("html, body").animate({
						   scrollTop: $('#response_liver').offset().top
						}, 1000);
			   
						document.getElementById('print_liver').style.display= "block";
	   
						document.getElementById('submit_lab_requeste_to_test_liver').disabled = false;
						$('#print_liver').attr("href", data.Download);
	   
								var priority = 'success';
							   var title    = 'Labaratorist '+ data.mode + " records";
							   var message  = data.message;
			   
							   setTimeout(function(){
								   $.toaster({ priority : priority, title : title, message : message });
							   
							   }, 500);
			   
							   $("#response_liver").delay(2000).fadeOut('slow')

							   document.getElementById('data-liver_status').value = data.liver_status;
							   
	   
						   
							   
							   //setInterval(request_from_dr_for_lab, 5000);
						   
				   },
			   
				   error: function (data) {
					   $("#response .message").html("<strong>" + data.status + "</strong>: " + data.message);
					   $("#response").removeClass("alert-success").addClass("alert-warning").fadeIn();
					   $("html, body").animate({
						   scrollTop: $('#response').offset().top
					   }, 1000);
					   
				   }
			   
			   });
	   
	   
	   
		   });


	function printDiv(screen) {
		var  tchol = document.getElementById('tchol').value;
		var TG = document.getElementById('tchol').value;
		var HDLC= document.getElementById('HDLC').value;
		var LDLC = document.getElementById('LDLC').value;

		// document.getElementById('tcholl').innerHTML = tchol;
		// document.getElementById('TGG').innerHTML = TG;
		// document.getElementById('HDLCC').innerHTML = HDLC;
		// document.getElementById('LDLCC').innerHTML = LDLC;




		const content = document.getElementById(screen).innerHTML;
		const printWindow = window.open('', '_blank');

	



     var html = "<div class='container'> <img src='images/Picture3.png' class='img-rounded img-responsive' alt='Cinque Terre' width='850' height='130'> <table class='table table-responsive'><thead><tr> <th width ='10%'>Patient Name </th> <th> Age </th> <th width ='10%'> Gender </th><th width ='10%'>Test Date(Y/D/M)</th> <th width ='10%'>Sample Type</th> <th>Referred By</th> </tr></thead>   <tbody> <tr class='table-primary' style='background-color:lightgrey'> <td><span     id='lipid_patient_name'> </span> </td><td><span  id='lipid_patient_age'> </span></td><td><span id='lipid_patient_gender'> </span></td><td><span id='lipid_patient_test_date'> </span></td><td><span id='lipid_patient_sample_type'> SERUM </span></td><td><span id='lipid_referred_by'> </span></td> </tr>      </tbody> </table></div> <table class='table table-responsive'> <thead><tr> <th>Test</th> <th>Results</th> <th>Reference Interval</th> <th>Unit</th></tr></thead> <tbody> <tr><td>TCHOL</td>";
	  html += "<td>"+ tchol +" </td><td>130 - 250</td> <td>mg/dl</td> </tr>      <tr ><td>TG</td>";
	  html +=  "<td>"+ TG + "</td> <td>60 - 170 </td> <td>mg/dl</td> </tr> <tr > <td>HDLC</td>";
	  html += "<td>" +HDLC + "</td> <td>35 - 80 </td> <td>mg/dl</td></tr> <tr ><td>LDLC </td> <td>";
	  html += LDLC + "</td> <td> 0 - 130 </td> <td>mg/dl</td> </tr></tbody></table>";

		printWindow.document.write('<html><head><title>Print</title></head><body>');
		printWindow.document.write(content);
		printWindow.document.write('</body></html>');
		printWindow.document.close();
		printWindow.print();
		printWindow.close();

    }




	//Create a Request to Dr  submit_dr_requeste_to_test

	$("#submit_lab_requeste_to_test_hematology").click(function (e) {
  
		if (confirm("Submission is ready to initialize")){ }else { return false; }
		//$('#commentForm')[0].reset();

		e.preventDefault();
		function request_from_dr_for_lab()
         {
          // window.location = "request_from_dr_for_lab.php";
		}

		document.getElementById('print_hematology').style.display= 'none';

		var errorCounter = validateFormm();


	

		// if (errorCounter > 0 ) {
		// 	$("#response_hematology").removeClass("alert-success").addClass("alert-warning").fadeIn();
		// 	$("#response_hematology .message").html("<strong>Error</strong>: It appear's you have forgotten to complete something!");
		// 	$("html, body").animate({
		// 		scrollTop: $('#response_hematology').offset().top
		// 	}, 1000);

		// 	$("#response_hematology").delay(4000).fadeOut('slow')
		// 	document.getElementById('reaction_color').focus();


		// } 
		//else {
	
			$(".required").parent().removeClass("has-error");
			$("#commentForm").find(':input:disabled').removeAttr('disabled');
           
			function invoice_create() { window.location = "request_from_dr.php";}

        $.ajax({

			url: 'response.php',
			type: 'POST',
			data: $("#commentForm").serialize(),
			dataType: 'json',
			success: function (data) {
				$("#response_hematology .message").html("<strong>" + data.status + "</strong>: " + data.message);
				$("#response_hematology").removeClass("alert-warning").addClass("alert-success").fadeIn();
				$("html, body").animate({
					scrollTop: $('#response_hematology').offset().top
				}, 1000);

				document.getElementById('print_hematology').style.display= 'block';
				$('#print_hematology').attr("href", data.Download);

						 var priority = 'success';
						var title    = 'Lab Technician subimtted test sucessfully.';
						var message  = data.message;
		
						setTimeout(function(){
							$.toaster({ priority : priority, title : title, message : message });
						
						}, 500);

						$("#response_hematology").delay(4000).fadeOut('slow')
		
						document.getElementById('data-hematology_status').value  =  data.hema_live_status;
					
			},
		
			error: function (data) {
				$("#response_hematology .message").html("<strong>" + data.status + "</strong>: " + data.message);
				$("#response_hematology").removeClass("alert-success").addClass("alert-warning").fadeIn();
				$("html, body").animate({
					scrollTop: $('#response_hematology').offset().top
				}, 1000);
				
				$("#response_hematology").delay(4000).fadeOut('slow')
			}
		
		});

	//}

	});



 


	//Create a Request to Dr  submit_dr_requeste_to_test

	$("#submit_dr_requeste_to_test").click(function (e) {
		e.preventDefault();
		//actionCreateDoctor();
		var hematology; var Lipid; var liver; var  renal;
		var invoice_id = document.getElementById('invoice_id').innerHTML;

		hematology    = document.getElementById('hematology').checked;
		lipid         = document.getElementById('lipid').checked;
		liver         = document.getElementById('liver').checked;
		renal         = document.getElementById('renal').checked;

	
		var    Hgb_test      = document.getElementById('Hgb_test').checked;
		var    BF_Test       = document.getElementById('BF_Test').checked;
		var    TWBC_test     = document.getElementById('TWBC_test').checked;
		var    Diff_Count_test    = document.getElementById('Diff_Count_test').checked; 
		var    VDRL_test     = document.getElementById('VDRL_test').checked; 
		var    WIDAL_Test    = document.getElementById('WIDAL_Test').checked;
        var    others_test   = document.getElementById('others_test').value; 
        var     RBS_test      = document.getElementById('RBS_test').checked; 
        var     ERs_test      = document.getElementById('ERs_test').checked;   
		var     Morphology_test  = document.getElementById('Morphology_test').checked;
		var    HCG_test  = document.getElementById('HCG_test').checked;
		var    H_Pylori_test  =  document.getElementById('H_Pylori_test').checked;
		var     Brucella_test  = document.getElementById('Brucella_test').checked;
		var    Hgb_A1C     = document.getElementById('Hgb_A1C').checked;
		var    urine_analysis  = document.getElementById('urine_analysis').checked;
        var   stool_analysis  = document.getElementById('stool_analysis').checked;
		
		var   screening_for_hiv = document.getElementById('screening_for_hiv').checked;
        var   HBV = document.getElementById('HBV').checked;
		var  HCV = document.getElementById('HCV').checked;


        labaratorist_name = document.getElementById('user_type').value;
		user_type_chasier  = document.getElementById('user_type_chasier').value;//user_type_chasier
		

if( hematology == true) { hematology=1 } else { hematology =0 ;} 
if( lipid == true) { lipid=1 } else { lipid =0 ;} 
if( liver == true) { liver=1 } else { liver =0 ;} 
if( renal  == true) { renal=1 } else { renal =0 ;} 

var test = others_test + ",";

if( Hgb_test  == true) { test += "Hgb," ;} else { test += "" ;} 
if( BF_Test == true) { test += "BF,"; } else { test += "" ;} 
if( TWBC_test  == true) { test += "TWBC,"; } else { test += "" ;} 
if( Diff_Count_test  == true) { test += "Diff Count," ;} else { test += "" ;} 
if( VDRL_test  == true) { test += "VDRL,"; } else { test += "" ;} 
if( WIDAL_Test  == true) { test += "WIDAL," ;} else { test += "" ;} 
if( RBS_test == true) { test += "RBS," ;} else { test += "" ;} 
if( ERs_test   == true) { test += "ERs,"; } else { test += "" ;}  
if( Morphology_test  == true) { test += "Morphology," } else { test += "" ;} 
if( HCG_test  == true) { test += "HCG,"; } else { test += "" ;} 
if( H_Pylori_test  == true) { test += "H Pylori," ;} else { test += "" ;} 
if( Brucella_test  == true) { test += "Brucella," ;} else { test += "" ;} 
if( Hgb_A1C   == true) { test += "Hgb. A1C," ;} else { test += "" ;} 
if( urine_analysis  == true) { test += "urine analysis,"; } else { test += "" ;} 
if( stool_analysis == true) { test += "stool analysis,"; } else { test += "" ;}  

if( screening_for_hiv  == true) { test += "Screening for HIV,"; } else { test += "" ;}  
if( HBV   == true) { test += "HBV,"; } else { test += "" ;}  
if( HCV == true) { test += "HCV,"; } else { test += "" ;}  












var action = 'send_request_to_lab';


if( hematology == true ) 
{ 

 if( HCV == false && HBV == false && screening_for_hiv == false && HCG_test == false && others_test == "" && Hgb_test == false && BF_Test  == false && TWBC_test  == false && Diff_Count_test== false && VDRL_test  == false &&
   WIDAL_Test   == false && 
    RBS_test   == false &&  ERs_test   == false  &&  H_Pylori_test == false && Brucella_test  == false && Hgb_A1C  == false 
	 && urine_analysis == false  && stool_analysis == false )
 {
// 
	 window.alert("You have to check at least one option from the General Test !!");    
	 document.getElementById('hematology').parentElement.style.color  = "black";
	 return false;

 } 

 
}

  if( hematology == false  && lipid == false &&  liver == false  && renal  == false ) 
   { 
	
    window.alert("You have to check at least one option from the checkboxes!!");    
	document.getElementById('hematology').parentElement.style.color  = "black";
	return false;
    
   }

   if( user_type_chasier == 0  ) 
   { 
	window.alert("Select a chashier from the list please ");    
	document.getElementById('user_type_chasier').focus();
	return false;
   }

   if( labaratorist_name  == 0   ) 
   {
	window.alert("Select a Labaratorist from the selection please");    
	document.getElementById('user_type').focus();
	return false; 
   }


 


   function postlist() {
	window.location = "posted-list.php";
}




window.alert("Are sure this is your last save!!");    
document.getElementById('hematology').parentElement.style.color  = "black";




$.ajax({

	url: 'response.php',
	type: 'POST',
	//data: $("#lab_inquiries").serialize(),
	data : {
     hematology : hematology,
	 lipid : lipid,
	 liver : liver,
	 renal : renal,
	 labaratorist_name : labaratorist_name,
	 user_type_chasier : user_type_chasier,
	 invoice_id : invoice_id,
	 test : test,
	 action : action
          },
	dataType: 'json',
	success: function (data) {
		$("#response .message").html("<strong>" + data.status + "</strong>: " + data.message);
		$("#response").removeClass("alert-warning").addClass("alert-success").fadeIn();
		$("html, body").animate({
			scrollTop: $('#response').offset().top
		}, 1000);

	         	var priority = 'warning';
				var title    = 'Dr Requesting Lab';
				var message  = data.message;

				setTimeout(function(){
					$.toaster({ priority : priority, title : title, message : message });
				
				}, 500);


				setInterval(postlist, 5000);
			
	},

	error: function (data) {
		$("#response .message").html("<strong>" + data.status + "</strong>: " + data.message);
		$("#response").removeClass("alert-success").addClass("alert-warning").fadeIn();
		$("html, body").animate({
			scrollTop: $('#response').offset().top
		}, 1000);
		$btn.button("reset");
	}

});

	});



	function doctor_list_page() {
		window.location = "doctor_list.php";
	}


	function actionCreateDoctor() {

		var errorCounter = validateForm();

		if (errorCounter > 0) {
			$("#response").removeClass("alert-success").addClass("alert-warning").fadeIn();
			$("#response .message").html("<strong>Error</strong>: It appear's you have forgotten to complete something!");
			$("html, body").animate({
				scrollTop: $('#response').offset().top
			}, 1000);
		} else {

			var $btn = $("#action_create_doctor").button("loading");

			$(".required").parent().removeClass("has-error");

			$.ajax({

				url: 'response.php',
				type: 'POST',
				data: $("#create_doctor").serialize(),
				dataType: 'json',
				success: function (data) {
					$("#response .message").html("<strong>" + data.status + "</strong>: " + data.message);
					$("#response").removeClass("alert-warning").addClass("alert-success").fadeIn();
					$("html, body").animate({
						scrollTop: $('#response').offset().top
					}, 1000);
					$("#create_doctor").before().html("<a href='./doctor_add.php' class='btn btn-primary'>Add New Physician</a>");
					setInterval(doctor_list_page, 2500);
					$("#create_docotr").remove();
					$btn.button("reset");
				},
				error: function (data) {
					$("#response .message").html("<strong>" + data.status + "</strong>: " + data.message);
					$("#response").removeClass("alert-success").addClass("alert-warning").fadeIn();
					$("html, body").animate({
						scrollTop: $('#response').offset().top
					}, 1000);
					$btn.button("reset");
				}

			});
		}

	}




	// create customer
	$("#action_create_customer").click(function (e) {
		e.preventDefault();
		actionCreateCustomer();
	});

	$(document).ready(function() { $("#education").select2(); });

	$(document).on('click', ".item-select", function (e) {

		e.preventDefault;

		var product = $(this);


		$('#insert').modal({
			backdrop: 'static',
			keyboard: true
		}).one('click', '#selected', function (e) {


			if (!$('#products_insert').val()) {

				document.getElementById('products_insert').focus();
				$("#insert").modal({
					"backdrop": "static"
				});

				//document.getElementById('select-item').display = none;


				return false;

			}

			var itemText = $('#insert').find("option:selected").text();
			var itemValue = $('#insert').find("option:selected").val();


			//invoice_product_sub   invoice_product_discount  invoice_product_qty
			$(product).closest('tr').find('.invoice_product').val(itemText);
			$(product).closest('tr').find('.invoice_product_price').val(itemValue);


			var quantity = $(product).closest('tr').find('.invoice_product_qty').val();
			var price = $(product).closest('tr').find('.invoice_product_price').val();
			subtotal = parseInt(quantity) * parseFloat(price);
			$(product).closest('tr').find('.invoice_product_sub').val(subtotal);
			//$(product).closest('tr').find('.invoice_product_discount').attr('readonly', false);


			var Discount = $(product).closest('tr').find('.invoice_product_discount').val();

			//console.log("Discount" + Discount);
			let pattern = "%";
			let result = String(Discount).includes(pattern) ? "Yes" : "No";

			//console.log("result" + result);

			var percent = String(Discount).replace('%', '');
			//console.log("Percent" + percent);



			// if (result == 'No') {
			// 	return isPercent = false;
			// } else {
			// 	return isPercent = true;
			// };


			// if (percent && $.isNumeric(percent) && percent !== 0) {
			// 	if (isPercent) {
			// 		subtotal = subtotal - ((parseFloat(percent) / 100) * subtotal);
			// 	} else {
			// 		subtotal = subtotal - parseFloat(percent);
			// 		console.log(subtotal);
			// 	}
			// } else {
			// 	//$('[name="invoice_product_discount[]"]', tr).val('');
			// 	//$(product).closest('tr').find('.invoice_product_discount').val('');

			// }

			subtotal = parseInt(quantity) * parseFloat(price);
			$(product).closest('tr').find('.invoice_product_sub').val(subtotal);




			//updateTotals('.calculate', itemValue);
			calculateTotal();

		});

		return false;

	});

	$(document).on('click', ".select-customer", function (e) {

		e.preventDefault;

		var customer = $(this);

		$('#insert_customer').modal({
			backdrop: 'static',
			keyboard: false
		});

		return false;

	});

	$(document).on('click', ".customer-select", function (e) {

		var customer_name = $(this).attr('data-customer-name');
		var customer_town = $(this).attr('data-customer-town');
		var customer_age = $(this).attr('data-customer-age');
		var customer_sex = $(this).attr('data-customer-sex');
		var customer_date_of_reg = $(this).attr('data-customer-date_of_reg');
		var doctor_name = $(this).attr('data-doctor-name');
		var doctor_title = $(this).attr('data-doctor-title');
		var doctor_email = $(this).attr('data-doctor-email');


		$('#customer_name').val(customer_name);
		$('#customer_town').val(customer_town);
		$('#customer_age').val(customer_age);
		$('#customer_sex').val(customer_sex);
		$('#customer_date_of_reg ').val(customer_date_of_reg);
		$('#doctor_name').val(doctor_name);
		$('#doctor_title').val(doctor_title);
		$('#doctor_email').val(doctor_email);

		$('#insert_customer').modal('hide');

	});

	// create invoice
	$("#action_create_invoice").click(function (e) {
		e.preventDefault();
		actionCreateInvoice();
	});


		// create invoice from invoice 
		$("#action_create_invoice_from_invoice").click(function (e) {
			e.preventDefault();
			actionCreateInvoice_from_invoice();
		});



	// update invoice
	$(document).on('click', "#action_edit_invoice", function (e) {
		e.preventDefault();
		updateInvoice();
	});

	// enable date pickers for due date and invoice date
	var dateFormat = $(this).attr('data-vat-rate');
	$('#invoice_date, #invoice_due_date').datetimepicker({
		showClose: false,
		format: dateFormat
	});

	// copy customer details to shipping
	$('input.copy-input').on("input", function () {
		$('input#' + this.id + "_ship").val($(this).val());
	});

	// remove product row
	$('#invoice_table').on('click', ".delete-row", function (e) {
		e.preventDefault();
		$(this).closest('tr').remove();
		calculateTotal();
	});

	// add new product row on invoice
	var cloned = $('#invoice_table tr:last').clone();
	$(".add-row").click(function (e) {
		e.preventDefault();
		cloned.clone().appendTo('#invoice_table');
	});

	calculateTotal();

	$('#invoice_table').on('input', '.calculate', function () {
		updateTotals(this);
		calculateTotal(this);
	});

	$('#invoice_totals').on('input', '.calculate', function () {
		calculateTotal();
	});

	$('#invoice_product').on('input', '.calculate', function () {
		calculateTotal();
	});

	$('.remove_vat').on('change', function () {
		calculateTotal();
	});

	function updateTotals(elem, itemValue) {
		var subtotal = 0;

		var tr = $(elem).closest('tr'),
			quantity = $('[name="invoice_product_qty[]"]', tr).val(),
			price = $('[name="invoice_product_price[]"]', tr).val(),
			isPercent = $('[name="invoice_product_discount[]"]', tr).val().indexOf('%') > -1,
			percent = $.trim($('[name="invoice_product_discount[]"]', tr).val().replace('%', '')),
			subtotal = $.trim($('[name="invoice_product_sub[]"]', tr).val()),
			subtotal = parseInt(quantity) * parseFloat(price);


		if (percent && $.isNumeric(percent) && percent !== 0) {
			if (isPercent) {
				subtotal = subtotal - ((parseFloat(percent) / 100) * subtotal);
			} else {
				subtotal = subtotal - parseFloat(percent);
			}
		} else {
			$('[name="invoice_product_discount[]"]', tr).val('');

		}

		//$(elem).closest('tr').find('.invoice_product_discount',tr).val(subtotal);
		console.log(subtotal);

		$(elem).closest('tr'), $('[name="invoice_product_sub[]"]', tr).val(subtotal.toFixed(2));

	}

	function calculateTotal(elem) {

		var grandTotal = 0,
			disc = 0,
			c_service_charge = parseInt($('.calculate.servicecharge').val()) || 0;

		$('#invoice_table tbody tr').each(function () {
			var c_sbt = $('.calculate-sub', this).val(),
				quantity = $('[name="invoice_product_qty[]"]', this).val(),
				price = $('[name="invoice_product_price[]"]', this).val() || 0,
				subtotal = parseInt(quantity) * parseFloat(price);

			grandTotal += parseFloat(c_sbt);
			disc += subtotal - parseFloat(c_sbt);
		});

		// VAT, DISCOUNT, SHIPPING, TOTAL, SUBTOTAL:
		var subT = parseFloat(grandTotal),
			finalTotal = parseFloat(grandTotal + c_service_charge),
			vat = parseInt($('.invoice-vat').attr('data-vat-rate'));

		$('.invoice-sub-total').text(subT.toFixed(2));
		$('#invoice_subtotal').val(subT.toFixed(2));
		$('.invoice-discount').text(disc.toFixed(2));
		$('#invoice_discount').val(disc.toFixed(2));

		if ($('.invoice-vat').attr('data-enable-vat') === '1') {

			if ($('.invoice-vat').attr('data-vat-method') === '1') {
				$('.invoice-vat').text(((vat / 100) * finalTotal).toFixed(2));
				$('#invoice_vat').val(((vat / 100) * finalTotal).toFixed(2));
				$('.invoice-total').text((finalTotal).toFixed(2));
				$('#invoice_total').val((finalTotal).toFixed(2));
			} else {
				$('.invoice-vat').text(((vat / 100) * finalTotal).toFixed(2));
				$('#invoice_vat').val(((vat / 100) * finalTotal).toFixed(2));
				$('.invoice-total').text((finalTotal + ((vat / 100) * finalTotal)).toFixed(2));
				$('#invoice_total').val((finalTotal + ((vat / 100) * finalTotal)).toFixed(2));
			}
		} else {
			$('.invoice-total').text((finalTotal).toFixed(2));
			$('#invoice_total').val((finalTotal).toFixed(2));
		}

		// remove vat
		if ($('input.remove_vat').is(':checked')) {
			$('.invoice-vat').text("0.00");
			$('#invoice_vat').val("0.00");
			$('.invoice-total').text((finalTotal).toFixed(2));
			$('#invoice_total').val((finalTotal).toFixed(2));
		}

	}

	function actionAddUser() {

		var errorCounter = validateForm();

		function Users_list_page() {
			window.location = "user-list.php";
		}

		function logout() {
			window.location = "logout.php";
		}




		if (errorCounter > 0) {
			$("#response").removeClass("alert-success").addClass("alert-warning").fadeIn();
			$("#response .message").html("<strong>Error</strong>: It appear's you have forgotten to complete something!");
			$("html, body").animate({
				scrollTop: $('#response').offset().top
			}, 1000);
		} else {

			$(".required").parent().removeClass("has-error");

			var $btn = $("#action_add_user").button("loading");

			$.ajax({

				url: 'response.php',
				type: 'POST',
				data: $("#add_user").serialize(),
				dataType: 'json',
				success: function (data) {
					$("#response .message").html("<strong>" + data.status + "</strong>: " + data.message);
					$("#response").removeClass("alert-warning").addClass("alert-success").fadeIn();
					$("html, body").animate({
						scrollTop: $('#response').offset().top
					}, 1000);
					$btn.button("reset");

					//setInterval(Users_list_page, 1500);
					setInterval(logout, 1500);
				},
				error: function (data) {
					$("#response .message").html("<strong>" + data.status + "</strong>: " + data.message);
					$("#response").removeClass("alert-success").addClass("alert-warning").fadeIn();
					$("html, body").animate({
						scrollTop: $('#response').offset().top
					}, 1000);
					$btn.button("reset");
				}

			});
		}

	}

	function actionAddProduct() {

		var errorCounter = validateForm();

		if (errorCounter > 0) {
			$("#response").removeClass("alert-success").addClass("alert-warning").fadeIn();
			$("#response .message").html("<strong>Error</strong>: It appear's you have forgotten to complete something!");
			$("html, body").animate({
				scrollTop: $('#response').offset().top
			}, 1000);
		} else {

			$(".required").parent().removeClass("has-error");

			function procedure_list() {
				window.location = "procedure-list.php";
			}

			var $btn = $("#action_add_product").button("loading");

			$.ajax({

				url: 'response.php',
				type: 'POST',
				data: $("#add_product").serialize(),
				dataType: 'json',
				success: function (data) {
					$("#response .message").html("<strong>" + data.status + "</strong>: " + data.message);
					$("#response").removeClass("alert-warning").addClass("alert-success").fadeIn();
					$("html, body").animate({
						scrollTop: $('#response').offset().top
					}, 1000);

					setInterval(procedure_list, 1500);
					$btn.button("reset");
				},
				error: function (data) {
					$("#response .message").html("<strong>" + data.status + "</strong>: " + data.message);
					$("#response").removeClass("alert-success").addClass("alert-warning").fadeIn();
					$("html, body").animate({
						scrollTop: $('#response').offset().top
					}, 1000);
					$btn.button("reset");
				}

			});
		}

	}

	function actionCreateCustomer() {

		var errorCounter = validateForm();

		function patient_list() {
			window.location = "patient-list.php";
		}

		if (errorCounter > 0) {
			$("#response").removeClass("alert-success").addClass("alert-warning").fadeIn();
			$("#response .message").html("<strong>Error</strong>: It appear's you have forgotten to complete something!");
			$("html, body").animate({
				scrollTop: $('#response').offset().top
			}, 1000);
		} else {

			var $btn = $("#action_create_customer").button("loading");

			$(".required").parent().removeClass("has-error");

			$.ajax({

				url: 'response.php',
				type: 'POST',
				data: $("#create_customer").serialize(),
				dataType: 'json',
				success: function (data) {
					$("#response .message").html("<strong>" + data.status + "</strong>: " + data.message);
					$("#response").removeClass("alert-warning").addClass("alert-success").fadeIn();
					$("html, body").animate({
						scrollTop: $('#response').offset().top
					}, 1000);
					$("#create_customer").before().html("<a href='./patient-add.php' class='btn btn-primary'>Add New Patient</a>");
					setInterval(patient_list, 1500);
					$("#create_cuatomer").remove();


					$btn.button("reset");
				},
				error: function (data) {
					$("#response .message").html("<strong>" + data.status + "</strong>: " + data.message);
					$("#response").removeClass("alert-success").addClass("alert-warning").fadeIn();
					$("html, body").animate({
						scrollTop: $('#response').offset().top
					}, 1000);
					$btn.button("reset");
				}

			});
		}

	}


function actionCreateInvoice_from_invoice()
{


	var errorCounter = validateForm();

	if (errorCounter > 0) {
		$("#response").removeClass("alert-success").addClass("alert-warning").fadeIn();
		$("#response .message").html("<strong>Error</strong>: It appear's you have forgotten to complete something!");
		$("html, body").animate({
			scrollTop: $('#response').offset().top
		}, 1000);
	} else {

		var $btn = $("#action_create_invoice_from_invoice").button("loading");

		$(".required").parent().removeClass("has-error");
		$("#create_invoice").find(':input:disabled').removeAttr('disabled');


		function invoice_create() {
			window.location = "request_from_dr.php";
		}



		$.ajax({

			url: 'response.php',
			type: 'POST',
			data: $("#create_invoice").serialize(),
			dataType: 'json',
			success: function (data) {
				$("#create_invoice").before().html("<a href='invoice-list.php' class='btn btn-primary'>Create new invoice</a>");
				$("#response .message").html("<strong>" + data.status + "</strong>: " + data.message);
				$("#response").removeClass("alert-warning").addClass("alert-success").fadeIn();
				$("html, body").animate({
					scrollTop: $('#response').offset().top
				}, 1000);

				setInterval(invoice_create, 2000);


				$("#create_invoice").remove();
				$btn.button("reset");
			},
			error: function (data) {
				$("#response .message").html("<strong>" + data.status + "</strong>: " + data.message);
				$("#response").removeClass("alert-success").addClass("alert-warning").fadeIn();

				$("html, body").animate({
					scrollTop: $('#response').offset().top
				}, 1000);


				$btn.button("reset");
			}

		});
	}

}





	function actionCreateInvoice() {



		var errorCounter = validateForm();

		if (errorCounter > 0) {
			$("#response").removeClass("alert-success").addClass("alert-warning").fadeIn();
			$("#response .message").html("<strong>Error</strong>: It appear's you have forgotten to complete something!");
			$("html, body").animate({
				scrollTop: $('#response').offset().top
			}, 1000);
		} else {

			var $btn = $("#action_create_invoice").button("loading");

			$(".required").parent().removeClass("has-error");
			$("#create_invoice").find(':input:disabled').removeAttr('disabled');


			function invoice_create() {
				window.location = "invoice-list.php";
			}



			$.ajax({

				url: 'response.php',
				type: 'POST',
				data: $("#create_invoice").serialize(),
				dataType: 'json',
				success: function (data) {
					$("#create_invoice").before().html("<a href='invoice-list.php' class='btn btn-primary'>Create new invoice</a>");
					$("#response .message").html("<strong>" + data.status + "</strong>: " + data.message);
					$("#response").removeClass("alert-warning").addClass("alert-success").fadeIn();
					$("html, body").animate({
						scrollTop: $('#response').offset().top
					}, 1000);

					setInterval(invoice_create, 2000);


					$("#create_invoice").remove();
					$btn.button("reset");
				},
				error: function (data) {
					$("#response .message").html("<strong>" + data.status + "</strong>: " + data.message);
					$("#response").removeClass("alert-success").addClass("alert-warning").fadeIn();

					$("html, body").animate({
						scrollTop: $('#response').offset().top
					}, 1000);


					$btn.button("reset");
				}

			});
		}

	}

	function deleteProduct(productId) {

		jQuery.ajax({

			url: 'response.php',
			type: 'POST',
			data: productId,
			dataType: 'json',
			success: function (data) {
				$("#response .message").html("<strong>" + data.status + "</strong>: " + data.message);
				$("#response").removeClass("alert-warning").addClass("alert-success").fadeIn();
				$("html, body").animate({
					scrollTop: $('#response').offset().top
				}, 1000);
				//$btn.button("reset");
			},
			error: function (data) {
				$("#response .message").html("<strong>" + data.status + "</strong>: " + data.message);
				$("#response").removeClass("alert-success").addClass("alert-warning").fadeIn();
				$("html, body").animate({
					scrollTop: $('#response').offset().top
				}, 1000);
				$btn.button("reset");
			}
		});

	}

	function deleteUser(userId) {

		jQuery.ajax({

			url: 'response.php',
			type: 'POST',
			data: userId,
			dataType: 'json',
			success: function (data) {
				$("#response .message").html("<strong>" + data.status + "</strong>: " + data.message);
				$("#response").removeClass("alert-warning").addClass("alert-success").fadeIn();
				$("html, body").animate({
					scrollTop: $('#response').offset().top
				}, 1000);
				$btn.button("reset");
			},
			error: function (data) {
				$("#response .message").html("<strong>" + data.status + "</strong>: " + data.message);
				$("#response").removeClass("alert-success").addClass("alert-warning").fadeIn();
				$("html, body").animate({
					scrollTop: $('#response').offset().top
				}, 1000);
				$btn.button("reset");
			}
		});

	}

	function deleteCustomer(userId) {

		jQuery.ajax({

			url: 'response.php',
			type: 'POST',
			data: userId,
			dataType: 'json',
			success: function (data) {
				$("#response .message").html("<strong>" + data.status + "</strong>: " + data.message);
				$("#response").removeClass("alert-warning").addClass("alert-success").fadeIn();
				$("html, body").animate({
					scrollTop: $('#response').offset().top
				}, 1000);
			},
			error: function (data) {
				$("#response .message").html("<strong>" + data.status + "</strong>: " + data.message);
				$("#response").removeClass("alert-success").addClass("alert-warning").fadeIn();
				$("html, body").animate({
					scrollTop: $('#response').offset().top
				}, 1000);
			}
		});

	}

	function emailInvoice(invoiceId) {

		jQuery.ajax({

			url: 'response.php',
			type: 'POST',
			data: invoiceId,
			dataType: 'json',
			success: function (data) {
				$("#response .message").html("<strong>" + data.status + "</strong>: " + data.message);
				$("#response").removeClass("alert-warning").addClass("alert-success").fadeIn();
				$("html, body").animate({
					scrollTop: $('#response').offset().top
				}, 1000);
			},
			error: function (data) {
				$("#response .message").html("<strong>" + data.status + "</strong>: " + data.message);
				$("#response").removeClass("alert-success").addClass("alert-warning").fadeIn();
				$("html, body").animate({
					scrollTop: $('#response').offset().top
				}, 1000);
			}
		});

	}

	function deleteInvoice(invoiceId) {

		jQuery.ajax({

			url: 'response.php',
			type: 'POST',
			data: invoiceId,
			dataType: 'json',
			success: function (data) {
				$("#response .message").html("<strong>" + data.status + "</strong>: " + data.message);
				$("#response").removeClass("alert-warning").addClass("alert-success").fadeIn();
				$("html, body").animate({
					scrollTop: $('#response').offset().top
				}, 1000);
				$btn.button("reset");
			},
			error: function (data) {
				$("#response .message").html("<strong>" + data.status + "</strong>: " + data.message);
				$("#response").removeClass("alert-success").addClass("alert-warning").fadeIn();
				$("html, body").animate({
					scrollTop: $('#response').offset().top
				}, 1000);
				$btn.button("reset");
			}
		});

	}

	function updateProduct() {

		var $btn = $("#action_update_product").button("loading");


		function update_product_page() {
			window.location = "procedure-list.php";
		}


		jQuery.ajax({

			url: 'response.php',
			type: 'POST',
			data: $("#update_product").serialize(),
			dataType: 'json',
			success: function (data) {
				$("#response .message").html("<strong>" + data.status + "</strong>: " + data.message);
				$("#response").removeClass("alert-warning").addClass("alert-success").fadeIn();


				setInterval(update_product_page, 2000);


				$("html, body").animate({
					scrollTop: $('#response').offset().top
				}, 1000);

				$btn.button("reset");



			},
			error: function (data) {
				$("#response .message").html("<strong>" + data.status + "</strong>: " + data.message);
				$("#response").removeClass("alert-success").addClass("alert-warning").fadeIn();
				$("html, body").animate({
					scrollTop: $('#response').offset().top
				}, 1000);
				$btn.button("reset");
			}
		});

	}

	function updateUser() {

		var $btn = $("#action_update_user").button("loading");

		function Users_list_page() {
			window.location = "user-list.php";
		}


		function logout() {
			window.location = "logout.php";
		}


		jQuery.ajax({

			url: 'response.php',
			type: 'POST',
			data: $("#update_user").serialize(),
			dataType: 'json',
			success: function (data) {
				$("#response .message").html("<strong>" + data.status + "</strong>: " + data.message);
				$("#response").removeClass("alert-warning").addClass("alert-success").fadeIn();
				$("html, body").animate({
					scrollTop: $('#response').offset().top
				}, 1000);

				//setInterval(Users_list_page, 1500);
				setInterval(logout, 1500);

				$btn.button("reset");
			},
			error: function (data) {
				$("#response .message").html("<strong>" + data.status + "</strong>: " + data.message);
				$("#response").removeClass("alert-success").addClass("alert-warning").fadeIn();
				$("html, body").animate({
					scrollTop: $('#response').offset().top
				}, 1000);
				$btn.button("reset");
			}
		});

	}

	function updateCustomer() {

		var $btn = $("#action_update_customer").button("loading");

		function refresh_update_customer() {
			window.location = "patient-list.php";
		}

		jQuery.ajax({

			url: 'response.php',
			type: 'POST',
			data: $("#update_customer").serialize(),
			dataType: 'json',
			success: function (data) {
				$("#response .message").html("<strong>" + data.status + "</strong>: " + data.message);
				$("#response").removeClass("alert-warning").addClass("alert-success").fadeIn();
				$("html, body").animate({
					scrollTop: $('#response').offset().top
				}, 1000);

				setInterval(refresh_update_customer, 1500);


				$btn.button("reset");
			},
			error: function (data) {
				$("#response .message").html("<strong>" + data.status + "</strong>: " + data.message);
				$("#response").removeClass("alert-success").addClass("alert-warning").fadeIn();
				$("html, body").animate({
					scrollTop: $('#response').offset().top
				}, 1000);
				$btn.button("reset");
			}
		});

	}







	function updateDoctor() {

		var $btn = $("#action_update_doctor").button("loading");

		jQuery.ajax({

			url: 'response.php',
			type: 'POST',
			data: $("#update_doctor").serialize(),
			dataType: 'json',
			success: function (data) {
				$("#response .message").html("<strong>" + data.status + "</strong>: " + data.message);
				$("#response").removeClass("alert-warning").addClass("alert-success").fadeIn();
				$("html, body").animate({
					scrollTop: $('#response').offset().top
				}, 1000);


				setInterval(doctor_list_page, 2500);


				$btn.button("reset");
			},
			error: function (data) {
				$("#response .message").html("<strong>" + data.status + "</strong>: " + data.message);
				$("#response").removeClass("alert-success").addClass("alert-warning").fadeIn();
				$("html, body").animate({
					scrollTop: $('#response').offset().top
				}, 1000);
				$btn.button("reset");
			}
		});

	}







	function updateInvoice() {

		var $btn = $("#action_update_invoice").button("loading");
		$("#update_invoice").find(':input:disabled').removeAttr('disabled');


		function invoice_create() {
			window.location = "invoice-list.php";
		}




		jQuery.ajax({

			url: 'response.php',
			type: 'POST',
			data: $("#update_invoice").serialize(),
			dataType: 'json',
			success: function (data) {
				$("#response .message").html("<strong>" + data.status + "</strong>: " + data.message);
				$("#response").removeClass("alert-warning").addClass("alert-success").fadeIn();
				$("html, body").animate({
					scrollTop: $('#response').offset().top
				}, 1000);

				setInterval(invoice_create, 2000);
				$btn.button("reset");
			},
			error: function (data) {
				$("#response .message").html("<strong>" + data.status + "</strong>: " + data.message);
				$("#response").removeClass("alert-success").addClass("alert-warning").fadeIn();
				$("html, body").animate({
					scrollTop: $('#response').offset().top
				}, 1000);
				$btn.button("reset");
			}
		});

	}

	function downloadCSV(action) {

		jQuery.ajax({

			url: 'response.php',
			type: 'POST',
			data: action,
			dataType: 'json',
			success: function (data) {
				$("#response .message").html("<strong>" + data.status + "</strong>: " + data.message);
				$("#response").removeClass("alert-warning").addClass("alert-success").fadeIn();
				$("html, body").animate({
					scrollTop: $('#response').offset().top
				}, 1000);
			},
			error: function (data) {
				$("#response .message").html("<strong>" + data.status + "</strong>: " + data.message);
				$("#response").removeClass("alert-success").addClass("alert-warning").fadeIn();
				$("html, body").animate({
					scrollTop: $('#response').offset().top
				}, 1000);
			}
		});

	}

	// login function
	function actionLogin() {

		var errorCounter = validateForm();

		if (errorCounter > 0) {

			$("#response").removeClass("alert-success").addClass("alert-warning").fadeIn();
			$("#response .message").html("<strong>Error</strong>: Missing something are we? check and try again!");
			$("html, body").animate({
				scrollTop: $('#response').offset().top
			}, 1000);

		} else {

			var $btn = $("#btn-login").button("loading");

			jQuery.ajax({
				url: 'response.php',
				type: "POST",
				data: $("#login_form").serialize(), // serializes the form's elements.
				dataType: 'json',
				success: function (data) {
					if(data.status == 'Success')
					{ 
					$("#response .message").html("<strong>" + data.status + "</strong>: " + data.message);
					$("#response").removeClass("alert-warning").addClass("alert-success").fadeIn();
					$("html, body").animate({
						scrollTop: $('#response').offset().top
					}, 1000);
					
					$btn.button("reset");

					$("#response").delay(4000).fadeOut('slow')

					window.location = "dashboard.php";
				}
				else if(data.status == 'Error')

				{
				
					$("#response .message").html("<strong>" + data.status + "</strong>: " + data.message);
					$("#response").removeClass("alert-success").addClass("alert-warning").fadeIn();
					$("html, body").animate({
						scrollTop: $('#response').offset().top
					}, 5000);
					$btn.button("reset");
					$("#response").delay(4000).fadeOut('slow')
				}
				
				
				
			},
				error: function (data) {
					
					$("#response .message").html("<strong>" + data.status + "</strong>: " + data.message);
					$("#response").removeClass("alert-success").addClass("alert-warning").fadeIn();
					$("html, body").animate({
						scrollTop: $('#response').offset().top
					}, 5000);
					$btn.button("reset");
				}

			});

		}

	}

	function validateForm() {
		// error handling
		var errorCounter = 0;

		$(".required").each(function (i, obj) {

			if ($(this).val() === '') {
				$(this).parent().addClass("has-error");
				errorCounter++;
			} else {
				$(this).parent().removeClass("has-error");
			}


		});

		return errorCounter;
	}



	function validateFormm() {
		// error handling
		var errorCounter = 0;

		$(".required").each(function (i, obj) {

			if ($(this).val() === '') {
				$(this).parent().addClass("has-error");
				errorCounter++;
			} else {
				$(this).parent().removeClass("has-error");
			}


		});

		return errorCounter;
	}

});