<?php if (isset($_SESSION['alert'])): ?>
  <script type="text/javascript">
    Command: toastr["info"]("<?php echo $_SESSION['alert']; ?>", "Hak Akses Menu",{
      "closeButton": true,
    "newestOnTop": true,
    "progressBar": false,
    "positionClass": "toast-top-center",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "5000",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "5000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
    }).css("width","750px");
  </script>
<?php endif; ?>

<div class="app-title">
	<div>
		<h1>View Users</h1>
		<p><ul class="app-breadcrumb breadcrumb">
		<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>welcome">Home</a></li>
        <li class="breadcrumb-item">Master</li>
        <li class="breadcrumb-item">Users</li>
        <li class="breadcrumb-item active">View Users</li>
	</ul></p>
	</div>
	<ul class="app-breadcrumb breadcrumb">
		<li class="breadcrumb-item"><a class="btn btn-primary" href="<?php echo base_url(); ?>master/users/form"><i class="fa fa-plus"></i> Input</a></li>
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
							<th>NIP</th>
							<th>Name</th>
							<th>Username</th>
							<th>User Level</th>
              <th>Email</th>
							<th>Action</th>
						</tr>
          </thead>
          <tbody>
          	<?php 
          	$no = 0;
        		foreach ($data_user as $key => $value) {
        			$no = $no+1;
          	?>
					<tr>
						<td><?php echo $no; ?>.</td>
						<td><?php echo $value->nip; ?></td>
						<td><?php echo $value->name; ?></td>
						<td><?php echo $value->username; ?></td>
						<td><?php echo $value->user_level; ?></td>
            <td><?php echo $value->email; ?></td>
						<td align="center">
              <a class="btn btn-permission btn-sm" href="<?php echo base_url()."master/users/permission/$value->user_id"; ?>"><i class="fa fa-user-o"></i></a>
							<a class="btn btn-info btn-sm" href="<?php echo base_url()."master/users/edit/$value->user_id"; ?>"><i class="fa fa-files-o"></i></a>
							<button type="button" class="element btn btn-danger btn-sm" data-toggle="modal" data-name="<?php echo $value->name; ?>" data-user_id="<?php echo $value->user_id; ?>"><i class="fa fa-close"></i></button></td>
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
      	"emptyTable": "Tidak Ada Data"
    },
  	"aaSorting": [],
    "pageLength": 20,
  	responsive: true
});

$('#supplierTable').on('click','.element', function (e) {
	var user_id = $(this).data('user_id');
	var name 	= $(this).data('name');

	BootstrapDialog.show({
      title: 'Delete Users ',
      type : BootstrapDialog.TYPE_DANGER,
      message: 'Apakah anda ingin menghapus data '+name+' ?',
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
                    user_id : user_id
                },
                type : "POST",
                url: baseUrl+'master/users/delete',
                success : function(resp){

                  if(resp.status == 'ERROR INSERT' || resp.status == false) {
                    alert('Data Tidak berhasil di Hapus');
                    return false;

                  } else {
                    $.notify({
                          icon: "glyphicon glyphicon-save",
                          message: 'Data berhasil dihapus'
                        },{
                          type: 'success',
                          onClosed: function(){ location.reload();}
                        });

                    setTimeout(function () {
                      window.location.href = baseUrl+'master/users/'; //will redirect to google.
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