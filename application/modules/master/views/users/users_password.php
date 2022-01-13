<div class="app-title">
  <div>
    <h1>Setting Users</h1>
    <p><ul class="app-breadcrumb breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>welcome">Home</a></li>
        <li class="breadcrumb-item">Master</li>
        <li class="breadcrumb-item active">Users</a></li>
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
        <!-- <form class="form-horizontal"> -->
          <div class="form-group row">
            <label class="control-label col-md-2">NIP</label>
            <div class="col-md-8">: <?php echo $data_user->nip; ?>
              <input class="form-control col-md-3" type="hidden" id="user_id" value="<?php echo $data_user->user_id; ?>">
            </div>
          </div>
          <div class="form-group row">
            <label class="control-label col-md-2">Name</label>
            <div class="col-md-8">: <?php echo $data_user->name; ?>
            </div>
          </div>
          <div class="form-group row">
            <label class="control-label col-md-2">Username</label>
            <div class="col-md-8">
              <input class="form-control col-md-5" type="text" placeholder="Username Aplication" id="username" value="<?php echo $data_user->username; ?>">
            </div>
          </div>
          <div class="form-group row">
            <label class="control-label col-md-2">Password</label>
            <div class="col-md-2">
              <input class="form-control col-md-12" type="password" placeholder="Password" id="password1" value="<?php echo $data_user->password; ?>">
            </div>
            <div class="col-md-2">
              <input class="form-control col-md-12" type="password" placeholder="Konfirmasi Password" id="password2">
            </div>
          </div>
        <!-- </form> -->
      </div>
      <div class="tile-footer">
        <div class="row">
          <div class="col-md-8 col-md-offset-3">
            <button class="btn btn-primary" type="button" id="save"><i class="fa fa-floppy-o"></i> Save</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
$("#users_group").select2().on('select2:select',function(e){});

$('#save').click(
  function(e){
    e.preventDefault();

    if(!$('#username').val()){
      $.notify({
        title: "Erorr : ",
        message: "<strong>Username</strong> Can't Be Empty",
        icon: 'fa fa-times' 
      },{
        type: "danger",
        delay: 1000
      });
      return false;
    }

    if(!$('#password1').val()){
      $.notify({
        title: "Erorr : ",
        message: "<strong>Password</strong> Can't Be Empty",
        icon: 'fa fa-times' 
      },{
        type: "danger",
        delay: 1000
      });
      return false;
    }

    if($('#password1').val() != $('#password2').val()){
      $.notify({
        title: "Erorr : ",
        message: "<strong>Password</strong> And <storng>Konfirmasi Password</storng> No match",
        icon: 'fa fa-times' 
      },{
        type: "danger",
        delay: 1000
      });
      return false;
    }
    
    $.ajax({
      url: baseUrl+'master/users/password_act',
      type : "POST",  
      data: {
        user_id : $('#user_id').val(),
        username: $('#username').val(),
        password1: $('#password1').val()
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
            window.location.href = baseUrl+'welcome'; //will redirect to google.
          }, 2000);
        }
      }
    });

  }
);
</script>