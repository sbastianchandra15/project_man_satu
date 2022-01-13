<?php 
//test($kind_supplier,1);
?>
<div class="app-title">
  <div>
    <h1>Input Supplier</h1>
    <p><ul class="app-breadcrumb breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>welcome">Home</a></li>
        <li class="breadcrumb-item">Master</li>
        <li class="breadcrumb-item">Supplier</li>
        <li class="breadcrumb-item active">Input Supplier</li>
  </ul></p>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="tile">
      <div class="tile-body">
        <form class="form-horizontal">
          <div class="form-group row">
            <label class="control-label col-md-2">Name</label>
            <div class="col-md-2">
              <select class="form-control" id='supplier_kind_id'>
                <option value=""> - </option>
                <?php 
                foreach ($kind_supplier as $key => $value) {
                  echo '<option value="'.$value->supplier_kind_id.'">'.$value->kind_name.'</option>';
                }
                ?>
              </select>
            </div>
            <div class="col-md-5">
              <input class="form-control" type="text" placeholder="Name Supplier" id="name" value="<?php echo isset($new_supplier['name']) ? $new_supplier['name']:''; ?>">
              <input type="hidden" name="items" id="sup_items" value='<?php echo json_encode($new_supplier["items"]); ?>' required />
            </div>

          </div>
          <div class="form-group row">
            <label class="control-label col-md-2">NPWP</label>
            <div class="col-md-3">
              <input class="form-control" type="text" placeholder="NPWP Supplier" id="npwp" value="<?php echo isset($new_supplier['npwp']) ? $new_supplier['npwp']:''; ?>">
            </div>
            <div class="col-md-4">
              <input class="form-control" type="file" id="file_npwp" name="file_npwp" value="<?php echo isset($new_supplier['npwp']) ? $new_supplier['npwp']:''; ?>">
            </div>
            <label style="color: red;padding-top: 20px;padding-left: 0px;"><small>*Max file 3MB</small></label>
          </div>
          <div class="form-group row">
            <label class="control-label col-md-2">SIUP</label>
            <div class="col-md-3">
              <input class="form-control" type="text" placeholder="SIUP Supplier" id="siup" value="<?php echo isset($new_supplier['siup']) ? $new_supplier['siup']:''; ?>">
            </div>
            <!-- <div class="col-md-4">
              <input class="form-control" type="file" id="file_siup" name="file_siup">
            </div> -->
          </div>
          <div class="form-group row">
            <label class="control-label col-md-2">Address</label>
            <div class="col-md-5">
              <textarea class="form-control" rows="4" placeholder="Enter your address" id="address"><?php echo isset($new_supplier['address']) ? $new_supplier['address']:''; ?></textarea>
            </div>
          </div>
          <div class="form-group row">
            <label class="control-label col-md-2">City</label>
            <div class="col-md-3">
              <input class="form-control" type="text" placeholder="City" id="city" value="<?php echo isset($new_supplier['city']) ? $new_supplier['city']:''; ?>">
            </div>
          </div>
          <div class="form-group row">
            <label class="control-label col-md-2">Contact</label>
            <div class="col-md-2">
              <input class="form-control col-md-12" type="text" placeholder="Contact 1" id="contact1" value="<?php echo isset($new_supplier['contact1']) ? $new_supplier['contact1']:''; ?>">
            </div>
            <div class="col-md-2">
              <input class="form-control col-md-12" type="text" placeholder="Contact 2" id="contact2" value="<?php echo isset($new_supplier['contact2']) ? $new_supplier['contact2']:''; ?>">
            </div>
            <div class="col-md-2">
              <input class="form-control col-md-12" type="text" placeholder="Contact 3" id="contact3" value="<?php echo isset($new_supplier['contact3']) ? $new_supplier['contact3']:''; ?>">
            </div>
          </div>
          <div class="form-group row">
            <label class="control-label col-md-2">Email</label>
            <div class="col-md-3">
              <input class="form-control" type="text" placeholder="Email 1" id="email1" value="<?php echo isset($new_supplier['email1']) ? $new_supplier['email1']:''; ?>">
            </div>
            <div class="col-md-3">
              <input class="form-control" type="text" placeholder="Email 2" id="email2" value="<?php echo isset($new_supplier['email2']) ? $new_supplier['email2']:''; ?>">
            </div>
          </div>
          <div class="form-group row">
            <label class="control-label col-md-2">Pic Sales</label>
            <div class="col-md-2">
              <input class="form-control" type="text" placeholder="Pic Sales" id="pic_sales" value="<?php echo isset($new_supplier['pic_sales']) ? $new_supplier['pic_sales']:''; ?>">
            </div>
          </div>
          <div class="form-group row">
            <label class="control-label col-md-2">TOP</label>
            <div class="col-md-1">
              <input class="form-control" type="number" placeholder="Hari" id="top" value="<?php echo isset($new_supplier['top']) ? $new_supplier['top']:''; ?>">
            </div>
            <div class="col-md-1" style="margin-left: -17px;margin-top: 6px;">Days</div>
          </div>
          <div class="form-group row">
            <label class="control-label col-md-2">Info</label>
            <div class="col-md-8">
              <input class="form-control col-md-8" type="text" placeholder="Info Supplier" id="info" value="<?php echo isset($new_supplier['info']) ? $new_supplier['info']:''; ?>">
            </div>
          </div>
          <div class="form-group row">
            <label class="control-label col-md-2">PPN</label>
            <div class="animated-checkbox" style="padding-left: 15px; ">
              <label><input type="checkbox" id="ppn" value="1" <?php echo ($new_supplier['ppn']=='1') ? 'checked=""':''; ?>/><span class="label-text"></span></label>
            </div>
          </div>
        </form>
      </div>
      <div class="tile-footer">
        <div class="form-group row">
          <label class="control-label col-md-2">Items Name</label>
          <div class="col-md-5">
            <select class="form-control" id='item_id'>
              <option value=""> - </option>
              <?php 
              foreach ($data_items as $key => $value) {
                echo '<option data-name="'.$value->items_nama.'" value="'.$value->items_id.'">'.$value->items_nama.'</option>';
              }
              ?>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label class="control-label col-md-2">Items Price</label>
          <div class="col-md-5">
            <input class="form-control col-md-3" type="text" placeholder="Price" id="item_price">
          </div>
        </div>
        <div class="form-group row">
          <label class="control-label col-md-2"></label>
          <div class="col-md-2">
            <button class="btn btn-warning" type="button" id="add-items"><i class="fa fa-plus-square"></i> Add Items</button>
          </div>
          <!-- <label class="control-label col-md-6">Items Name</label>
          <div class="col-md-6">
            <input class="form-control col-md-5" type="text" placeholder="Name Supplier" id="name">
          </div> -->
        </div>
      </div>
      <div class="tile-footer">
        <div class="col-md-8">
          <div class="table-responsive">
            <table class="table table-hover table-bordered" id="detail">
              <thead>
                <tr>
                  <th>Name</th>
                  <th width="20%">Price</th>
                  <th width="10%">Action</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
      <div class="tile-footer">
        <div class="row">
          <div class="col-md-8 col-md-offset-3">
            <button class="btn btn-primary" type="button" id="save"><i class="fa fa-floppy-o"></i> Save</button>&nbsp;&nbsp;&nbsp;
            <a class="btn btn-secondary" href="<?php echo base_url(); ?>master/supplier/reset"><i class="fa fa-reply"></i> Cancel</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php //test($new_supplier,0); ?>

