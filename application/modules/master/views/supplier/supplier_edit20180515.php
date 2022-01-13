<div class="app-title">
  <div>
    <h1>Edit Supplier</h1>
    <p><ul class="app-breadcrumb breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>welcome">Home</a></li>
        <li class="breadcrumb-item">Master</li>
        <li class="breadcrumb-item active"><a href="<?php echo base_url(); ?>master/supplier">Supplier</a></li>
  </ul></p>
  </div>
  <!-- <ul class="app-breadcrumb breadcrumb">
    <li class="breadcrumb-item"><a class="btn btn-secondary" href="<?php echo base_url(); ?>master/items">Back</a></li>
  </ul> -->
</div>
<div class="row">
  <div class="col-md-12">
    <div class="tile">
      <div class="tile-body">
        <form class="form-horizontal">
          <div class="form-group row">
            <label class="control-label col-md-2">Name</label>
            <div class="col-md-8">
              <input class="form-control col-md-5" type="text" placeholder="Name Supplier" id="name" value="<?php echo $data_supplier->supplier_name; ?>">
              <input class="form-control col-md-3" type="hidden" placeholder="Code Items" id="supplier_id" value="<?php echo $data_supplier->supplier_id; ?>">
            </div>
          </div>
          <div class="form-group row">
            <label class="control-label col-md-2">Address</label>
            <div class="col-md-5">
              <textarea class="form-control" rows="4" placeholder="Enter your address" id="address"><?php echo $data_supplier->address; ?></textarea>
            </div>
          </div>
          <div class="form-group row">
            <label class="control-label col-md-2">Contact</label>
            <div class="col-md-2">
              <input class="form-control col-md-12" type="text" placeholder="Contact 1" id="contact1" value="<?php echo $data_supplier->contact1; ?>">
            </div>
            <div class="col-md-2">
              <input class="form-control col-md-12" type="text" placeholder="Contact 2" id="contact2" value="<?php echo $data_supplier->contact2; ?>">
            </div>
          </div>
          <div class="form-group row">
            <label class="control-label col-md-2">Info</label>
            <div class="col-md-8">
              <input class="form-control col-md-8" type="text" placeholder="Info Supplier" id="info" value="<?php echo $data_supplier->supplier_info; ?>">
            </div>
          </div>
        </form>
      </div>
      <div class="tile-footer">
        <div class="row">
          <div class="col-md-8 col-md-offset-3">
            <button class="btn btn-primary" type="button" id="save"><i class="fa fa-floppy-o"></i> Save</button>&nbsp;&nbsp;&nbsp;
            <a class="btn btn-secondary" href="<?php echo base_url(); ?>master/supplier"><i class="fa fa-reply"></i> Cancel</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
$('#save').click(
  function(e){
    e.preventDefault();

    if(!$('#name').val()){
      $.notify({
        title: "Erorr : ",
        message: "<strong>Supplier Name</strong> Tidak Boleh Kosong",
        icon: 'fa fa-times' 
      },{
        type: "danger",
        delay: 1000
      });
      return false;
    }

    if(!$('#address').val()){
      $.notify({
        title: "Erorr : ",
        message: "<strong>Address</strong> Tidak Boleh Kosong",
        icon: 'fa fa-times' 
      },{
        type: "danger",
        delay: 1000
      });
      return false;
    }

    if(!$('#info').val()){
      $.notify({
        title: "Erorr : ",
        message: "<strong>Info</strong> Tidak Boleh Kosong",
        icon: 'fa fa-times' 
      },{
        type: "danger",
        delay: 1000
      });
      return false;
    }
    
    $.ajax({
      url: baseUrl+'master/supplier/edit_act',
      type : "POST",  
      data: {
        supplier_id : $('#supplier_id').val(),
        name    : $('#name').val(),
        address : $('#address').val(),
        contact1: $('#contact1').val(),
        contact2: $('#contact2').val(),
        info    : $('#info').val()
      },
      success : function(resp){
        if(resp.status == 'ERROR INSERT' || resp.status == false) {
          $.notify({
            message: 'Data Gagal disimpan'
          },{
            type: 'danger'
          });
          return false;

        } else {
          $.notify({
            message: 'Data sudah berhasil disimpan'
          },{
            type: 'info'
          });

          setTimeout(function () {
            window.location.href = baseUrl+'master/supplier/'; //will redirect to google.
          }, 2000);
        }
      }
    });

  }
);
</script>