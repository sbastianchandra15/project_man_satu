<div class="app-title">
  <div>
    <h1>Input Users</h1>
    <p><ul class="app-breadcrumb breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>welcome">Home</a></li>
        <li class="breadcrumb-item">Master</li>
        <li class="breadcrumb-item">Users</li>
        <li class="breadcrumb-item active">Input Users</li>
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
            <div class="col-md-8">
              <input class="form-control col-md-3" type="text" placeholder="NIP User" id="nip">
            </div>
          </div>
          <div class="form-group row">
            <label class="control-label col-md-2">Name</label>
            <div class="col-md-8">
              <input class="form-control col-md-5" type="text" placeholder="Name User" id="name">
            </div>
          </div>
          <div class="form-group row">
            <label class="control-label col-md-2">Username</label>
            <div class="col-md-8">
              <input class="form-control col-md-5" type="text" placeholder="Username Aplication" id="username">
            </div>
          </div>
          <div class="form-group row">
            <label class="control-label col-md-2">Password</label>
            <div class="col-md-2">
              <input class="form-control col-md-12" type="password" placeholder="Password" id="password1">
            </div>
            <div class="col-md-2">
              <input class="form-control col-md-12" type="password" placeholder="Konfirmasi Password" id="password2">
            </div>
          </div>
          <div class="form-group row">
            <label class="control-label col-md-2">Email</label>
            <div class="col-md-8">
              <input class="form-control col-md-5" type="text" placeholder="email" id="email">
            </div>
          </div>
          <div class="form-group row">
            <label class="control-label col-md-2">Users Level</label>
            <div class="col-md-2">
              <select class="form-control" id="user_level">
                <option value="">-</option>
                <?php 
                foreach ($user_level as $key => $value) {
                  echo '<option value="'.$value->user_level_name.'">'.$value->user_level_name.'</option>';
                }
                ?>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label class="control-label col-md-2">Approve Purchasing</label>
            <div class="col-md-2">
              <select class="form-control" id="id_user_level">
                <option value="">-</option>
                <?php 
                foreach ($approve_level as $key => $value) {
                  if($value->user_level_code=='GM'){
                    $nama = 'BOD';
                  }elseif($value->user_level_code=='MG'){
                    $nama = 'Approve Department';
                  }
                  echo '<option value="'.$value->id_user_level.'">'.$nama.'</option>';
                }
                ?>
              </select>
            </div>
          </div>
          <!-- <div class="form-group row">
            <label class="control-label col-md-2">Users Group</label>
            <div class="col-md-2">
              <select class="form-control" id="users_group">
                <option value="">-</option>
                <?php 
                foreach ($user_group as $key => $value) {
                  echo '<option value="'.$value->id_user_group.'">'.$value->name.'</option>';
                }
                ?>
              </select>
            </div>
          </div> -->
          <div class="form-group row">
            <label class="control-label col-md-2">Users Group</label>
            <div class="col-md-8 row">
            <?php 
            foreach ($user_group as $key => $value) {
            ?>
              <div class="col-md-3">
                <div class="animated-checkbox">
                  <label><input type="checkbox" id="id_user_group" name="id_user_group" class="checkbox" value="<?php echo $value->id_user_group; ?>"/><span class="label-text"><?php echo $value->name; ?></span></label>
                </div>
              </div>
            <?php 
            }
            ?>
            </div>
          </div>
        <!-- </form> -->
      </div>
      <div class="tile-footer">
        <div class="row">
          <div class="col-md-8 col-md-offset-3">
            <button class="btn btn-primary" type="button" id="save"><i class="fa fa-floppy-o"></i> Save</button>&nbsp;&nbsp;&nbsp;
            <a class="btn btn-secondary" href="<?php echo base_url(); ?>master/users/"><i class="fa fa-reply"></i> Cancel</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
$("#users_group").select2().on('select2:select',function(e){});
$("#user_level").select2().on('select2:select',function(e){});
$("#id_user_level").select2().on('select2:select',function(e){});

$('#save').click(
  function(e){
    e.preventDefault();

    if(!$('#nip').val()){
      $.notify({
        title: "Erorr : ",
        message: "<strong>NIP</strong> Can't Be Empty",
        icon: 'fa fa-times' 
      },{
        type: "danger",
        delay: 1000
      });
      return false;
    }

    if(!$('#name').val()){
      $.notify({
        title: "Erorr : ",
        message: "<strong>Name</strong> Can't Be Empty",
        icon: 'fa fa-times' 
      },{
        type: "danger",
        delay: 1000
      });
      return false;
    }

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
        message: "<strong>Password</strong> And <storng>Konfirmasi Password</storng> Not match",
        icon: 'fa fa-times' 
      },{
        type: "danger",
        delay: 1000
      });
      return false;
    }

    if(!$('#email').val()){
      $.notify({
        title: "Erorr : ",
        message: "<strong>Email</strong> Can't Be Empty",
        icon: 'fa fa-times' 
      },{
        type: "danger",
        delay: 1000
      });
      return false;
    }

    // if(!$('#users_group').val()){
    //   $.notify({
    //     title: "Erorr : ",
    //     message: "<strong>Users Group</strong> Can't Be Empty",
    //     icon: 'fa fa-times' 
    //   },{
    //     type: "danger",
    //     delay: 1000
    //   });
    //   return false;
    // }
    if(!$('#user_level').val()){
      $.notify({
        title: "Erorr : ",
        message: "<strong>Users Group</strong> Can't Be Empty",
        icon: 'fa fa-times' 
      },{
        type: "danger",
        delay: 1000
      });
      return false;
    }

    

    
    
    var lang = [];

    $("input[name='id_user_group']:checked").each(function(){
      lang.push(this.value);
    });


    $.ajax({
      url: baseUrl+'master/users/form_act',
      type : "POST",  
      data: {
        nip           : $('#nip').val(),
        name          : $('#name').val(),
        username      : $('#username').val(),
        password1     : $('#password1').val(),
        email         : $('#email').val(),
        user_level    : $('#user_level').val(),
        id_user_level : $('#id_user_level').val(),
        users_group   : 0,
        lang          : lang
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
            window.location.href = baseUrl+'master/users/'; //will redirect to google.
          }, 2000);
        }
      }
    });

  }
);
</script>