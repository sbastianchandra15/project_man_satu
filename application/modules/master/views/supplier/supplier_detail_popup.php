<?php 
// test($detail,1);
?>
<section class="content-body" style="padding-top:0;">
    <div class="table-responsive">
        <table class="table table-hover table-bordered" id="detail">
            <thead>
                <tr align="center">
                    <th>Item Name</th>
                    <th width="15%">Price</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach ($detail as $key => $value) {
                ?>
                <tr>
                    <td class="popup"><?php echo $value->item_name; ?></td>
                    <td align="right" class="popup"><?php echo money($value->items_price); ?></td>
                </tr>
                <?php 
                }
                ?>
            </tbody>
        </table>
    </div>
</section>