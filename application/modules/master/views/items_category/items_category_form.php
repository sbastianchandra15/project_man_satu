<div class="app-title">
  <div>
    <h1>Input Items Category</h1>
    <p><ul class="app-breadcrumb breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>welcome">Home</a></li>
        <li class="breadcrumb-item">Master</li>
        <li class="breadcrumb-item">Items Category</li>
        <li class="breadcrumb-item active">Input Items Category</li>
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
              <input class="form-control col-md-7" type="text" placeholder="Items Category Name" id="name">
            </div>
          </div>
          <div class="form-group row">
            <label class="control-label col-md-2">Info</label>
            <div class="col-md-8">
              <input class="form-control col-md-12" type="text" placeholder="Info" id="info">
            </div>
          </div>
        </form>
      </div>
      <div class="tile-footer">
        <div class="row">
          <div class="col-md-8 col-md-offset-3">
            <button class="btn btn-primary" type="button" id="save"><i class="fa fa-floppy-o"></i> Save</button>&nbsp;&nbsp;&nbsp;
            <a class="btn btn-secondary" href="<?php echo base_url(); ?>master/items"></i><i class="fa fa-reply"></i> Cancel</a>
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
        message: "Items Name Can't Be Empty",
        icon: 'fa fa-times' 
      },{
        type: "danger",
        delay: 1000
      });
      $("#name").focus();
      return false;
    }

    if(!$('#info').val()){
      $.notify({
        title: "Erorr : ",
        message: "Items Name Can't Be Empty",
        icon: 'fa fa-times' 
      },{
        type: "danger",
        delay: 1000
      });
      $("#info").focus();
      return false;
    }
    
    $.ajax({
      url: baseUrl+'master/items_category/form_act',
      type : "POST",  
      data: {
        name      : $('#name').val(),
        info      : $('#info').val()
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
            message: 'Data has been save'
          },{
            type: 'info'
          });

          setTimeout(function () {
            window.location.href = baseUrl+'master/items_category/'; //will redirect to google.
          }, 2000);
        }
      }
    });

  }
);
</script>