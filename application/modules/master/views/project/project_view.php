<div class="app-title">
	<div>
		<h1>View Project</h1>
		<p><ul class="app-breadcrumb breadcrumb">
		<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>welcome">Home</a></li>
        <li class="breadcrumb-item">Master</li>
        <li class="breadcrumb-item">Project</li>
        <li class="breadcrumb-item active">View Project</li>
	</ul></p>
	</div>
	<ul class="app-breadcrumb breadcrumb">
		<li class="breadcrumb-item"><a class="btn btn-primary" href="<?php echo base_url(); ?>master/project/form"><i class="fa fa-plus"></i> Input</a></li>
	</ul>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="tile">
      <div class="table-responsive">
        <table class="table table-hover table-bordered" id="itemsTable">
          <thead>
      			<tr>
      				<th width="8%">No</th>
      				<th width="30%">Name</th>
      				<th>Location</th>
      				<th width="15%">Action</th>
      			</tr>
          </thead>
          <tbody>
          	<?php 
          	$no = 0;
        		foreach ($data_project as $key => $value) {
        			$no = $no+1;
          	?>
      			<tr>
      				<td><?php echo $no; ?>.</td>
      				<td><?php echo $value->project_name; ?></td>
      				<td><?php echo $value->project_location; ?></td>
      				<td align="center">
      					<a class="btn btn-info btn-sm" href="<?php echo base_url()."master/project/edit/$value->project_id"; ?>"><i class="fa fa-files-o"></i></a>
      					<button type="button" id='delete' class="element btn btn-danger btn-sm" data-toggle="modal" data-project_id="<?php echo $value->project_id; ?>" data-name="<?php echo $value->project_name; ?>"><i class="fa fa-close"></i></button></td>
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
      	"emptyTable": "Tidak Ada Data"
    },
  	"aaSorting": [],
  	responsive: true
});

$('#itemsTable').on('click','#delete', function (e) {
	var project_id 	= $(this).data('project_id');
	var name        = $(this).data('name');

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
                    project_id : project_id
                },
                type : "POST",
                url: baseUrl+'master/project/delete_js',
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
                      window.location.href = baseUrl+'master/project'; //will redirect to google.
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