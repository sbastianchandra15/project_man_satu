<div class="app-title">
	<div>
		<h1>View Items</h1>
		<p><ul class="app-breadcrumb breadcrumb">
		<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>welcome">Home</a></li>
        <li class="breadcrumb-item">Master</li>
        <li class="breadcrumb-item">Items</li>
        <li class="breadcrumb-item active">View Items</li>
	</ul></p>
	</div>
	<ul class="app-breadcrumb breadcrumb">
		<li class="breadcrumb-item"><a class="btn btn-primary" href="<?php echo base_url(); ?>master/items/form"><i class="fa fa-plus"></i> Input</a></li>
	</ul>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="tile">
      <div class="table-responsive">
        <table class="table table-hover table-bordered" id="itemsTable">
          <thead>
      			<tr>
      				<th>No</th>
      				<th>Code</th>
      				<th>Name</th>
      				<th>Items Unit</th>
      				<th>Items Group</th>
              <th width="12%">Items Category</th>
              <th width="10%">Authorized</th>
      				<th>Action</th>
      			</tr>
          </thead>
          <tbody>
          	<?php 
          	$no = 0;
        		foreach ($data_items as $key => $value) {
        			$no = $no+1;
          	?>
      			<tr>
      				<td><?php echo $no; ?>.</td>
      				<td><?php echo $value->items_code; ?></td>
      				<td><?php echo $value->items_nama; ?></td>
      				<td><?php echo $value->items_unit; ?></td>
      				<td><?php echo $value->items_group; ?></td>
              <td><?php echo $value->items_category_name; ?></td>
              <td><?php echo $value->dept_authorized; ?></td>
      				<td align="center">
      					<a class="btn btn-info btn-sm" href="<?php echo base_url()."master/items/edit/$value->items_id"; ?>"><i class="fa fa-files-o"></i></a>
      					<!-- <a onclick="return confirmDelete()" class="btn btn-warning btn-sm" href="<?php echo base_url()."master/items/delete/$value->items_id"; ?>">Delete</a> -->
      					<button type="button" id='delete' class="element btn btn-danger btn-sm" data-toggle="modal" data-item_code="<?php echo $value->items_code; ?>" data-item_id="<?php echo $value->items_id; ?>"><i class="fa fa-close"></i></button></td>
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
$('#itemsTable').DataTable({
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

$('#itemsTable').on('click','#delete', function (e) {
	var items_id 			= $(this).data('item_id');
	var items_code 	= $(this).data('item_code');

	BootstrapDialog.show({
      title: 'Delete Items ',
      type : BootstrapDialog.TYPE_DANGER,
      message: 'Do you want to delete '+items_code+' ?',
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
                    items_id : items_id
                },
                type : "POST",
                url: baseUrl+'master/items/delete_js',
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
                      window.location.href = baseUrl+'master/items'; //will redirect to google.
                    }, 2000);
                  }
                }
            });

          }
        }
      ],
    });
});

function confirmDelete() {
	return confirm("Anda yakin untuk Menghapus data ini ?");
}
</script>