<script type="text/javascript">
supplier = {
  data: {},
  processed: false,
  items: [],
  init: function(){
    $("#npwp").inputmask("99.999.999.9-999.999");
    $("#email1").inputmask({ alias: "email"});
    $("#email2").inputmask({ alias: "email"});
    $("#item_price").inputmask({ 'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'placeholder': '0'});

    $("#item_id").select2().on('select2:select',function(e){});
    $("#supplier_kind_id").select2().on('select2:select',function(e){});

    this.grids = $('#detail').DataTable({
        "paging": false, 
        "bLengthChange": false, // disable show entries dan page
        "bFilter": false,
        "bInfo": false, // disable Showing 0 to 0 of 0 entries
        "bAutoWidth": false,
        "language": {
            "emptyTable": "Tidak Ada Data"
        },
        columns: [
          { data: 'item_name' },
          { data: 'item_price', className: "text-right" }, 
          { data: 'act', className: "text-center" }
        ],
    });
    this._set_items($('#sup_items').val());
    $('#add-items').click(supplier.add_items);
    $('#save').click(supplier.save);

  },

  add_items: function(e){
    e.preventDefault();

    // if(!$('#name').val()){
    //   $.notify({
    //     title: "Erorr : ",
    //     message: "<strong>Supplier Name</strong> Can't Be Empty",
    //     icon: 'fa fa-times' 
    //   },{
    //     type: "danger",
    //     delay: 1000
    //   });
    //   return false;
    // }

    // if(!$('#address').val()){
    //   $.notify({
    //     title: "Erorr : ",
    //     message: "<strong>Address</strong> Can't Be Empty",
    //     icon: 'fa fa-times' 
    //   },{
    //     type: "danger",
    //     delay: 1000
    //   });
    //   return false;
    // }

    // if(!$('#city').val()){
    //   $.notify({
    //     title: "Erorr : ",
    //     message: "<strong>City</strong> Can't Be Empty",
    //     icon: 'fa fa-times' 
    //   },{
    //     type: "danger",
    //     delay: 1000
    //   });
    //   return false;
    // }

    // if(!$('#pic_sales').val()){
    //   $.notify({
    //     title: "Erorr : ",
    //     message: "<strong>PIC Sales</strong> Can't Be Empty",
    //     icon: 'fa fa-times' 
    //   },{
    //     type: "danger",
    //     delay: 1000
    //   });
    //   return false;
    // }

    // if(!$('#top').val()){
    //   $.notify({
    //     title: "Erorr : ",
    //     message: "<strong>TOP</strong> Can't Be Empty",
    //     icon: 'fa fa-times' 
    //   },{
    //     type: "danger",
    //     delay: 1000
    //   });
    //   return false;
    // }

    // if(!$('#info').val()){
    //   $.notify({
    //     title: "Erorr : ",
    //     message: "<strong>Info</strong> Can't Be Empty",
    //     icon: 'fa fa-times' 
    //   },{
    //     type: "danger",
    //     delay: 1000
    //   });
    //   return false;
    // }

    if(!$('#item_id').val()){
      $.notify({
        title: "Erorr : ",
        message: "<strong>Items Name</strong> Can't Be Empty",
        icon: 'fa fa-times' 
      },{
        type: "danger",
        delay: 1000
      });
      $('#item_id').select2('open');
      return false;
    }

    if(!$('#item_price').val()){
      $.notify({
        title: "Erorr : ",
        message: "<strong>Items Price</strong> Can't Be Empty",
        icon: 'fa fa-times' 
      },{
        type: "danger",
        delay: 1000
      });
      $('#item_price').focus();
      return false;
    }

    let item_id   = $('#item_id').val();
    let item_name = $('#item_id option:selected').attr('data-name');
    let item_price= $('#item_price').val();

    if(item_id){
      data = {
        item_id : item_id,
        item_name : item_name,
        item_price: item_price
      };

      supplier._addtogrid(data);
      supplier._clearitem();
      supplier._focusadd();

    }
  },

  _addfile: function(file){

    var fd = new FormData(this);
    fd.append('file_npwp',file.file_npwp);
    // fd.append('file_siup',file.file_siup);

    $.post({
      url: baseUrl+'master/supplier/add_file',
      data: fd,
      cache: false,
      contentType: false,
      processData: false
    });
  },

  _addtogrid: function(data){
    // debugger
    let grids = this.grids;
    let exist = supplier.grids.row('#'+data.item_id).index();
    //
    $('#id').val(data.item_id);

    data.act = '<button item-id="'+data.item_id+'" onclick="return supplier._removefromgrid(this);">x</button>';
    data.DT_RowId = data.item_id;
    //
    if(exist===undefined){
      grids.row.add(data).draw();
    }else{ 
      // data.qty              = parseInt(grids.row(exist).data().qty) + parseInt(data.qty);
      grids.row(exist).data(data).draw(false);
    }

    if(this.no_ajax) return false;

    $.post({
      url: baseUrl+'master/supplier/add_item',
      data: {
        name      : $('#name').val(),
        npwp      : $('#npwp').val(),
        file_npwp : $('#file_npwp').val(),
        siup      : $('#siup').val(),
        address   : $('#address').val(),
        city      : $('#city').val(),
        contact1  : $('#contact1').val(),
        contact2  : $('#contact2').val(),
        contact3  : $('#contact3').val(),
        email1    : $('#email1').val(),
        email2    : $('#email2').val(),
        pic_sales : $('#pic_sales').val(),
        top       : $('#top').val(),
        info      : $('#info').val(),
        ppn       : $('#ppn:checked').val(),
        item_id   : data.item_id,
        item_name : data.item_name,
        item_price: data.item_price
      }
    });
  },

  _set_items: function(items){
    this.no_ajax = true;
    //
    if(items) items = JSON.parse(items);
    this.items = items;
    items.map(function(i,e){
      var data = {
        item_id   : i.item_id,
        item_name : i.item_name,
        item_price: i.item_price
      };
      supplier._addtogrid(data);
      supplier._clearitem();
      supplier._focusadd();
    });
    this.no_ajax = false;

  },

  _clearitem: function(){
    $('#item_id').val('').trigger('change');
    $('#item_price').val('');
  },

  _focusadd: function(){
    $('#item_id').focus();
  },

  _removefromgrid: function(el){

    let id = $(el).attr('item-id');
    supplier.grids.row("#"+id).remove().draw();
    $.get({
      url: baseUrl+'master/supplier/remove_item',
      data: {
        index_id: id
      }
    });
    return false;
  },

  save: function(e){
    let npwp = $('#file_npwp')[0].files[0];
    // let file_siup = $('#file_siup')[0].files[0];

    file = {
      file_npwp : npwp
      // file_siup : file_siup
    };

    supplier._addfile(file);
    e.preventDefault();

    if(!$('#supplier_kind_id').val()){
      $.notify({
        title: "Erorr : ",
        message: "<strong>Supplier Kind</strong> Can't Be Empty",
        icon: 'fa fa-times' 
      },{
        type: "danger",
        delay: 1000
      });
      $('#supplier_kind_id').select2('open');
      return false;
    }

    if(!$('#name').val()){
      $.notify({
        title: "Erorr : ",
        message: "<strong>Supplier Name</strong> Can't Be Empty",
        icon: 'fa fa-times' 
      },{
        type: "danger",
        delay: 1000
      });
      $('#name').focus();
      return false;
    }

    if(!$('#address').val()){
      $.notify({
        title: "Erorr : ",
        message: "<strong>Address</strong> Can't Be Empty",
        icon: 'fa fa-times' 
      },{
        type: "danger",
        delay: 1000
      });
      $('#address').focus();
      return false;
    }

    if(!$('#city').val()){
      $.notify({
        title: "Erorr : ",
        message: "<strong>City</strong> Can't Be Empty",
        icon: 'fa fa-times' 
      },{
        type: "danger",
        delay: 1000
      });
      $('#city').focus();
      return false;
    }

    if(!$('#pic_sales').val()){
      $.notify({
        title: "Erorr : ",
        message: "<strong>PIC Sales</strong> Can't Be Empty",
        icon: 'fa fa-times' 
      },{
        type: "danger",
        delay: 1000
      });
      $('#pic_sales').focus();
      return false;
    }

    // if(!$('#top').val()){
    //   $.notify({
    //     title: "Erorr : ",
    //     message: "<strong>TOP</strong> Can't Be Empty",
    //     icon: 'fa fa-times' 
    //   },{
    //     type: "danger",
    //     delay: 1000
    //   });
    //   return false;
    // }

    if(!$('#info').val()){
      $.notify({
        title: "Erorr : ",
        message: "<strong>Info</strong> Can't Be Empty",
        icon: 'fa fa-times' 
      },{
        type: "danger",
        delay: 1000
      });
      $('#info').focus();
      return false;
    }

    if($('#file_npwp').val()!=''){
      var file_npwp = $('#file_npwp')[0].files[0].name;
    }else{
      var file_npwp = '';
    }
    
    
    $.ajax({
      url: baseUrl+'master/supplier/form_act',
      type : "POST",  
      data: {
        supplier_kind_id : $('#supplier_kind_id').val(),
        name      : $('#name').val(),
        npwp      : $('#npwp').val(),
        file_npwp : file_npwp,
        siup      : $('#siup').val(),
        address   : $('#address').val(),
        city      : $('#city').val(),
        contact1  : $('#contact1').val(),
        contact2  : $('#contact2').val(),
        contact3  : $('#contact3').val(),
        email1    : $('#email1').val(),
        email2    : $('#email2').val(),
        pic_sales : $('#pic_sales').val(),
        top       : $('#top').val(),
        info      : $('#info').val(),
        ppn       : $('#ppn:checked').val(),
        items     : $('#sup_items').val()
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
            window.location.href = baseUrl+'master/supplier/'; 
          }, 2000);
        }
      }
    });

  }
};

supplier.init();
</script>