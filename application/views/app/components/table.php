<div class="col-md-12">
    <div class="btn-group pull-right">
        <a class="btn btn-primary btn-sm ko_link" href="<?php echo site_url("home/form/0")?>"><span class="glyphicon glyphicon-plus"></span> New</a>
    </div>
</div>
<table class="table">
    <thead>
        <tr>
            <th>#</th> 
            <th>Name</th> 
            <th>Job</th> 
            <th>Email</th> 
            <th></th>
        </tr>
    </thead>    
    <tbody>
        <?php
        foreach ($person_data as $aPerson) {
            ?>
            <tr>
                <td><?php echo $aPerson['person_id'] ?></td>
                <td><?php echo $aPerson['person_name'] ?></td>
                <td><?php echo $aPerson['person_job'] ?></td>
                <td><?php echo $aPerson['person_email'] ?></td>
                <td>
                    <div class="btn-group pull-right" role="group">
                        <a class="btn btn-sm btn-primary ko_link" href="<?php echo site_url("home/form/$aPerson[person_id]") ?>"><i class="glyphicon glyphicon-pencil"></i> </a>
                        <a class="btn btn-sm btn-primary ko_link" href="<?php echo site_url("home/delete/$aPerson[person_id]/".$this->uri->segment(2)."/".$this->uri->segment(3)) ?>"><i class="glyphicon glyphicon-time"></i></a>
                    </div>
                </td>
            </tr>
            <?php
        }
        ?>

        <tr>
            <td colspan="5">
                <?php echo $pagination ?>
            </td>
        </tr>

    </tbody>
</table>
