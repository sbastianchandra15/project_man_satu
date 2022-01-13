<div class="app-title">
	<div>
		<h1>View Supplier</h1>
		<p><ul class="app-breadcrumb breadcrumb">
		<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>welcome">Home</a></li>
        <li class="breadcrumb-item">Master</li>
        <li class="breadcrumb-item">Supplier</li>
        <li class="breadcrumb-item active">View Supplier</li>
	</ul></p>
	</div>
	<ul class="app-breadcrumb breadcrumb">
		<li class="breadcrumb-item"><a class="btn btn-primary" href="<?php echo base_url(); ?>master/supplier/form"><i class="fa fa-plus"></i> Input</a></li>
	</ul>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="tile">
      <div class="table-responsive">
        <table class="table table-hover table-bordered" id="supplierTable">
          <thead>
						<tr>
							<th>No</th>
              <th>Code</th>
							<th>Name</th>
							<th>Address</th>
							<th>Contacts</th>
							<th>Supplier Info</th>
              <th>File</th>
							<th>Action</th>
						</tr>
          </thead>
          <tbody>
          	<?php 
          	$no = 0;
        		foreach ($data_supplier as $key => $value) {
        			$no = $no+1;
              $file = str_replace(" ","_",$value->supplier_name);
          	?>
						<tr>
							<td><?php echo $no; ?>.</td>
              <td><a href="#" id='detail' onclick="return show_detail(this)" data-id="<?php echo $value->supplier_id; ?>" data-supplier_code="<?php echo $value->supplier_code; ?>"><?php echo $value->supplier_code; ?></a></td>
							<td><?php echo $value->kind_name; ?> <?php echo $value->supplier_name; ?></td>
							<td><?php echo $value->address; ?></td>
							<td><?php echo $value->contact1.' / '.$value->contact2; ?></td>
							<td><?php echo $value->supplier_info; ?></td>
              <td><?php echo $value->file_npwp!=''? '<a target="_blank" href="'. base_url().'file_upload/'.$value->file_npwp.'">File</a>' : '' ?></td>
							<td align="center">
								<a class="btn btn-info btn-sm" href="<?php echo base_url()."master/supplier/edit/$value->supplier_id"; ?>"><i class="fa fa-files-o"></i></a>
								<!-- <a onclick="return confirmDelete()" class="btn btn-warning btn-sm" href="<?php echo base_url()."master/items/delete/$value->supplier_id"; ?>">Delete</a> -->
								<button type="button" class="element btn btn-danger btn-sm" data-toggle="modal" data-name="<?php echo $value->supplier_name; ?>" data-supplier_id="<?php echo $value->supplier_id; ?>"><i class="fa fa-close"></i></button></td>
						</tr>
						<?php 
						}
						?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
$('#supplierTable').DataTable({
  	"paging": true, 
  	"bLengthChange": false, // disable show entries dan page
  	"bFilter": true,
  	"bInfo": true, // disable Showing 0 to 0 of 0 entries
  	"bAutoWidth": false,
  	"language": {
      	"emptyTable": "No Data"
    },
  	"aaSorting": [],
  	responsive: true
});

$('#supplierTable').on('click','.element', function (e) {
	var supplier_id 			= $(this).data('supplier_id');
	var name 	= $(this).data('name');

	BootstrapDialog.show({
      title: 'Delete Items ',
      type : BootstrapDialog.TYPE_DANGER,
      message: 'Do you want to delete '+name+' ?',
      closable: false,
      buttons: [
        {
          label: '<i class="fa fa-reply"></i> Cancel', cssClass: 'btn',
          action: function(dia){
            dia.close();
          }
        },
        {
          label: '<i class="fa fa-close"></i> Delete', cssClass: 'btn-danger', id: 'update_sales', //hotkey: 'alt'+'s',
          // icon: 'glyphicon glyphicon-check',
          action: function(dia){
            dia.close();
            $.ajax({
                data: {
                    supplier_id : supplier_id
                },
                type : "POST",
                url: baseUrl+'master/supplier/delete_js',
                success : function(resp){

                  if(resp.status == 'ERROR INSERT' || resp.status == false) {
                    alert('Data Tidak berhasil di Hapus');
                    return false;

                  } else {
                    $.notify({
                          icon: "glyphicon glyphicon-save",
                          message: 'Data successfully deleted'
                        },{
                          type: 'success',
                          onClosed: function(){ location.reload();}
                        });

                    setTimeout(function () {
                      window.location.href = baseUrl+'master/supplier'; //will redirect to google.
                    }, 2000);
                  }
                }
            });

          }
        }
      ],
    });
});

function show_detail(e){
  let noId      = $(e).data('id');
  let noRq      = $(e).data('supplier_code');

  $.get({
    url: baseUrl + 'master/supplier/view_popup/'+noId,
    success: function(resp){
      BootstrapDialog.show({
        title: 'Nomor Supplier # <strong> '+noRq+' </strong>', 
        nl2br: false, 
        message: resp,
        closable: true,
        size: 'size-full',
        buttons:[
          {
            label: 'Tutup',
            action: function(dia){ dia.close(); }
          }
        ]
      });
    },
    complete: function(){
      $('body').css('cursor','default');
    }
  });
  return false;
  
};
</script>