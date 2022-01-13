<?php 
//test($user_company,1);
?>
<div class="app-title">
  <div>
    <h1>Permission Users</h1>
    <p><ul class="app-breadcrumb breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>welcome">Home</a></li>
        <li class="breadcrumb-item">Master</li>
        <li class="breadcrumb-item">Users</li>
        <li class="breadcrumb-item active">Permission Users</li>
  </ul></p>
  </div>
  <!-- <ul class="app-breadcrumb breadcrumb">
    <li class="breadcrumb-item"><a class="btn btn-secondary" href="<?php echo base_url(); ?>master/items">Back</a></li>
  </ul> -->
</div>


<!-- <?php echo form_open(base_url()."master/users/permission_act"); ?> -->
<form class="form-horizontal" method="post" action="<?php echo base_url().'master/users/permission_act'; ?>">
<div class="row">
  <div class="col-md-12">
    <div class="tile">
      <div class="row">
        <div class="col-lg-12">
          <div class="form-group row">
            <label class="control-label col-md-1">NIP</label>
            <div class="col-md-8">: <?php echo $data_user->nip; ?>
              <input class="form-control col-md-3" type="hidden" id="user_id" name="user_id" value="<?php echo $data_user->user_id; ?>">
            </div>
          </div>
          <div class="form-group row">
            <label class="control-label col-md-1">Name</label>
            <div class="col-md-8">: <?php echo $data_user->name; ?></div>
          </div>
          <div class="tile-footer"></div>
        </div>
        <div class="col-lg-4">
          <div class="animated-checkbox">
            <label class="control-label col-12"><h4>PERMISSION MENU</h4></label>
          </div>
          <div class="animated-checkbox">
            <label class="control-label col-5"></label>
            <label><input type="checkbox" id="select_all" /><span class="label-text">Select All</span></label>
          </div>
          <?php 
          $menu = '';
          $asubmenu = array();
          foreach ($submenu as $key => $val) {
            $asubmenu[$val->menu_id]=$val;
          }

          foreach ($data_menu as $key => $value) {
            if(isset($asubmenu[$value->menu_id]->menu_id)){
              $permission_menu_id = $asubmenu[$value->menu_id]->menu_id;
            }else{
              $permission_menu_id = '';
            }
          ?>
          <div class="animated-checkbox">
            <label class="control-label col-5"><?php echo ($menu!=$value->menu_group)? $value->menu_group.'' : ''; ?></label>
            <label>
            <input type="checkbox" <?php echo ($permission_menu_id==$value->menu_id)? 'checked=""' : ''; ?> name="menu_id[]" class="checkbox" value="<?php echo $value->menu_id; ?>"/><span class="label-text"><?php echo $value->menu_name; ?></span></label>
          </div>
          <?php 
          $menu = $value->menu_group;
          }
          ?>
        </div>
        <div class="col-lg-5">
          <div class="animated-checkbox">
            <label class="control-label col-1"></label>
            <label class="control-label"><h4>PERMISSION COMPANY</h4></label>
          </div>
          <div class="animated-checkbox">
            <label class="control-label col-1"></label>
            <label><input type="checkbox" id="select_all2" /><span class="label-text">Select All</span></label>
          </div>
          <?php 
          //test($user_company,0);
          $company = '';
          $acompany = array();
          foreach ($user_company as $key => $value) {
            $acompany[$value->company_id]=$value;
          }
          //test($acompany,0);

          foreach ($data_company as $key => $value) {
            if(isset($acompany[$value->company_id]->user_id)){
              $permission_company = $acompany[$value->company_id]->company_id;
            }else{
              $permission_company = '';
            }
          ?>
          <div class="animated-checkbox">
            <label class="control-label col-1"></label>
            <label>
            <input type="checkbox" <?php echo ($permission_company == $value->company_id)? 'checked=""' : ''; ?> name="company_id[]" class="checkbox2" value="<?php echo $value->company_id; ?>"/><span class="label-text"><?php echo $value->company_name; ?></span></label>
          </div>
          <?php 
          }
          ?>
        </div>

        <!-- <div class="col-lg-5">
          <div class="animated-checkbox">
            <label class="control-label col-12"><h4>PERMISSION COMPANY</h4></label>
          </div>
          <div class="animated-checkbox">
            <label class="control-label col-1"></label>
            <label><input type="checkbox" id="select_all" /><span class="label-text">Select All</span></label>
          </div>
          <?php 
          foreach ($user_company as $key => $value) {
          ?>
          <div class="animated-checkbox">
            <label class="control-label col-md-1"></label>
            <label><input type="checkbox" <?php //echo ($permission_menu_id==$value->menu_id)? 'checked=""' : ''; ?> name="menu_id[]" class="checkbox" value="<?php echo $value->company_id; ?>"/><span class="label-text"><?php echo $value->company_name; ?></span></label>
          </div>
          <?php 
          }
          ?>
        </div> -->
      </div>
      <div class="tile-footer">
        <button class="btn btn-primary" type="submit" id="save"><i class="fa fa-floppy-o"></i> Save</button>&nbsp;&nbsp;&nbsp;
              <a class="btn btn-secondary" href="<?php echo base_url(); ?>master/users/"><i class="fa fa-reply"></i> Cancel</a>
      </div>
    </div>
  </div>
</div>
</form>
<!-- <?php echo form_close(); ?> -->

<script type="text/javascript">
$('#select_all').on('click',function(){
  if(this.checked){
    $('.checkbox').each(function(){
      this.checked = true;
    });
  }else{
    $('.checkbox').each(function(){
      this.checked = false;
    });
  }
});

$('.checkbox').on('click',function(){
    if($('.checkbox:checked').length == $('.checkbox').length){
        $('#select_all').prop('checked',true);
    }else{
        $('#select_all').prop('checked',false);
    }
});

$('#select_all2').on('click',function(){
  if(this.checked){
    $('.checkbox2').each(function(){
      this.checked = true;
    });
  }else{
    $('.checkbox2').each(function(){
      this.checked = false;
    });
  }
});

$('.checkbox2').on('click',function(){
    if($('.checkbox2:checked').length == $('.checkbox2').length){
        $('#select_all2').prop('checked',true);
    }else{
        $('#select_all2').prop('checked',false);
    }
});

</script>